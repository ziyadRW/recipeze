@extends('layouts.app')

@section('title', 'All Recipes')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">All Recipes</h1>

        <form method="GET" action="{{ route('recipes.list') }}" class="mb-8 text-center">
            <div class="relative inline-block w-full max-w-lg">
                <input type="text" name="search" placeholder="Search for recipes..."
                       value="{{ $searchTerm }}"
                       class="w-full py-3 pl-4 pr-12 text-lg border rounded-full shadow focus:outline-none focus:shadow-outline">
                <button type="submit"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-12 h-full text-green-600">
                    <i class="fas fa-search text-xl"></i>
                </button>
            </div>

            <div class="mt-4 text-left">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="has_video" value="1"
                           {{ $hasVideo ? 'checked' : '' }}
                           class="form-checkbox h-4 w-4"
                           onchange="this.form.submit()">
                    <span class="ml-2 text-gray-700">Show only recipes with video</span>
                </label>
            </div>
        </form>

        @if($paginatedRecipes->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($paginatedRecipes as $recipe)
                    <a href="{{ route('recipes.show', $recipe->id) }}" class="bg-white shadow-md rounded-lg p-4 text-center transition duration-300 transform hover:scale-105 hover:shadow-xl block group">
                        <img src="{{ $recipe->thumbnail_url }}" alt="{{ $recipe->name }}" class="w-full h-48 object-cover mb-4 rounded group-hover:opacity-90">

                        <div class="flex flex-col justify-between items-center">
                            <h2 class="text-xl font-semibold mb-2 text-gray-800 text-center group-hover:text-green-600">
                                @if($recipe->original_video_url)
                                    <i class="fas fa-video text-red-500 mr-2"></i>
                                @endif
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
                                    <button class="{{ in_array($recipe->id, $savedRecipeIds) ? 'text-red-500 hover:text-gray-500' : 'text-gray-400 hover:text-red-500' }} transition duration-300" aria-label="Bookmark">
                                        <i class="{{ in_array($recipe->id, $savedRecipeIds) ? 'fas fa-bookmark' : 'far fa-bookmark' }}"></i>
                                    </button>
                                </form>

                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8 flex justify-center">
                {{ $paginatedRecipes->appends(request()->query())->links() }}
            </div>
        @else
            <p class="text-center text-gray-700">No recipes found matching your criteria.</p>
        @endif
    </div>

    <a href="{{ route('recipes.generated') }}" id="cooking" class="fixed bottom-8 right-8 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-full shadow-lg transition duration-300 transform hover:scale-110 flex items-center justify-center animate-bounce-more">
        <i class="fas fa-utensils animate-spin mr-2"></i> What can I cook?
    </a>

    <style>
        .animate-spin {
            animation: spin 3s linear infinite;
        }

        #cooking{
            margin-bottom: 45px;
            margin-right: 75px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-bounce-more {
            animation: bounce-more 2s infinite, pulse-shadow 1.5s infinite;
        }

        @keyframes bounce-more {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px) scale(1.05);
            }
        }

        @keyframes pulse-shadow {
            0%, 100% {
                box-shadow: 0 0 8px rgba(0, 128, 0, 0.5);
            }
            50% {
                box-shadow: 0 0 16px rgba(0, 128, 0, 1);
            }
        }
    </style>
@endsection
