@extends('layouts.app')

@section('title', 'Profile - Recipeze')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <div class="text-center">
                    <img class="w-24 h-24 rounded-full mx-auto mb-4" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random" alt="Profile picture">
                    <h2 class="text-3xl font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Account Information</h3>
                    <div class="mt-4">
                        <p class="text-gray-600 dark:text-gray-400"><strong>Name:</strong> {{ auth()->user()->name }}</p>
                        <p class="text-gray-600 dark:text-gray-400"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                        <p class="text-gray-600 dark:text-gray-400"><strong>Registered On:</strong> {{ auth()->user()->created_at->format('F j, Y') }}</p>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('profile.edit') }}" class="bg-green-600 text-white py-2 px-4 rounded-lg shadow-lg hover:bg-green-700 transition duration-300">Edit Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection
