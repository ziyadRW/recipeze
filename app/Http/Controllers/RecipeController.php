<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    public function listRecipes(Request $request)
    {
        $ingredientInput = $request->query('ingredient', '');
        $hasVideo = $request->has('has_video');
        $page = $request->input('page', 1);
        $perPage = 9;

        $ingredients = $ingredientInput ? array_map('trim', explode(',', $ingredientInput)) : [];

        $query = Recipe::with('ingredients');

        if (!empty($ingredients)) {
            $query->whereHas('ingredients', function($q) use ($ingredients) {
                $q->whereIn('name', $ingredients);
            });
        }

        if ($hasVideo) {
            $query->whereNotNull('original_video_url');
        }

        $recipes = $query->paginate($perPage, ['*'], 'page', $page);

        return view('recipes.list', [
            'paginatedRecipes' => $recipes,
            'ingredientInput' => $ingredientInput,
        ]);
    }

    public function showRecipe($id)
    {
        $recipe = Recipe::with('ingredients')->findOrFail($id);

        return view('recipes.show', compact('recipe'));
    }

    public function toggleBookmarkRecipe($id)
    {
        $recipe = Recipe::find($id);

        if($recipe){
            if(!$recipe->saved){
                $recipe->saved= true;
                $recipe->save();
                return back()->with('successToaster', 'Recipe added to saved Recipes');
            }
            $recipe->saved= false;
            $recipe->save();
            return back()->with('infoToaster', 'Recipe removed from saved Recipes');
        }
        return back()->with('errorToaster', 'Failed to bookmark Recipe');
    }

    public function listSavedRecipes()
    {
        $savedRecipes = Recipe::where('saved', true)->paginate(9);
        return view('recipes.saved', compact('savedRecipes'));
    }
}
