@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Lista ogłoszeń</h1>
            <a href="{{ route('ads.create') }}" class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Dodaj ogłoszenie</a>
        </div>
        <div class="grid gap-6 md:grid-cols-2">
            @foreach($ads as $ad)
                <div class="bg-white rounded shadow p-5 flex flex-col justify-between h-full">
                    <div>
                        @if(!empty($ad->images) && isset($ad->images[0]))
                            <img src="{{ asset('storage/' . $ad->images[0]) }}" alt="Miniaturka" class="w-full h-40 object-cover rounded mb-4">
                        @else
                            <div class="w-full h-40 bg-gray-200 flex items-center justify-center rounded mb-4 text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a4 4 0 004 4h10a4 4 0 004-4V7a4 4 0 00-4-4H7a4 4 0 00-4 4z" /><path stroke-linecap="round" stroke-linejoin="round" d="M8.5 12.5l2.5 2.5 3.5-4.5 4.5 6" /></svg>
                            </div>
                        @endif
                        <a href="{{ route('ads.show', $ad) }}" class="text-xl font-semibold text-blue-700 hover:underline">{{ e($ad->name) }}</a>
                        <div class="text-gray-600 mt-2 mb-4 line-clamp-2">{{ Str::limit($ad->description, 80) }}</div>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-lg font-bold text-green-700">{{ number_format($ad->price, 2) }} zł</span>
                        <a href="{{ route('ads.show', $ad) }}" class="text-blue-500 hover:underline">Zobacz</a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $ads->links() }}
        </div>
    </div>
</div>
@endsection 