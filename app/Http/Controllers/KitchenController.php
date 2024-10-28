<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $ingredients = $user->ingredients()->orderBy('name')->get();
        $savedIngredientIds = $user->ingredients->pluck('id')->toArray();
        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'my kitchen page :',
                'ingredients' => $ingredients,
                'savedIngredientIds' => $savedIngredientIds
                    ]);
        }
            return view('kitchen.index',[
            'ingredients' => $ingredients,
            'savedIngredientIds' => $savedIngredientIds
        ]);
    }

    public function toggleIngredientAvailability($id, Request $request)
    {
        $user = auth()->user();
        $ingredient = Ingredient::findOrFail($id);

        if ($user->ingredients->contains($ingredient)) {
            $user->ingredients()->detach($ingredient);
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ingredient removed from My Kitchen',
                    'ingredient' => $ingredient
                ]);
            }
            return back()->with('infoToaster','Ingredient removed from My Kitchen');
        } else {
            $user->ingredients()->attach($ingredient);
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Ingredient added to My Kitchen',
                    'ingredient' => $ingredient
                ]);
            }
            return back()->with('successToaster', 'Ingredient added to My Kitchen');
        }
        return back()->with('errorToaster', 'Failed to bookmark Recipe');
    }

    public function add(Request $request)
    {
        $user = auth()->user();
        $searchTerm = $request->input('search');
        $ingredientsQuery = Ingredient::query();

        if ($searchTerm) {
            $ingredientsQuery->where('name', 'like', '%' . $searchTerm . '%');
        }
        $ingredients = $ingredientsQuery
            ->selectRaw('MIN(id) as id, name')
            ->groupBy('name')
            ->orderBy('name', 'asc')
            ->get();
        $savedIngredientIds = $user->ingredients->pluck('id')->toArray();

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'list ingredients',
                'ingredients' => $ingredients,
                'savedIngredientIds' => $savedIngredientIds
            ]);
        }

        return view('kitchen.add', [
            'ingredients' => $ingredients,
            'savedIngredientIds' => $savedIngredientIds
        ]);
    }

}
