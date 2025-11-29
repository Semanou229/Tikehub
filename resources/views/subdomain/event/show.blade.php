@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    @if($event->cover_image)
        <div class="relative h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $event->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $event->title }}</h1>
                    @if($event->start_date)
                        <p class="text-xl">{{ $event->start_date->format('d M Y à H:i') }}</p>
                    @endif
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $event->title }}</h1>
                @if($event->start_date)
                    <p class="text-xl">{{ $event->start_date->format('d M Y à H:i') }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <!-- Description -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">À propos</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($event->description)) !!}
                    </div>
                </div>

                <!-- Informations -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Informations</h2>
                    <div class="space-y-4">
                        @if($event->start_date)
                            <div class="flex items-start">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-3 mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-800">Date et heure</div>
                                    <div class="text-gray-600">
                                        {{ $event->start_date->format('d M Y à H:i') }}
                                        @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                                            - {{ $event->end_date->format('d M Y à H:i') }}
                                        @elseif($event->end_date)
                                            - {{ $event->end_date->format('H:i') }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($event->venue_name || $event->venue_city)
                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt text-indigo-600 mr-3 mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-800">Lieu</div>
                                    <div class="text-gray-600">
                                        @if($event->venue_name){{ $event->venue_name }}@endif
                                        @if($event->venue_address), {{ $event->venue_address }}@endif
                                        @if($event->venue_city), {{ $event->venue_city }}@endif
                                        @if($event->venue_country), {{ $event->venue_country }}@endif
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($event->organizer)
                            <div class="flex items-start">
                                <i class="fas fa-user text-indigo-600 mr-3 mt-1"></i>
                                <div>
                                    <div class="font-semibold text-gray-800">Organisateur</div>
                                    <div class="text-gray-600">{{ $event->organizer->name }}</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Billets</h3>
                    
                    @if($event->ticketTypes->count() > 0)
                        <div class="space-y-4 mb-6">
                            @foreach($event->ticketTypes as $ticketType)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="font-semibold text-gray-800 mb-2">{{ $ticketType->name }}</div>
                                    @if($ticketType->description)
                                        <p class="text-sm text-gray-600 mb-2">{{ $ticketType->description }}</p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <span class="text-2xl font-bold text-indigo-600">
                                            {{ number_format($ticketType->price, 0, ',', ' ') }} XOF
                                        </span>
                                        @if($ticketType->isOnSale())
                                            <a href="{{ route('events.show', $event) }}#tickets" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                                                Acheter
                                            </a>
                                        @else
                                            <span class="text-sm text-gray-500">Non disponible</span>
                                        @endif
                                    </div>
                                    @if($ticketType->quantity)
                                        <div class="text-xs text-gray-500 mt-2">
                                            {{ $ticketType->tickets()->where('status', 'paid')->count() }} / {{ $ticketType->quantity }} vendus
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-600 mb-4">Aucun billet disponible pour le moment.</p>
                    @endif

                    <a href="{{ route('events.show', $event) }}" class="block w-full text-center bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                        Voir sur Tikehub
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

