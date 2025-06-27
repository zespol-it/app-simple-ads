@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="bg-white rounded shadow p-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ e($ad->name) }}</h1>
            <p class="text-gray-700 mb-4">{{ e($ad->description) }}</p>
            <p class="text-lg font-semibold text-green-700 mb-6">Cena: {{ number_format($ad->price, 2) }} zł</p>
            @if($ad->images)
                <div class="flex flex-wrap gap-4 mb-6">
                    @foreach($ad->images as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Zdjęcie" class="w-40 h-40 object-cover rounded border">
                    @endforeach
                </div>
            @endif
            <a href="{{ route('ads.index') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Powrót do listy</a>
        </div>
    </div>
</div>
@endsection 