@extends('layouts.app')

@section('title', 'Edit Profile - Recipeze')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-lg mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-3xl font-semibold text-gray-800 dark:text-white text-center mb-6">Edit Profile</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('POST')

                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}"
                               class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:border-green-500 @error('name') border-red-500 @enderror">
                        @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                               class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:border-green-500 @error('email') border-red-500 @enderror">
                        @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">New Password (Optional)</label>
                        <input type="password" name="password" id="password"
                               class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror">
                        @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 dark:text-gray-300 font-bold mb-2">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="w-full px-4 py-2 border rounded-lg text-gray-700 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:outline-none focus:border-green-500">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                                class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                            Save Changes
                        </button>
                    </div>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('profile.show') }}" class="text-green-600 dark:text-green-400 hover:underline">
                        Back to Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
