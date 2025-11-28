@extends('layouts.app')

@section('title', $event->title . ' - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($event->cover_image)
            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-64 object-cover">
        @endif
        <div class="p-6">
            <h1 class="text-3xl font-bold mb-4">{{ $event->title }}</h1>
            <div class="flex flex-wrap gap-4 mb-4 text-sm text-gray-600">
                <span><i class="fas fa-calendar mr-2"></i>{{ $event->start_date->format('d/m/Y H:i') }}</span>
                @if($event->venue_name)
                    <span><i class="fas fa-map-marker-alt mr-2"></i>{{ $event->venue_name }}, {{ $event->venue_city }}</span>
                @endif
            </div>
            <div class="prose max-w-none mb-6">
                {!! nl2br(e($event->description)) !!}
            </div>

            @if($event->ticketTypes->count() > 0)
                <div class="border-t pt-6 mt-6">
                    <h2 class="text-2xl font-semibold mb-4">Billets disponibles</h2>
                    <div class="space-y-4">
                        @foreach($event->ticketTypes as $ticketType)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="font-semibold text-lg">{{ $ticketType->name }}</h3>
                                        @if($ticketType->description)
                                            <p class="text-gray-600 text-sm mt-1">{{ $ticketType->description }}</p>
                                        @endif
                                        <p class="text-2xl font-bold text-indigo-600 mt-2">
                                            {{ number_format($ticketType->price, 0, ',', ' ') }} XOF
                                        </p>
                                        <p class="text-sm text-gray-500 mt-1">
                                            {{ $ticketType->available_quantity }} disponible(s)
                                        </p>
                                    </div>
                                    @if($ticketType->isOnSale() && auth()->check())
                                        <a href="{{ route('tickets.index', $event) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                                            Acheter
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

