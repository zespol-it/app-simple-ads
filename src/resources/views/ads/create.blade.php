@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Dodaj ogłoszenie</h1>
            <form method="POST" action="{{ route('ads.store') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <div>
                    <label class="block font-semibold mb-1">Nazwa:</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                    @error('name') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Opis:</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description') }}</textarea>
                    @error('description') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Cena:</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"/>
                    @error('price') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <div>
                    <label class="block font-semibold mb-1">Zdjęcia (max 5):</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="block w-full text-gray-700"/>
                    @error('images') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                    @error('images.*') <div class="text-red-600 text-sm mt-1">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Dodaj</button>
            </form>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('form');
                    form.addEventListener('submit', function(e) {
                        let valid = true;
                        // Czyść stare błędy
                        form.querySelectorAll('.js-error').forEach(el => el.remove());
                        // Nazwa
                        const name = form.querySelector('[name=name]');
                        if (!name.value.trim()) {
                            showError(name, 'Pole nazwa jest wymagane.');
                            valid = false;
                        }
                        // Opis
                        const desc = form.querySelector('[name=description]');
                        if (!desc.value.trim()) {
                            showError(desc, 'Pole opis jest wymagane.');
                            valid = false;
                        }
                        // Cena
                        const price = form.querySelector('[name=price]');
                        if (!price.value.trim() || isNaN(price.value) || Number(price.value) <= 0) {
                            showError(price, 'Podaj poprawną cenę większą od zera.');
                            valid = false;
                        }
                        // Zdjęcia
                        const images = form.querySelector('[name="images[]"]');
                        if (images.files.length > 5) {
                            showError(images, 'Możesz dodać maksymalnie 5 zdjęć.');
                            valid = false;
                        }
                        if (!valid) e.preventDefault();
                    });
                    function showError(input, msg) {
                        const err = document.createElement('div');
                        err.className = 'js-error text-red-600 text-sm mt-1';
                        err.innerText = msg;
                        input.parentNode.appendChild(err);
                    }
                });
            </script>
        </div>
    </div>
</div>
@endsection 