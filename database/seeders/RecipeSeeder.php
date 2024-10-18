<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Database\Seeder;
use JsonMachine\Items;
use Illuminate\Support\Facades\Http;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        // S3 file URL
        $s3Url = 'https://recipeze.s3.eu-north-1.amazonaws.com/all_recipes4.json';
        $localFilePath = database_path('seeders/all_recipes4.json');

        // Download the file locally if it does not exist
        if (!file_exists($localFilePath)) {
            $this->command->info('Downloading the recipes JSON file from S3...');

            try {
                $response = Http::timeout(300) // Set the timeout to 300 seconds (5 minutes)
                ->withoutVerifying()
                    ->get($s3Url);

                if ($response->ok()) {
                    file_put_contents($localFilePath, $response->body());
                    $this->command->info('File downloaded and saved locally.');
                } else {
                    $this->command->error('Failed to download the file from S3. Please check the URL or permissions.');
                    return;
                }
            } catch (\Exception $e) {
                $this->command->error('Error while downloading: ' . $e->getMessage());
                return;
            }
        }

        if (!file_exists($localFilePath) || !is_readable($localFilePath)) {
            $this->command->error('File does not exist or is not readable.');
            return;
        }

        $this->command->info('Clearing existing data...');
        Ingredient::query()->delete();
        Recipe::query()->delete();
        $this->command->info('Starting to import recipes...');

        $jsonStream = Items::fromFile($localFilePath);
        $batchSize = 100;
        $recipes = [];
        $recipeCount = 0;
        $maxRecipes = 3790; // Maximum number of recipes to process

        foreach ($jsonStream as $recipeData) {
            if (!isset($recipeData->name)) {
                $this->command->warn('Skipping recipe with missing name.');
                continue;
            }

            $recipes[] = $recipeData;

            if (count($recipes) >= $batchSize) {
                $this->processRecipes($recipes, $recipeCount, $maxRecipes);
                $recipeCount += count($recipes);
                $recipes = [];

                // Stop processing if the limit is reached
                if ($recipeCount >= $maxRecipes) {
                    $this->command->info("Reached the limit of $maxRecipes recipes. Stopping import.");
                    break;
                }
            }
        }

        // Process remaining recipes if the limit hasn't been reached
        if (!empty($recipes) && $recipeCount < $maxRecipes) {
            $this->processRecipes($recipes, $recipeCount, $maxRecipes);
            $recipeCount += count($recipes);
        }

        $this->command->info("Import completed! $recipeCount recipes imported.");
    }

    /**
     * Process and insert recipes into the database.
     *
     * @param array $recipes
     * @param int $recipeCount
     * @param int $maxRecipes
     * @return void
     */
    protected function processRecipes(array $recipes, int $recipeCount, int $maxRecipes)
    {
        foreach ($recipes as $recipeData) {
            // Stop if we've reached the maximum number of recipes
            if ($recipeCount >= $maxRecipes) {
                return;
            }

            if (!isset($recipeData->name)) {
                $this->command->warn('Skipping recipe with missing name.');
                continue;
            }

            try {
                $recipe = Recipe::create([
                    'name' => $recipeData->name ?? 'Unnamed Recipe',
                    'instructions' => isset($recipeData->instructions)
                        ? implode("\n", array_column($recipeData->instructions, 'display_text'))
                        : '',
                    'description' => $recipeData->description ?? null,
                    'thumbnail_url' => $recipeData->thumbnail_url ?? null,
                    'cook_time_minutes' => $recipeData->cook_time_minutes ?? 0,
                    'prep_time_minutes' => $recipeData->prep_time_minutes ?? 0,
                    'num_servings' => $recipeData->num_servings ?? 0,
                    'calories' => $recipeData->nutrition->calories ?? 0,
                    'nutrition' => json_encode($recipeData->nutrition ?? []),
                    'original_video_url' => $recipeData->original_video_url ?? null,
                ]);

                if (isset($recipeData->sections[0]->components)) {
                    foreach ($recipeData->sections[0]->components as $component) {
                        Ingredient::create([
                            'recipe_id' => $recipe->id,
                            'name' => $component->ingredient->name ?? 'Unknown Ingredient',
                            'quantity' => $component->measurements[0]->quantity ?? null,
                            'unit' => $component->measurements[0]->unit->name ?? null,
                        ]);
                    }
                }
            } catch (\Exception $e) {
                $this->command->error('Error importing recipe: ' . $e->getMessage());
            }

            $recipeCount++;
        }

        $this->command->info('Processed ' . count($recipes) . ' recipes in the batch.');
    }
}
