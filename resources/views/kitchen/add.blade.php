@extends('layouts.app')

@section('title', 'Add Ingredients to My Kitchen')

@section('content')
    <div class="container mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Add Ingredients to My Kitchen</h1>

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
    </div>

    <script>
        const csrfToken = '{{ csrf_token() }}';

        document.getElementById('ingredient-search').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();

            fetch('{{ route('kitchen.add') }}?search=' + searchTerm, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newIngredients = doc.getElementById('ingredients-container').innerHTML;

                    const ingredientsContainer = document.getElementById('ingredients-container');
                    ingredientsContainer.innerHTML = newIngredients;
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
@endsection
