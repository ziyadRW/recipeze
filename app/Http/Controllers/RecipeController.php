<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Ingredient;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Http;

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
        $searchTerm = $request->input('search', '');
        $hasVideo = $request->has('has_video');
        $perPage = 9;

        $user = auth()->user();
        $savedRecipeIds = $user->savedRecipes->pluck('id')->toArray();

        $query = Recipe::query();

        if (!empty($searchTerm)) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        if ($hasVideo) {
            $query->whereNotNull('original_video_url');
        }
        $recipes = $query->paginate($perPage);

        return view('recipes.list', [
            'paginatedRecipes' => $recipes,
            'searchTerm' => $searchTerm,
            'hasVideo' => $hasVideo,
            'savedRecipeIds' => $savedRecipeIds,
        ]);
    }



    public function generatedRecipes(Request $request)
    {
        $user = auth()->user();
        $perPage = 9;
        $page = $request->input('page', 1);
        $userIngredients = $user->ingredients->pluck('name')->toArray();
        $recipes = Recipe::with('ingredients')
            ->whereHas('ingredients', function ($query) use ($userIngredients) {
                $query->whereIn('name', $userIngredients);
            })
            ->get()
            ->map(function ($recipe) use ($userIngredients) {
                $recipeIngredients = $recipe->ingredients->pluck('name')->toArray();
                $missingIngredients = array_diff($recipeIngredients, $userIngredients);
                $recipe->missing_count = count($missingIngredients);
                $recipe->missing_ingredients = $missingIngredients;
                $recipe->full_ingredients = empty($missingIngredients);
                return $recipe;
            });
        $sortedRecipes = $recipes->sortBy(function ($recipe) {
            return [$recipe->missing_count, $recipe->name];
        })->values();
        $paginatedRecipes = new LengthAwarePaginator(
            $sortedRecipes->forPage($page, $perPage),
            $sortedRecipes->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
        $savedRecipeIds = $user->savedRecipes->pluck('id')->toArray();

        return view('recipes.generated', [
            'paginatedRecipes' => $paginatedRecipes,
            'savedRecipeIds' => $savedRecipeIds,
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
