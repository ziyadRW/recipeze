@extends('layouts.app')

@section('title', 'Under Development - Recipeze')

@section('content')
    <div class="container mx-auto py-12 text-center">
        <h1 class="text-3xl font-bold mb-4">This Feature is Still Under Development</h1>
        <p class="text-lg text-gray-700">We are working hard to bring this feature to you. Please check back later!</p>

        <a href="{{ route('home') }}" class="mt-6 inline-block bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700 transition duration-300">
            Back to Home
        </a>
    </div>
@endsection
