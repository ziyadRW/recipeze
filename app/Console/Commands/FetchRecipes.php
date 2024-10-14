<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchRecipes extends Command
{
    protected $signature = 'fetch:recipes';
    protected $description = 'Fetch all recipes from the Tasty API and save them to a JSON file';

    public function handle()
    {
        ini_set('memory_limit', '-1');
        $totalRecipes = 11000;
        $recipesPerPage = 40;
        $apiKey = 'f830be2131msha99f2ca579e19d6p1c9d74jsnb821589347cd';
        $apiHost = 'tasty.p.rapidapi.com';
        $filePath = 'C:/Users/ASUS/Documents/all_recipes4.json';

        $file = fopen($filePath, 'a');
        fwrite($file, "[\n");

        $retryCount = 0;
        $maxRetries = 5;
        $initialDelay = 5;

        for ($i = 0; $i < ceil($totalRecipes / $recipesPerPage); $i++) {
            try {
                $response = Http::withHeaders([
                    'x-rapidapi-key' => $apiKey,
                    'x-rapidapi-host' => $apiHost,
                ])->withOptions([
                    'verify' => false,
                    'timeout' => 120000000,
                ])->get('https://tasty.p.rapidapi.com/recipes/list', [
                    'from' => $i * $recipesPerPage,
                    'size' => $recipesPerPage,
                ]);

                if ($response->successful()) {
                    $recipes = $response->json()['results'] ?? [];
                    if($i % 10 === 0){
                        $this->info("Fetched page " . ($i+1) . ": " . count($recipes) . " recipes. at ".  date('g:i A'));
                    }
                    foreach ($recipes as $recipe) {
                        fwrite($file, json_encode($recipe, JSON_PRETTY_PRINT) . ",\n");
                    }
                    $retryCount = 0;
                    sleep($initialDelay);

                } else {
                    if ($response->status() == 429) {
                        $retryAfter = (int)($response->header('Retry-After') ?? 60);
                        $this->warn("Rate limit reached. Retrying after " . $retryAfter . " seconds...");
                        sleep($retryAfter);
                        $i--;
                    } else {
                        throw new \Exception("API returned status: " . $response->status());
                    }
                }

            } catch (\Exception $e) {
                $retryCount++;

                if ($retryCount <= $maxRetries) {
                    $backoffTime = $initialDelay * pow(2, $retryCount); // Exponential backoff
                    $this->warn("Error fetching page " . ($i + 1) . ": " . $e->getMessage() . " - Retrying in " . $backoffTime . " seconds...");
                    sleep($backoffTime);
                    $i--;
                } else {
                    $this->error("Max retries reached. Stopping the fetch process.");
                    break;
                }
            }
        }

        fwrite($file, "\n]");
        fclose($file);

        $this->info("Recipes successfully fetched and saved to: " . $filePath);
    }
}
