<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipeze')</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        .nav-container {
            position: relative;
        }

        .nav-underline {
            position: absolute;
            bottom: -4px;
            height: 2px;
            background-color: white;
            transition: all 0.3s ease;
            border-radius: 1px;
        }

        .nav-link {
            position: relative;
            padding-bottom: 4px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const links = document.querySelectorAll('.nav-link');
            const underline = document.querySelector('.nav-underline');
            const activeLink = document.querySelector('.nav-link.active');

            function moveUnderline(link) {
                underline.style.width = `${link.offsetWidth}px`;
                underline.style.left = `${link.offsetLeft - 22}px`;
            }

            if (activeLink) {
                moveUnderline(activeLink);
            }

            links.forEach(link => {
                link.addEventListener('click', function () {
                    links.forEach(link => link.classList.remove('active'));
                    link.classList.add('active');
                    moveUnderline(link);
                });
            });
        });

        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen">
@include('partials.notification.toaster')

<nav class="bg-green-600 p-4 shadow-lg relative nav-container">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">Recipeze</div>

        <ul class="hidden md:flex space-x-6 relative">
            <li><a href="{{ route('home') }}" class="nav-link text-white hover:text-gray-300 {{ request()->routeIs('home') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('kitchen.index') }}" class="nav-link text-white hover:text-gray-300 {{ request()->routeIs('kitchen.index') ? 'active' : '' }}">My Kitchen</a></li>
            <li><a href="{{ route('saved-recipes.index') }}" class="nav-link text-white hover:text-gray-300 {{ request()->routeIs('saved-recipes.index') ? 'active' : '' }}">Saved Recipes</a></li>

            <div class="nav-underline"></div>
        </ul>

        <div class="hidden md:flex items-center space-x-4">
            @auth
                <form method="POST" action="{{ route('logout') }}" class="flex items-center space-x-4">
                    @csrf
                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                        Log Out
                    </button>

                    <div class="flex items-center justify-center">
                        <a href="{{ route('profile.show') }}" class="hover:text-gray-300">
                            <img src="https://img.icons8.com/color/48/000000/user-male-circle.png" alt="Profile Icon" class="w-12 h-12">
                        </a>
                    </div>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white text-green-600 hover:bg-gray-200 py-2 px-4 rounded-lg">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="bg-white text-green-600 hover:bg-gray-200 py-2 px-4 rounded-lg">
                    Create Account
                </a>
            @endauth
        </div>

        <button class="md:hidden text-white focus:outline-none" onclick="toggleMenu()">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    </div>

    <div id="mobile-menu" class="md:hidden hidden">
        <ul class="space-y-4 p-4">
            <li><a href="{{ route('home') }}" class="block text-white hover:text-gray-300">Home</a></li>
            <li><a href="{{ route('kitchen.index') }}" class="block text-white hover:text-gray-300">My Kitchen</a></li>
            <li><a href="{{ route('saved-recipes.index') }}" class="block text-white hover:text-gray-300">Saved Recipes</a></li>

            @auth
                <li><a href="{{ route('profile.show') }}" class="block text-white hover:text-gray-300">
                        <i class="fas fa-user-circle"></i> Profile
                    </a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg">
                            Log Out
                        </button>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="block bg-white text-green-600 hover:bg-gray-200 py-2 px-4 rounded-lg">Log In</a></li>
                <li><a href="{{ route('register') }}" class="block bg-white text-green-600 hover:bg-gray-200 py-2 px-4 rounded-lg">Create Account</a></li>
            @endauth
        </ul>
    </div>
</nav>

<main class="py-6 flex-grow">
    @yield('content')
</main>

<footer class="bg-gray-800 text-white text-center py-8 mt-auto">
    <p>&copy; 2024 Recipeze. Developed by Recipeze team supervised by Dr. Sultan. All Rights Reserved.</p>
</footer>

</body>
</html>
