<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

class RecipeController extends Controller
{
    public function generateRecipes(Request $request)
    {
        $ingredientInput = $request->query('ingredient', '');
        $hasVideo = $request->has('has_video');
        $page = $request->input('page', 1);
        $perPage = 9;
        $from = ($page - 1) * $perPage;

        $allRecipes = [];
        $ingredients = $ingredientInput ? array_map('trim', explode(',', $ingredientInput)) : [];

        $response = Http::withHeaders([
            'x-rapidapi-key' => 'f830be2131msha99f2ca579e19d6p1c9d74jsnb821589347cd',
            'x-rapidapi-host' => 'tasty.p.rapidapi.com'
        ])->withOptions([
            'verify' => false
        ])->get('https://tasty.p.rapidapi.com/recipes/list', [
            'from' => $from,
            'size' => $perPage,
            'q' => implode(',', $ingredients)
        ]);

        $recipes = $response->json()['results'] ?? [];
        $totalResults = $response->json()['count'] ?? 0;

        if ($hasVideo) {
            $recipes = array_filter($recipes, function ($recipe) {
                return isset($recipe['original_video_url']) && !empty($recipe['original_video_url']);
            });
        }
        $paginatedRecipes = new LengthAwarePaginator(
            $recipes,
            $totalResults,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('recipes.generate', compact('paginatedRecipes', 'ingredientInput'));
    }
    public function showRecipe($id)
    {
        $response = Http::withHeaders([
            'x-rapidapi-key' => 'f830be2131msha99f2ca579e19d6p1c9d74jsnb821589347cd',
            'x-rapidapi-host' => 'tasty.p.rapidapi.com'
        ])->withOptions([
            'verify' => false
        ])->get('https://tasty.p.rapidapi.com/recipes/get-more-info', [
            'id' => $id
        ]);

        $recipe = $response->json();

        return view('recipes.show', compact('recipe'));
    }
}
