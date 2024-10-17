@extends('layouts.app')

@section('title', 'My Kitchen')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">My Kitchen</h1>

        <div class="mb-6">
            <input type="text" id="ingredient-search" placeholder="Search for ingredients..." class="border p-2 w-full rounded-lg shadow-md">
        </div>

        <div id="ingredients-container" class="flex flex-wrap gap-2">
            @foreach($ingredients as $ingredient)
                <form method="POST" action="{{ route('kitchen.ingredient.toggle', $ingredient->id) }}">
                    @csrf
                    <button
                        class="ingredient-chip {{ in_array($ingredient->id, $savedIngredientIds) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }} px-4 py-2 rounded-full cursor-pointer transition duration-300"
                        data-ingredient-id="{{ $ingredient->id }}">
                        {{ $ingredient->name }}
                    </button>
                </form>
            @endforeach
        </div>

        <a href="{{ route('kitchen.add') }}" class="floating-button">
            <i class="fas fa-plus"></i>
        </a>

    </div>

    <script>
        document.getElementById('ingredient-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const chips = document.querySelectorAll('.ingredient-chip');

            chips.forEach(chip => {
                const ingredientName = chip.innerText.toLowerCase();
                if (ingredientName.includes(searchTerm)) {
                    chip.style.display = 'inline-block';
                } else {
                    chip.style.display = 'none';
                }
            });
        });
    </script>

    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #38a169;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0px 4px 10px rgba(56, 161, 105, 0.6);
            font-size: 24px;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 115px;
            margin-right: 135px;
        }

        .floating-button:hover {
            background-color: #2f855a;
            box-shadow: 0px 8px 15px rgba(47, 133, 90, 0.8);
        }
    </style>

@endsection
