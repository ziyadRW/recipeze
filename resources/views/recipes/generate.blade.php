@extends('layouts.app')

@section('title', 'Generate Recipes')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Recipes Based on Your Ingredients</h1>

        <form method="GET" action="{{ route('recipes.generate') }}" class="mb-8 text-center">
            <input type="text" name="ingredient" placeholder="Enter an ingredient" value="{{ $ingredient }}" class="p-2 border rounded">
            <button type="submit" class="bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition duration-300">
                Search Recipes
            </button>
        </form>

        @if($paginatedRecipes->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($paginatedRecipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe['idMeal']) }}" class="bg-white shadow-md rounded-lg p-4 text-center transition duration-300 transform hover:scale-105 hover:shadow-xl block group">
                        <img src="{{ $recipe['strMealThumb'] }}" alt="{{ $recipe['strMeal'] }}" class="w-full h-48 object-cover mb-4 rounded group-hover:opacity-90">

                        <div class="flex justify-between items-center">
                            <h2 class="text-xl font-semibold mb-2 text-gray-800 group-hover:text-green-600">{{ $recipe['strMeal'] }}</h2>

                            <form method="POST" action="{{ route('recipes.bookmark', $recipe['idMeal']) }}">
                                @csrf
                                <button class="text-gray-400 hover:text-red-500 transition duration-300" aria-label="Bookmark">
                                    <i class="fas fa-bookmark"></i>
                                </button>
                            </form>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $paginatedRecipes->appends(request()->query())->links('partials.pagination.custom') }}
            </div>

        @else
            <p class="text-center text-gray-700">No recipes found for the ingredients you have.</p>
        @endif
    </div>
@endsection
