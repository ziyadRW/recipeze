<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Recipe;
use App\Models\Ingredient;
use JsonMachine\Items;

class Import extends Command
{
    protected $signature = 'app:import';
    protected $description = 'Import recipes from a JSON file';

    public function handle()
    {
        ini_set('memory_limit', '-1');
        $filePath = '/home/ziyad-alruwaished/Documents/all_recipes4.json';

        if (!file_exists($filePath) || !is_readable($filePath)) {
            $this->error('File does not exist or is not readable.');
            return;
        }
        $this->info('Clearing existing data...');
        Ingredient::query()->delete();
        Recipe::query()->delete();
        $this->info('Starting to import recipes...');

        $jsonStream = Items::fromFile($filePath);
        $batchSize = 100;
        $recipes = [];
        $recipeCount = 0;

        foreach ($jsonStream as $key => $recipeData) {
            if (!isset($recipeData->name)) {
                $this->warn('Skipping recipe with missing name.');
                continue;
            }
            $recipes[] = $recipeData;
            if (count($recipes) >= $batchSize) {
                $this->processRecipes($recipes);
                $recipeCount += count($recipes);
                $recipes = [];
            }
        }
        if (!empty($recipes)) {
            $this->processRecipes($recipes);
            $recipeCount += count($recipes);
        }

        $this->info("Import completed! $recipeCount recipes imported.");
    }

    /**
     * Process and insert recipes into the database.
     *
     * @param array $recipes
     * @return void
     */
    protected function processRecipes(array $recipes)
    {
        foreach ($recipes as $recipeData) {
            if (!isset($recipeData->name)) {
                $this->warn('Skipping recipe with missing name.');
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
                $this->error('Error importing recipe: ' . $e->getMessage());
            }
        }

        $this->info('Processed ' . count($recipes) . ' recipes in this batch.');
    }
}
