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

        // Google Drive file download link
        $googleDriveUrl = 'https://drive.google.com/uc?export=download&id=1HdycJGGpm2RITO4MHLkyuDxeCfYxGkjF';
        $filePath = database_path('seeders/all_recipes.json');

        // Check if the file already exists locally, if not, download it
        if (!file_exists($filePath)) {
            $this->command->info('Downloading the recipes JSON file from Google Drive...');
            $response = Http::get($googleDriveUrl);

            if ($response->ok()) {
                file_put_contents($filePath, $response->body());
                $this->command->info('File downloaded and saved locally.');
            } else {
                $this->command->error('Failed to download the file from Google Drive.');
                return;
            }
        }

        if (!file_exists($filePath) || !is_readable($filePath)) {
            $this->command->error('File does not exist or is not readable.');
            return;
        }

        $this->command->info('Clearing existing data...');
        Ingredient::query()->delete();
        Recipe::query()->delete();
        $this->command->info('Starting to import recipes...');

        $jsonStream = Items::fromFile($filePath);
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
