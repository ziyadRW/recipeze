@extends('layouts.app')

@section('title', 'Recipe Details')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">{{ $recipe['name'] }}</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <div class="space-y-8">
                <div class="text-center">
                    <img src="{{ $recipe['thumbnail_url'] }}" alt="{{ $recipe['name'] }}" class="w-full max-w-full h-auto rounded-lg shadow-lg">
                </div>

                <div class="bg-white shadow-md rounded-lg p-8">
                    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-carrot text-green-600"></i> Ingredients</h2>
                    <ul class="grid grid-cols-2 gap-4 text-gray-700">
                        @foreach($recipe['sections'] as $section)
                            @foreach($section['components'] as $ingredient)
                                <li><i class="fas fa-check-circle text-green-500"></i>
                                    {{ $ingredient['ingredient']['name'] }} -
                                    {{ $ingredient['measurements'][0]['quantity'] ?? '' }}
                                    {{ $ingredient['measurements'][0]['unit']['name'] ?? '' }}
                                </li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="bg-white shadow-md rounded-lg p-8 flex flex-col justify-between" style="min-height: 100%;">
                <div class="mb-8">
                    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-utensils text-green-600"></i> Instructions</h2>
                    <p class="text-gray-700 leading-loose mb-8">
                    @foreach($recipe['instructions'] as $instruction)
                        <p>{{ $instruction['display_text'] }}</p>
                        @endforeach
                        </p>
                </div>

                <div class="mt-auto">
                    <h2 class="text-2xl font-bold mb-4"><i class="fas fa-video text-red-500"></i> Watch Video</h2>
                    @if (isset($recipe['original_video_url']) && !empty($recipe['original_video_url']))
                        <div class="relative w-full h-0" style="padding-bottom: 56.25%;">
                            <iframe src="{{ $recipe['original_video_url'] }}" frameborder="0" allowfullscreen class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"></iframe>
                        </div>
                    @elseif (isset($recipe['video_url']) && !empty($recipe['video_url']))
                        <div class="relative w-full h-0" style="padding-bottom: 56.25%;">
                            <iframe src="{{ $recipe['video_url'] }}" frameborder="0" allowfullscreen class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg"></iframe>
                        </div>
                    @else
                        <p>Video not available.</p>
                    @endif
                </div>
            </div>

        </div>

        <div class="text-center mt-8">
            <a href="{{ route('recipes.generate') }}" class="bg-green-600 text-white py-2 px-4 rounded-lg shadow hover:bg-green-700 transition duration-300 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Recipes
            </a>
        </div>
    </div>
@endsection
