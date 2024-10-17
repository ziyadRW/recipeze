<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    public function index(Request $request){
        $savedRecipes = Recipe::paginate(10);
        if ($request->is('api/*')) {
            return response()->json([
                'recipes' => $savedRecipes
            ]);
        } else {
            return view('recipes.saved', compact('savedRecipes'));
        }
    }

    public function listRecipes(Request $request)
    {
        $ingredientInput = $request->query('ingredient', '');
        $hasVideo = $request->has('has_video');
        $page = $request->input('page', 1);
        $perPage = 9;
        $user = auth()->user();
        $savedRecipeIds = $user->savedRecipes->pluck('id')->toArray();

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
            'savedRecipeIds' => $savedRecipeIds
        ]);
    }

    public function showRecipe($id)
    {
        $recipe = Recipe::with('ingredients')->findOrFail($id);
        $user = auth()->user();
        $savedRecipeIds = $user->savedRecipes->pluck('id')->toArray();
        return view('recipes.show', [
            'recipe' => $recipe,
            'savedRecipeIds' => $savedRecipeIds
        ]);
    }

    public function toggleBookmarkRecipe($id)
    {
        $recipe = Recipe::findOrFail($id);
        $user = auth()->user();

        if ($user->savedRecipes()->where('recipe_id', $id)->exists()) {
            $user->savedRecipes()->detach($id);
            return back()->with('infoToaster','Recipe removed from saved recipes');
        } else {
            $user->savedRecipes()->attach($id);
            return back()->with('successToaster', 'Recipe saved successfully');
        }
        return back()->with('errorToaster', 'Failed to bookmark Recipe');
    }

    public function listSavedRecipes()
    {
        $user = auth()->user();
        $savedRecipes = $user->savedRecipes()->paginate(10);
        $savedRecipeIds = $user->savedRecipes->pluck('id')->toArray();

        return view('recipes.saved', [
            'savedRecipes' => $savedRecipes,
            'savedRecipeIds' => $savedRecipeIds
        ]);
    }

}
