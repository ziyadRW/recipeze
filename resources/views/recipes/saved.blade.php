@extends('layouts.app')

@section('title', 'Saved Recipes')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Saved Recipes</h1>

        @if($savedRecipes->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($savedRecipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="bg-white shadow-md rounded-lg p-4 text-center transition duration-300 transform hover:scale-105 hover:shadow-xl block group">
                        <img src="{{ $recipe->thumbnail_url }}" alt="{{ $recipe->name }}" class="w-full h-48 object-cover mb-4 rounded group-hover:opacity-90">

                        <div class="flex flex-col justify-between items-center">
                            <h2 class="text-xl font-semibold mb-2 text-gray-800 text-center group-hover:text-green-600">
                                {{ $recipe->name }}
                            </h2>

                            <div class="flex justify-between items-center w-full mt-2">
                                <div>
                                    @if($recipe->calories)
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-fire-alt mr-2"></i> {{ $recipe->calories }} Calories
                                        </p>
                                    @endif
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-clock mr-2"></i>
                                        {{ $recipe->cook_time_minutes ? $recipe->cook_time_minutes . ' minutes' : 'Unknown' }}
                                    </p>
                                </div>

                                <form method="POST" action="{{ route('recipes.bookmark', $recipe->id) }}">
                                    @csrf
                                    <button class="{{ $recipe->saved ? 'text-red-500 hover:text-gray-500' : 'text-gray-400 hover:text-red-500' }} transition duration-300" aria-label="Bookmark">
                                        <i class="{{ $recipe->saved ? 'fas fa-bookmark' : 'far fa-bookmark' }}"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $savedRecipes->links() }}
            </div>
        @else
            <p class="text-center text-gray-700">No saved recipes found.</p>
        @endif
    </div>
@endsection
