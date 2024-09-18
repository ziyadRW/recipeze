@extends('layouts.app')

@section('title', 'Welcome to Recipeze')

@section('content')
    <div class="bg-green-600 text-white text-center py-16">
        <h1 class="text-5xl font-bold mb-4">Welcome to Recipeze</h1>
        <p class="text-xl mb-8">The easiest way to find recipes based on the ingredients you have at home!</p>
        <a href="{{ route('recipes.generate') }}" class="bg-white text-green-600 font-semibold py-3 px-8 rounded-lg shadow hover:bg-gray-200 transition duration-300">
            Get Started
        </a>
    </div>

    <section class="py-16 bg-white">
        <div class="container mx-auto text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Why Recipeze?</h2>
            <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                Recipeze allows you to easily enter the ingredients in your kitchen and instantly discover delicious recipes. Whether you're running low on groceries or just looking for inspiration, Recipeze has you covered!
            </p>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                <div class="p-8 border rounded-lg shadow hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">Enter Ingredients</h3>
                    <p class="text-gray-600">Easily input the ingredients you have, and we'll do the rest by finding the best recipes.</p>
                </div>
                <div class="p-8 border rounded-lg shadow hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">Generate Recipes</h3>
                    <p class="text-gray-600">Recipeze matches your ingredients with hundreds of recipes to provide instant suggestions.</p>
                </div>
                <div class="p-8 border rounded-lg shadow hover:shadow-lg transition duration-300">
                    <h3 class="text-2xl font-semibold text-green-600 mb-4">Save Favorites</h3>
                    <p class="text-gray-600">Create an account and save your favorite recipes so you can easily find them again later.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-green-600 text-white text-center py-16">
        <h2 class="text-4xl font-bold mb-4">Ready to Start Cooking?</h2>
        <p class="text-lg mb-8">Discover new recipes and make meal planning easy with Recipeze.</p>
        <a href="{{ route('recipes.generate') }}" class="bg-white text-green-600 font-semibold py-3 px-8 rounded-lg shadow hover:bg-gray-200 transition duration-300">
            Get Started Now
        </a>
    </section>
@endsection
