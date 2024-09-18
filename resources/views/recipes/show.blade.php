@extends('layouts.app')

@section('title', 'Recipe Details')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">{{ $recipe['strMeal'] }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-8">
                <div class="text-center">
                    <img src="{{ $recipe['strMealThumb'] }}" alt="{{ $recipe['strMeal'] }}" class="w-full max-w-full h-auto rounded-lg shadow-lg">
                </div>

                <div class="bg-white shadow-md rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-carrot text-green-600"></i> Ingredients</h2>
                    <ul class="grid grid-cols-2 gap-4 text-gray-700">
                        @for ($i = 1; $i <= 20; $i++)
                            @php
                                $ingredient = $recipe['strIngredient' . $i];
                                $measure = $recipe['strMeasure' . $i];
                            @endphp
                            @if (!empty($ingredient))
                                <li><i class="fas fa-check-circle text-green-500"></i> {{ $ingredient }} - <span class="text-gray-500">{{ $measure }}</span></li>
                            @endif
                        @endfor
                    </ul>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-8">
                <h2 class="text-2xl font-bold mb-4"><i class="fas fa-utensils text-green-600"></i> Instructions</h2>
                <p class="text-gray-700 leading-loose mb-8">
                    {{ $recipe['strInstructions'] }}
                </p>

                <h2 class="text-2xl font-bold mb-4"><i class="fas fa-info-circle text-green-600"></i> Recipe Details</h2>
                <div class="text-gray-700">
                    <p><strong><i class="fas fa-tag"></i> Category:</strong> {{ $recipe['strCategory'] }}</p>
                    <p><strong><i class="fas fa-globe"></i> Cuisine:</strong> {{ $recipe['strArea'] }}</p>
                    <p><strong><i class="fas fa-hashtag"></i> Tags:</strong> {{ $recipe['strTags'] ?? 'No tags available' }}</p>
                </div>

                @if ($recipe['strYoutube'])
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-4 flex items-center space-x-2">
                            <i class="fas fa-video text-red-500"></i>
                            <span>Watch Video Tutorial</span>
                        </h2>
                        <div class="relative w-full h-0" style="padding-bottom: 56.25%;">
                            <iframe src="https://www.youtube.com/embed/{{ explode('v=', $recipe['strYoutube'])[1] }}"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg">
                            </iframe>
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('recipes.generate') }}" class="bg-green-600 text-white py-2 px-4 rounded-lg shadow hover:bg-green-700 transition duration-300 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Recipes
            </a>
        </div>
    </div>
@endsection
