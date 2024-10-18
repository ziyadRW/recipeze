<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/recipeze')->group(function() {

    Route::get('/list', [RecipeController::class, 'index'])->name('api.v1.recipes.index');

    // Authentication guest routes
    Route::post('/register', [ProfileController::class, 'registerUser'])->name('api.v1.register');
    Route::post('/login', [ProfileController::class, 'loginUser'])->name('api.v1.login');

    Route::middleware('auth:sanctum')->group(function(){

        // My Kitchen routes
        Route::prefix('kitchen')->group(function() {
            Route::get('/', [KitchenController::class, 'index'])->name('api.v1.kitchen.index');
            Route::post('/ingredient/toggle/{id}', [KitchenController::class, 'toggleIngredientAvailability'])->name('api.v1.kitchen.ingredient.toggle');
            Route::post('/ingredient/add', [KitchenController::class, 'addIngredient'])->name('api.v1.kitchen.ingredient.add');
            Route::post('/category/add', [KitchenController::class, 'addCategory'])->name('api.v1.kitchen.category.add');
        });

        // Profile routes
        Route::prefix('profile')->group(function() {
            Route::get('/', [ProfileController::class, 'show'])->name('api.v1.profile.show');
            Route::post('/update', [ProfileController::class, 'update'])->name('api.v1.profile.update');
        });

        // Logout
        Route::post('/logout', [ProfileController::class, 'logout'])->name('api.v1.logout');

        // Recipe routes
        Route::prefix('recipes')->group(function() {
            Route::get('/saved', [RecipeController::class, 'listSavedRecipes'])->name('api.v1.recipes.saved');
            Route::get('/list', [RecipeController::class, 'listRecipes'])->name('api.v1.recipes.list');
            Route::get('/generated', [RecipeController::class, 'generatedRecipes'])->name('api.v1.recipes.generated');
            Route::post('/bookmark/{id}', [RecipeController::class, 'toggleBookmarkRecipe'])->name('api.v1.recipes.bookmark');
            Route::get('/{id}', [RecipeController::class, 'showRecipe'])->name('api.v1.recipes.show');
        });

    });
});
