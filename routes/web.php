<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KitchenController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\SavedRecipeController;
use Illuminate\Support\Facades\Route;

Route::prefix('/')->group(function() {

    // Home page
    Route::get('/list', [RecipeController::class, 'index'])->name('recipes.index');
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Authentication guest routes
    Route::get('/register', [ProfileController::class, 'register'])->name('register');
    Route::post('/register', [ProfileController::class, 'registerUser']);
    Route::get('/login', [ProfileController::class, 'login'])->name('login');
    Route::post('/login', [ProfileController::class, 'loginUser']);

    Route::middleware('auth')->group(function(){
        // My Kitchen routes
        Route::prefix('kitchen')->group(function() {
            Route::get('/', [KitchenController::class, 'index'])->name('kitchen.index');
            Route::post('/ingredient/toggle/{id}', [KitchenController::class, 'toggleIngredientAvailability'])->name('kitchen.ingredient.toggle');
            Route::get('/ingredient/add', [KitchenController::class, 'add'])->name('kitchen.add');
        });

        // profile routes
        Route::prefix('profile')->group(function() {
            Route::get('/', [ProfileController::class, 'show'])->name('profile.show');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::post('/update', [ProfileController::class, 'update'])->name('profile.update');
        });

        // Authentication routes
        Route::post('/logout', [ProfileController::class, 'logout'])->name('logout');

        // Recipe generation and viewing
        Route::prefix('recipes')->group(function() {
            Route::get('/saved', [RecipeController::class, 'listSavedRecipes'])->name('recipes.saved');
            Route::get('/list', [RecipeController::class, 'listRecipes'])->name('recipes.list');
            Route::get('/generated', [RecipeController::class, 'generatedRecipes'])->name('recipes.generated');
            Route::post('/bookmark/{id}', [RecipeController::class, 'toggleBookmarkRecipe'])->name('recipes.bookmark');
            Route::get('/{id}', [RecipeController::class, 'showRecipe'])->name('recipes.show');
        });

    });
});
