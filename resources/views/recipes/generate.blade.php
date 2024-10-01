@extends('layouts.app')

@section('title', 'Generate Recipes')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Recipes Based on Your Ingredients</h1>

        <form method="GET" action="{{ route('recipes.generate') }}" class="mb-8 text-center">
            <div class="relative inline-block w-full max-w-lg">
                <input type="text" name="ingredient" placeholder="Enter ingredients (comma separated)"
                       value="{{ $ingredientInput }}"
                       class="w-full py-3 pl-4 pr-12 text-lg border rounded-full shadow focus:outline-none focus:shadow-outline">
                <button type="submit"
                        class="absolute inset-y-0 right-0 flex items-center justify-center w-12 h-full text-green-600">
                    <i class="fas fa-arrow-right text-xl"></i>
                </button>
            </div>

            @if($ingredientInput)
                <div class="mt-4 text-left">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="has_video" value="1"
                               {{ request()->has('has_video') ? 'checked' : '' }}
                               class="form-checkbox h-4 w-4"
                               onchange="this.form.submit()">
                        <span class="ml-2 text-gray-700">Show only recipes with video</span>
                    </label>
                </div>
            @endif

        </form>




        @if($ingredientInput)
            @if($paginatedRecipes->count())
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($paginatedRecipes as $recipe)
                        <a href="{{ route('recipes.show', $recipe['id']) }}" class="bg-white shadow-md rounded-lg p-4 text-center transition duration-300 transform hover:scale-105 hover:shadow-xl block group">
                            <img src="{{ $recipe['thumbnail_url'] }}" alt="{{ $recipe['name'] }}" class="w-full h-48 object-cover mb-4 rounded group-hover:opacity-90">

                            <div class="flex flex-col justify-between items-center">
                                <h2 class="text-xl font-semibold mb-2 text-gray-800 text-center group-hover:text-green-600">
                                    @if(isset($recipe['original_video_url']) && !empty($recipe['original_video_url']))
                                        <i class="fas fa-video text-red-500 mr-2"></i>
                                    @endif
                                    {{ $recipe['name'] }}
                                </h2>

                                <div class="flex justify-between items-center w-full mt-2">
                                    <div>
                                        @if(isset($recipe['nutrition']['calories']))
                                            <p class="text-sm text-gray-500 flex items-center">
                                                <i class="fas fa-fire-alt mr-2"></i> {{ $recipe['nutrition']['calories'] }} Calories
                                            </p>
                                        @endif
                                        <p class="text-sm text-gray-500 flex items-center">
                                            <i class="fas fa-clock mr-2"></i>
                                            {{ $recipe['cook_time_minutes'] ? $recipe['cook_time_minutes'].' minutes' : 'Unknown' }}
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('recipes.bookmark', $recipe['id']) }}">
                                        @csrf
                                        <button class="text-gray-400 hover:text-red-500 transition duration-300" aria-label="Bookmark">
                                            <i class="fas fa-bookmark"></i>
                                        </button>
                                    </form>
                                </div>
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
        @else
            <p class="text-center text-gray-700">Please enter ingredients to search for recipes.</p>
        @endif
    </div>
@endsection
