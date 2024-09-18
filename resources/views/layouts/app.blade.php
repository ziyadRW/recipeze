
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Recipeze')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-white text-gray-800">

<nav class="bg-green-600 p-4 shadow-lg">
    <div class="container mx-auto flex justify-between items-center">
        <div class="text-white text-lg font-bold">Recipeze</div>
        <ul class="flex space-x-6">
            <li><a href="{{ route('home') }}" class="text-white hover:text-gray-300">Home</a></li>
            <li><a href="{{ route('kitchen.index') }}" class="text-white hover:text-gray-300">My Kitchen</a></li>
            <li><a href="{{ route('recipes.generate') }}" class="text-white hover:text-gray-300">Generate Recipes</a></li>
            <li><a href="{{ route('saved-recipes.index') }}" class="text-white hover:text-gray-300">Saved Recipes</a></li>
            <li><a href="{{ route('profile.show') }}" class="text-white hover:text-gray-300">Profile</a></li>
        </ul>
    </div>
</nav>

<main class="py-6">
    @yield('content')
</main>

<footer class="bg-gray-800 text-white text-center py-8">
    <p>&copy; 2024 Recipeze. Developed by Recipeze team supervised by Dr.Sultan All Rights Reserved.</p>
</footer>

</body>
</html>
