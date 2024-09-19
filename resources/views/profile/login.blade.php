@extends('layouts.app')

@section('title', 'Login - Recipeze')

@section('content')
    <div class="container mx-auto py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-md overflow-hidden md:max-w-lg">
            <div class="md:flex">
                <div class="w-full p-4">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-semibold text-gray-700">Welcome Back</h2>
                        <p class="text-gray-500">Log in to your Recipeze account</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

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

                        <div class="mb-6">
                            <label for="password" class="block text-gray-700 font-bold mb-2">
                                Password
                            </label>
                            <input type="password" name="password" id="password" placeholder="Enter your password"
                                   class="w-full px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror">
                            @error('password')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="remember" id="remember" class="mr-2">
                                <label for="remember" class="text-gray-700">Remember Me</label>
                            </div>
                            <a href="#" class="text-green-600 hover:underline">Forgot Password?</a>
                        </div>

                        <div class="flex justify-center">
                            <button type="submit"
                                    class="bg-green-600 text-white font-bold py-2 px-6 rounded-lg hover:bg-green-700 transition duration-300">
                                Log In
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p class="text-gray-600">Don't have an account?
                            <a href="{{ route('register') }}" class="text-green-600 hover:underline">
                                Create an account here
                            </a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
