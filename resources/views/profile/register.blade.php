@extends('layouts.app')

@section('title', 'Register - Recipeze')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full p-4">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-700">Create your account</h2>
                        <p class="text-gray-500">Join Recipeze and discover great recipes!</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-bold mb-2">
                                Name
                            </label>
                            <input type="text" name="name" id="name" placeholder="Enter your name"
                                   class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500 @error('name') border-red-500 @enderror">
                            @error('name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-bold mb-2">
                                Email Address
                            </label>
                            <input type="email" name="email" id="email" placeholder="Enter your email"
                                   class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500 @error('email') border-red-500 @enderror">
                            @error('email')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-bold mb-2">
                                Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="Create a password"
                                   class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror">
                            @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="password_confirmation" class="block text-gray-700 font-bold mb-2">
                                Confirm Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   placeholder="Confirm your password"
                                   class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500">
                        </div>

                        <div class="flex justify-center">
                            <button type="submit"
                                    class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                Register
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-600">Already have an account?
                            <a href="{{ route('login') }}" class="text-green-600 hover:underline">
                                Log in here
                            </a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
