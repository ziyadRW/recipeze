<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;
class RecipeController extends Controller
{
    public function generateRecipes(Request $request)
    {
        $ingredient = $request->query('ingredient', '');

        $response = Http::withOptions(['verify' => false])->get('https://www.themealdb.com/api/json/v1/1/filter.php', [
            'i' => $ingredient
        ]);

        $recipes = $response->json()['meals'] ?? [];

        $perPage = 9;
        $page = $request->input('page', 1);
        $recipesCollection = collect($recipes);

        $paginatedRecipes = new LengthAwarePaginator(
            $recipesCollection->forPage($page, $perPage),
            $recipesCollection->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('recipes.generate', compact('paginatedRecipes', 'ingredient'));
    }

    public function showRecipe($id)
    {
        $response = Http::withOptions([
            'verify' => false,
        ])->get('https://www.themealdb.com/api/json/v1/1/lookup.php?i=' . $id);
        $recipe = $response->json()['meals'][0];

        return view('recipes.show', compact('recipe'));
    }

}
