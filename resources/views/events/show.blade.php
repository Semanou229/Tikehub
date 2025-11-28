@extends('layouts.app')

@section('title', $event->title . ' - Tikehub')

@section('content')
<!-- Hero Section avec image -->
<section class="relative">
    @if($event->cover_image)
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $event->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
    @else
        <div class="h-96 bg-gradient-to-r from-indigo-600 to-purple-600">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-indigo-600 px-4 py-1 rounded-full text-sm font-semibold">{{ $event->category }}</span>
            @if($event->is_free)
                <span class="bg-green-600 px-4 py-1 rounded-full text-sm font-semibold">Gratuit</span>
            @endif
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $event->title }}</h1>
        <div class="flex flex-wrap gap-6 text-lg">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>{{ $event->start_date->format('d/m/Y à H:i') }}</span>
            </div>
            @if($event->venue_city)
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span>{{ $event->venue_city }}, {{ $event->venue_country }}</span>
                </div>
            @endif
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">À propos de l'événement</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </div>

            <!-- Informations détaillées -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Informations</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Date et heure</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-calendar mr-2 text-indigo-600"></i>
                            {{ $event->start_date->format('d/m/Y à H:i') }}
                        </p>
                        @if($event->end_date)
                            <p class="text-gray-600 mt-1">
                                <i class="fas fa-clock mr-2 text-indigo-600"></i>
                                Jusqu'au {{ $event->end_date->format('d/m/Y à H:i') }}
                            </p>
                        @endif
                    </div>
                    @if($event->venue_name)
                        <div>
                            <h3 class="font-semibold text-gray-700 mb-2">Lieu</h3>
                            <p class="text-gray-600">
                                <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                                {{ $event->venue_name }}
                            </p>
                            @if($event->venue_address)
                                <p class="text-gray-600 mt-1 text-sm">{{ $event->venue_address }}</p>
                            @endif
                            <p class="text-gray-600 mt-1">
                                {{ $event->venue_city }}, {{ $event->venue_country }}
                            </p>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Organisateur</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>
                            {{ $event->organizer->name }}
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Catégorie</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-tag mr-2 text-indigo-600"></i>
                            {{ $event->category }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Galerie -->
            @if($event->gallery && count($event->gallery) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Galerie</h2>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($event->gallery as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Galerie {{ $event->title }}" class="w-full h-48 object-cover rounded-lg">
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Billets -->
            @if($event->ticketTypes->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h2 class="text-2xl font-bold mb-4">Billets disponibles</h2>
                    <div class="space-y-4">
                        @foreach($event->ticketTypes as $ticketType)
                            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-indigo-500 transition">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-semibold text-lg">{{ $ticketType->name }}</h3>
                                    <span class="text-2xl font-bold text-indigo-600">
                                        {{ number_format($ticketType->price, 0, ',', ' ') }} XOF
                                    </span>
                                </div>
                                @if($ticketType->description)
                                    <p class="text-gray-600 text-sm mb-3">{{ $ticketType->description }}</p>
                                @endif
                                <div class="flex justify-between items-center text-sm text-gray-500 mb-4">
                                    <span>
                                        <i class="fas fa-ticket-alt mr-1"></i>
                                        {{ $ticketType->available_quantity }} disponible(s)
                                    </span>
                                    @if($ticketType->sale_start_date && $ticketType->sale_end_date)
                                        <span class="text-xs">
                                            Du {{ $ticketType->sale_start_date->format('d/m') }} au {{ $ticketType->sale_end_date->format('d/m') }}
                                        </span>
                                    @endif
                                </div>
                                @if($ticketType->isOnSale() && auth()->check())
                                    <a href="{{ route('tickets.index', $event) }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                        Acheter maintenant
                                    </a>
                                @elseif(!auth()->check())
                                    <a href="{{ route('login') }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                        Se connecter pour acheter
                                    </a>
                                @else
                                    <button disabled class="block w-full bg-gray-400 text-white text-center px-4 py-3 rounded-lg cursor-not-allowed font-semibold">
                                        Vente terminée
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6">
                    <p class="text-gray-500 text-center">Aucun billet disponible pour le moment</p>
                </div>
            @endif

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Billets vendus</span>
                        <span class="font-semibold">{{ $event->total_tickets_sold ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Revenus</span>
                        <span class="font-semibold">{{ number_format($event->total_sales ?? 0, 0, ',', ' ') }} XOF</span>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Partager</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-700">
                        <i class="fab fa-facebook-f mr-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}" target="_blank" class="flex-1 bg-blue-400 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-500">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
