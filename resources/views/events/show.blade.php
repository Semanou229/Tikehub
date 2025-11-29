@extends('layouts.app')

@section('title', $event->title . ' - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec date en rouge -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Date Box (Rouge) -->
            <div class="bg-red-600 text-white p-6 text-center min-w-[120px] flex flex-col justify-center items-center">
                <div class="text-2xl font-bold uppercase">{{ $event->start_date->translatedFormat('M') }}</div>
                <div class="text-5xl font-bold">{{ $event->start_date->format('d') }}</div>
                <div class="text-lg mt-2">{{ $event->start_date->translatedFormat('l') }}</div>
            </div>

            <!-- Contenu principal du header -->
            <div class="flex-1 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $event->title }}</h1>
                        
                        <!-- Informations date et lieu -->
                        <div class="space-y-2 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-red-600 mr-3 w-5"></i>
                                <span>
                                    {{ $event->start_date->translatedFormat('D, d M Y') }} 
                                    @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                                        - {{ $event->end_date->translatedFormat('D, d M Y') }}
                                    @endif
                                    ({{ $event->start_date->format('H:i') }} - {{ $event->end_date ? $event->end_date->format('H:i') : '23:59' }})
                                    {{ config('app.timezone', 'UTC') }}
                                </span>
                            </div>
                            @if($event->venue_name || $event->venue_city)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-red-600 mr-3 w-5"></i>
                                    <span>
                                        @if($event->venue_name){{ $event->venue_name }}, @endif
                                        @if($event->venue_city){{ $event->venue_city }}@endif
                                        @if($event->venue_country), {{ $event->venue_country }}@endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-2 md:min-w-[150px]">
                        <button onclick="shareEvent()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>PARTAGER</span>
                        </button>
                        <button onclick="reportEvent()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-flag"></i>
                            <span>SIGNALER</span>
                        </button>
                        <button onclick="addToCalendar()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-calendar-plus"></i>
                            <span>CALENDRIER</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Description</h2>
                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($event->description)) !!}
                </div>

                <!-- Points à puces avec checkmarks verts -->
                @if($event->ticketTypes->count() > 0 || $event->contests->count() > 0)
                    <div class="space-y-3 mt-6">
                        @if($event->ticketTypes->count() > 0)
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Billets disponibles en ligne</span>
                            </div>
                        @endif
                        @if($event->contests->count() > 0)
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Concours et votes disponibles</span>
                            </div>
                        @endif
                        @if($event->fundraisings->count() > 0)
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                                <span>Collecte de fonds associée</span>
                            </div>
                        @endif
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                            <span>Événement organisé par {{ $event->organizer->name }}</span>
                        </div>
                    </div>
                @endif

                <!-- Call to action avec icône -->
                @if($event->venue_city)
                    <div class="mt-6 p-4 bg-pink-50 border-l-4 border-pink-500 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-map-pin text-pink-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">
                                Rendez-vous à {{ $event->venue_name ?? $event->venue_city }} pour une expérience inoubliable !
                            </p>
                        </div>
                    </div>
                @endif

                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                        <p class="text-gray-700">
                            Ne ratez pas cet événement unique : réservez vite votre place et venez vivre une expérience mémorable !
                        </p>
                    </div>
                </div>
            </div>

            <!-- Informations sur le billet -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Informations sur le billet</h2>
                
                @if($event->ticketTypes->count() > 0)
                    @php
                        $hasAvailableTickets = $event->ticketTypes->filter(function($type) {
                            return $type->isOnSale();
                        })->count() > 0;
                    @endphp
                    @if($hasAvailableTickets && auth()->check())
                        <!-- Panier flottant -->
                        <div id="ticket-cart" class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-red-600 shadow-2xl z-50 transform translate-y-full transition-transform duration-300">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="text-sm text-gray-600 mb-1">
                                            <span id="cart-total-items">0</span> billet(s) sélectionné(s)
                                        </div>
                                        <div class="text-2xl font-bold text-red-600">
                                            <span id="cart-total-price">0</span> XOF
                                        </div>
                                    </div>
                                    <form id="checkout-form" method="POST" action="{{ route('tickets.checkout', $event) }}" class="ml-4">
                                        @csrf
                                        <input type="hidden" name="tickets" id="tickets-data">
                                        <button type="submit" 
                                                id="checkout-btn"
                                                class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition font-semibold text-lg disabled:opacity-50 disabled:cursor-not-allowed"
                                                disabled>
                                            <i class="fas fa-shopping-cart mr-2"></i>Commander
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @elseif($hasAvailableTickets && !auth()->check())
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-gray-700">Billets</span>
                            <a href="{{ route('login') }}" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition font-semibold">
                                <i class="fas fa-ticket-alt mr-2"></i>Réserver maintenant
                            </a>
                        </div>
                    @else
                        <div class="flex items-center justify-between mb-4">
                            <span class="font-semibold text-gray-700">Billets</span>
                            <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm">
                                Réservation en ligne fermée
                            </span>
                        </div>
                    @endif
                @else
                    <div class="flex items-center justify-between mb-4">
                        <span class="font-semibold text-gray-700">Billets</span>
                        <span class="px-4 py-2 bg-gray-200 text-gray-600 rounded-lg text-sm">
                            Aucun billet disponible
                        </span>
                    </div>
                @endif

                <!-- Liste des types de billets -->
                @if($event->ticketTypes->count() > 0)
                    <div class="mt-6 space-y-4">
                        @foreach($event->ticketTypes as $ticketType)
                            @php
                                $urgencyBadges = $ticketType->getUrgencyBadges();
                            @endphp
                            <div class="border border-gray-200 rounded-lg p-4 hover:border-red-500 transition relative">
                                <!-- Badges d'urgence -->
                                @if(count($urgencyBadges) > 0)
                                    <div class="absolute top-2 right-2 flex flex-wrap gap-2">
                                        @foreach($urgencyBadges as $badge)
                                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold 
                                                @if($badge['color'] === 'red') bg-red-100 text-red-700 border border-red-300
                                                @elseif($badge['color'] === 'orange') bg-orange-100 text-orange-700 border border-orange-300
                                                @else bg-yellow-100 text-yellow-700 border border-yellow-300
                                                @endif
                                                animate-pulse">
                                                <i class="fas fa-{{ $badge['icon'] }}"></i>
                                                {{ $badge['text'] }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <div class="flex justify-between items-start">
                                    <div class="flex-1 pr-24">
                                        <h3 class="font-semibold text-lg mb-1">{{ $ticketType->name }}</h3>
                                        @if($ticketType->description)
                                            <p class="text-gray-600 text-sm mb-2">{{ $ticketType->description }}</p>
                                        @endif
                                        <div class="flex items-center gap-4 text-sm text-gray-500 flex-wrap">
                                            <span class="flex items-center">
                                                <i class="fas fa-ticket-alt mr-1"></i>
                                                {{ $ticketType->available_quantity }} disponible(s)
                                            </span>
                                            @if($ticketType->quantity > 0)
                                                @php
                                                    $percentageSold = ($ticketType->sold_quantity / $ticketType->quantity) * 100;
                                                @endphp
                                                <span class="flex items-center">
                                                    <i class="fas fa-chart-line mr-1"></i>
                                                    {{ number_format($percentageSold, 0) }}% vendu
                                                </span>
                                            @endif
                                            @if($ticketType->start_sale_date && $ticketType->end_sale_date)
                                                <span>
                                                    Du {{ $ticketType->start_sale_date->format('d/m/Y') }} au {{ $ticketType->end_sale_date->format('d/m/Y') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right ml-4">
                                        <div class="text-2xl font-bold text-red-600 mb-3">
                                            {{ number_format($ticketType->price, 0, ',', ' ') }} XOF
                                        </div>
                                        @if($ticketType->isOnSale())
                                            @if(auth()->check())
                                                <!-- Sélecteur de quantité -->
                                                <div class="flex items-center justify-end gap-2 mb-2">
                                                    <button type="button" 
                                                            class="ticket-decrease bg-gray-200 hover:bg-gray-300 text-gray-700 w-8 h-8 rounded-full flex items-center justify-center transition disabled:opacity-50 disabled:cursor-not-allowed" 
                                                            data-ticket-type-id="{{ $ticketType->id }}"
                                                            data-price="{{ $ticketType->price }}"
                                                            data-max="{{ $ticketType->available_quantity }}">
                                                        <i class="fas fa-minus text-xs"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="ticket-quantity w-12 text-center border border-gray-300 rounded py-1 text-sm font-semibold" 
                                                           data-ticket-type-id="{{ $ticketType->id }}"
                                                           data-price="{{ $ticketType->price }}"
                                                           value="0" 
                                                           min="0" 
                                                           max="{{ $ticketType->available_quantity }}"
                                                           readonly>
                                                    <button type="button" 
                                                            class="ticket-increase bg-red-600 hover:bg-red-700 text-white w-8 h-8 rounded-full flex items-center justify-center transition disabled:opacity-50 disabled:cursor-not-allowed" 
                                                            data-ticket-type-id="{{ $ticketType->id }}"
                                                            data-price="{{ $ticketType->price }}"
                                                            data-max="{{ $ticketType->available_quantity }}">
                                                        <i class="fas fa-plus text-xs"></i>
                                                    </button>
                                                </div>
                                            @else
                                                <a href="{{ route('login') }}" class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm font-semibold">
                                                    <i class="fas fa-shopping-cart mr-1"></i>Acheter
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Lieu sur carte -->
            @if($event->venue_latitude && $event->venue_longitude || $event->venue_address)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Lieu sur carte</h2>
                    <div id="eventMap" style="width: 100%; height: 384px; min-height: 384px; position: relative; z-index: 10; background: #e5e7eb; display: block !important; visibility: visible !important;"></div>
                    @if($event->venue_name || $event->venue_address)
                        <div class="space-y-2 text-gray-700">
                            @if($event->venue_name)
                                <p class="font-semibold"><i class="fas fa-map-marker-alt text-red-600 mr-2"></i>{{ $event->venue_name }}</p>
                            @endif
                            @if($event->venue_address)
                                <p class="text-sm"><i class="fas fa-road text-gray-500 mr-2"></i>{{ $event->venue_address }}</p>
                            @endif
                            @if($event->venue_city)
                                <p class="text-sm"><i class="fas fa-city text-gray-500 mr-2"></i>{{ $event->venue_city }}{{ $event->venue_country ? ', ' . $event->venue_country : '' }}</p>
                            @endif
                        </div>
                    @endif
                </div>
            @endif

            <!-- Calendrier des événements -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-red-600">Calendrier des événements</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                {{ $event->start_date->translatedFormat('l, d F Y') }}
                                @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                                    - {{ $event->end_date->translatedFormat('l, d F Y') }}
                                @endif
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $event->start_date->format('H:i') }} - {{ $event->end_date ? $event->end_date->format('H:i') : '23:59' }} 
                                {{ config('app.timezone', 'UTC') }}
                            </p>
                        </div>
                        @if($event->end_date && $event->end_date->isPast())
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Fermé
                            </span>
                        @elseif($event->start_date->isFuture())
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                À venir
                            </span>
                        @else
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold">
                                En cours
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ajouter un avis -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Ajouter Un Avis</h2>
                @auth
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Évaluation</label>
                            <div class="flex gap-1" id="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" class="text-2xl text-gray-300 hover:text-yellow-400 focus:outline-none" data-rating="{{ $i }}">
                                        <i class="far fa-star"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-value" value="0">
                        </div>
                        <div>
                            <label for="reviewer_name" class="block text-sm font-medium text-gray-700 mb-2">Nom*</label>
                            <input type="text" id="reviewer_name" name="name" value="{{ auth()->user()->name }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Tapez votre nom ici" required>
                        </div>
                        <div>
                            <label for="reviewer_email" class="block text-sm font-medium text-gray-700 mb-2">Votre Email*</label>
                            <input type="email" id="reviewer_email" name="email" value="{{ auth()->user()->email }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Votre email" required>
                        </div>
                        <div>
                            <label for="review_comment" class="block text-sm font-medium text-gray-700 mb-2">Commentaire</label>
                            <textarea id="review_comment" name="comment" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Votre commentaire"></textarea>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="save_info" name="save_info" class="mr-2">
                            <label for="save_info" class="text-sm text-gray-600">
                                Enregistrez mon nom, mon e-mail et mon site web dans ce navigateur pour la prochaine fois que je commenterai.
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                            Publier un commentaire
                        </button>
                    </form>
                @else
                    <p class="text-gray-600 mb-4">Vous devez être connecté pour laisser un avis.</p>
                    <a href="{{ route('login') }}" class="inline-block bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                        Se connecter
                    </a>
                @endauth
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sticky top-4 self-start">
            <!-- Organisateur -->
            <div class="bg-gray-100 rounded-lg p-6">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                            {{ strtoupper(substr($event->organizer->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $event->organizer->name }}</h3>
                            <p class="text-sm text-gray-500">ORGANISATEUR</p>
                        </div>
                    </div>
                    @if($event->organizer->phone || $event->organizer->email)
                        <div class="space-y-2 mb-4">
                            @if($event->organizer->phone)
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-phone text-red-600 mr-2 w-5"></i>
                                    <span>{{ $event->organizer->phone }}</span>
                                </div>
                            @endif
                            @if($event->organizer->email)
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class="fas fa-envelope text-red-600 mr-2 w-5"></i>
                                    <span>{{ $event->organizer->email }}</span>
                                </div>
                            @endif
                        </div>
                    @endif
                    <button onclick="contactOrganizer()" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Envoyer un message</span>
                    </button>
                </div>
            </div>

            <!-- Galerie -->
            @if($event->gallery && count($event->gallery) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold mb-4">Galerie</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(array_slice($event->gallery, 0, 4) as $image)
                            <img src="{{ asset('storage/' . $image) }}" alt="Galerie {{ $event->title }}" class="w-full h-32 object-cover rounded-lg">
                        @endforeach
                    </div>
                    @if(count($event->gallery) > 4)
                        <button class="mt-3 w-full text-red-600 hover:text-red-700 font-semibold">
                            Voir toutes les photos ({{ count($event->gallery) }})
                        </button>
                    @endif
                </div>
            @endif

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistiques</h3>
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
        </div>
    </div>
</div>

@push('styles')
@if($event->venue_latitude && $event->venue_longitude || $event->venue_address)
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #eventMap {
        width: 100% !important;
        height: 384px !important;
        min-height: 384px !important;
        position: relative !important;
        z-index: 10 !important;
        background: #e5e7eb !important;
    }
    .leaflet-container {
        width: 100% !important;
        height: 100% !important;
        z-index: 10 !important;
        background: #e5e7eb !important;
        position: relative !important;
    }
    .leaflet-tile-container {
        z-index: 1 !important;
    }
    .leaflet-tile-container img {
        max-width: none !important;
        max-height: none !important;
        display: block !important;
    }
    .leaflet-tile {
        visibility: visible !important;
        opacity: 1 !important;
        display: block !important;
    }
    .leaflet-pane {
        z-index: 400 !important;
    }
    .leaflet-map-pane {
        z-index: 400 !important;
    }
    .leaflet-tile-pane {
        z-index: 200 !important;
    }
    .leaflet-overlay-pane {
        z-index: 400 !important;
    }
    .leaflet-shadow-pane {
        z-index: 500 !important;
    }
    .leaflet-marker-pane {
        z-index: 600 !important;
    }
    .leaflet-tooltip-pane {
        z-index: 650 !important;
    }
    .leaflet-popup-pane {
        z-index: 700 !important;
    }
</style>
@endif
@endpush

@push('scripts')
<script>
    // Gestion du panier de tickets
    (function() {
        let cart = {};
        
        function updateCart() {
            let totalItems = 0;
            let totalPrice = 0;
            
            Object.keys(cart).forEach(ticketTypeId => {
                const quantity = parseInt(cart[ticketTypeId]) || 0;
                if (quantity > 0) {
                    totalItems += quantity;
                    const input = document.querySelector(`[data-ticket-type-id="${ticketTypeId}"].ticket-quantity`);
                    if (input) {
                        const price = parseFloat(input.dataset.price);
                        totalPrice += price * quantity;
                    }
                }
            });
            
            // Mettre à jour l'affichage
            const cartTotalItems = document.getElementById('cart-total-items');
            const cartTotalPrice = document.getElementById('cart-total-price');
            
            if (cartTotalItems && cartTotalPrice) {
                cartTotalItems.textContent = totalItems;
                cartTotalPrice.textContent = totalPrice.toLocaleString('fr-FR');
                
                // Afficher/masquer le panier
                const cartElement = document.getElementById('ticket-cart');
                const checkoutBtn = document.getElementById('checkout-btn');
                
                if (totalItems > 0) {
                    cartElement.classList.remove('translate-y-full');
                    checkoutBtn.disabled = false;
                    
                    // Préparer les données pour le formulaire
                    const ticketsData = Object.keys(cart).map(ticketTypeId => ({
                        ticket_type_id: ticketTypeId,
                        quantity: cart[ticketTypeId]
                    })).filter(item => item.quantity > 0);
                    
                    document.getElementById('tickets-data').value = JSON.stringify(ticketsData);
                } else {
                    cartElement.classList.add('translate-y-full');
                    checkoutBtn.disabled = true;
                }
            }
        }
        
        function updateQuantity(ticketTypeId, change) {
            const input = document.querySelector(`[data-ticket-type-id="${ticketTypeId}"].ticket-quantity`);
            if (!input) return;
            
            const max = parseInt(input.getAttribute('max')) || 0;
            const current = parseInt(cart[ticketTypeId] || 0);
            const newQuantity = Math.max(0, Math.min(max, current + change));
            
            cart[ticketTypeId] = newQuantity;
            input.value = newQuantity;
            
            // Mettre à jour l'état des boutons
            const decreaseBtn = document.querySelector(`[data-ticket-type-id="${ticketTypeId}"].ticket-decrease`);
            const increaseBtn = document.querySelector(`[data-ticket-type-id="${ticketTypeId}"].ticket-increase`);
            
            if (decreaseBtn) decreaseBtn.disabled = newQuantity === 0;
            if (increaseBtn) increaseBtn.disabled = newQuantity >= max;
            
            updateCart();
        }
        
        // Écouter les clics sur les boutons + et -
        document.addEventListener('click', function(e) {
            if (e.target.closest('.ticket-increase')) {
                const btn = e.target.closest('.ticket-increase');
                const ticketTypeId = btn.dataset.ticketTypeId;
                updateQuantity(ticketTypeId, 1);
            } else if (e.target.closest('.ticket-decrease')) {
                const btn = e.target.closest('.ticket-decrease');
                const ticketTypeId = btn.dataset.ticketTypeId;
                updateQuantity(ticketTypeId, -1);
            }
        });
        
        // Initialiser l'état des boutons au chargement
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.ticket-quantity').forEach(input => {
                const ticketTypeId = input.dataset.ticketTypeId;
                cart[ticketTypeId] = 0;
                const decreaseBtn = document.querySelector(`[data-ticket-type-id="${ticketTypeId}"].ticket-decrease`);
                if (decreaseBtn) decreaseBtn.disabled = true;
            });
        });
    })();
    
    // Système de notation avec étoiles
    const stars = document.querySelectorAll('#rating-stars button');
    const ratingInput = document.getElementById('rating-value');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        star.addEventListener('mouseenter', () => {
            updateStars(index + 1);
        });
    });
    
    document.getElementById('rating-stars').addEventListener('mouseleave', () => {
        const currentRating = parseInt(ratingInput.value);
        updateStars(currentRating);
    });
    
    function updateStars(rating) {
        stars.forEach((star, index) => {
            const icon = star.querySelector('i');
            if (index < rating) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.classList.remove('text-gray-300');
                icon.classList.add('text-yellow-400');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.classList.remove('text-yellow-400');
                icon.classList.add('text-gray-300');
            }
        });
    }
    
    function shareEvent() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $event->title }}',
                text: '{{ Str::limit($event->description, 100) }}',
                url: window.location.href
            });
        } else {
            // Fallback: copier le lien
            navigator.clipboard.writeText(window.location.href);
            alert('Lien copié dans le presse-papiers !');
        }
    }
    
    function reportEvent() {
        if (confirm('Voulez-vous signaler cet événement ?')) {
            // TODO: Implémenter la fonctionnalité de signalement
            alert('Fonctionnalité de signalement à venir');
        }
    }
    
    function addToCalendar() {
        // TODO: Générer un fichier .ics pour ajouter au calendrier
        alert('Fonctionnalité d\'ajout au calendrier à venir');
    }
    
    function contactOrganizer() {
        // TODO: Ouvrir un formulaire de contact
        alert('Fonctionnalité de contact à venir');
    }
</script>
@if($event->venue_latitude && $event->venue_longitude || $event->venue_address)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
(function() {
    function initMap() {
        if (typeof L === 'undefined') {
            console.log('Attente de Leaflet...');
            setTimeout(initMap, 200);
            return;
        }
        
        const mapDiv = document.getElementById('eventMap');
        if (!mapDiv) {
            console.log('Attente du conteneur...');
            setTimeout(initMap, 200);
            return;
        }
        
        const rect = mapDiv.getBoundingClientRect();
        if (rect.width === 0 || rect.height === 0) {
            console.log('Conteneur non visible, attente... Dimensions:', rect.width, 'x', rect.height);
            setTimeout(initMap, 200);
            return;
        }
        
        // Forcer la visibilité du conteneur
        mapDiv.style.display = 'block';
        mapDiv.style.visibility = 'visible';
        mapDiv.style.opacity = '1';
        mapDiv.style.width = '100%';
        mapDiv.style.height = '384px';
        mapDiv.style.minHeight = '384px';
        mapDiv.style.position = 'relative';
        mapDiv.style.zIndex = '10';
        mapDiv.style.background = '#e5e7eb';
        
        console.log('Initialisation de la carte...', 'Dimensions:', rect.width, 'x', rect.height);
            
            @if($event->venue_latitude && $event->venue_longitude)
                // Si les coordonnées existent, les utiliser directement
                const lat = {{ $event->venue_latitude }};
                const lng = {{ $event->venue_longitude }};
                
                console.log('Coordonnées:', lat, lng);
                
                // Vérifier que les coordonnées sont valides
                if (isNaN(lat) || isNaN(lng) || lat === 0 || lng === 0) {
                    console.error('Coordonnées invalides:', lat, lng);
                    return;
                }
                
                try {
                    // S'assurer que le conteneur a les bonnes dimensions
                    mapDiv.style.width = '100%';
                    mapDiv.style.height = '384px';
                    mapDiv.style.minHeight = '384px';
                    mapDiv.style.position = 'relative';
                    mapDiv.style.zIndex = '10';
                    mapDiv.style.background = '#e5e7eb';
                    
                    // Initialiser la carte
                    const map = L.map('eventMap', {
                        zoomControl: true,
                        scrollWheelZoom: true,
                        preferCanvas: false,
                        fadeAnimation: true,
                        zoomAnimation: true,
                        attributionControl: true
                    }).setView([lat, lng], 15);
                    
                    console.log('Carte initialisée avec succès');
                    
                    // Ajouter les tuiles avec retry
                    const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19,
                        minZoom: 1,
                        errorTileUrl: 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
                        crossOrigin: true,
                        tileSize: 256,
                        zoomOffset: 0
                    });
                    
                    tileLayer.on('tileerror', function(error, tile) {
                        console.error('Erreur de chargement de tuile:', error, tile);
                    });
                    
                    tileLayer.on('tileload', function(e) {
                        console.log('Tuile chargée:', e.tile.src);
                    });
                    
                    tileLayer.on('load', function() {
                        console.log('Toutes les tuiles chargées');
                        map.invalidateSize();
                    });
                    
                    tileLayer.addTo(map);
                    console.log('Tuiles ajoutées');
                    
                    // Forcer le redimensionnement plusieurs fois avec délais
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement immédiat');
                    }, 100);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement après 300ms');
                    }, 300);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement après 600ms');
                    }, 600);
                    
                    // Ajouter le marqueur
                    const marker = L.marker([lat, lng]).addTo(map);
                    const popupContent = '{{ addslashes($event->venue_address ?? $event->venue_name ?? $event->venue_city ?? "Lieu de l\'événement") }}';
                    marker.bindPopup(popupContent).openPopup();
                    console.log('Marqueur ajouté');
                    
                    // Forcer le redimensionnement de la carte plusieurs fois
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement 1');
                    }, 100);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement 2');
                    }, 500);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement 3');
                    }, 1000);
                } catch (error) {
                    console.error('Erreur lors de l\'initialisation de la carte:', error);
                }
            @elseif($event->venue_address)
                // Si seulement l'adresse existe, géocoder l'adresse
                try {
                    // S'assurer que le conteneur a les bonnes dimensions
                    mapDiv.style.width = '100%';
                    mapDiv.style.height = '384px';
                    mapDiv.style.minHeight = '384px';
                    mapDiv.style.position = 'relative';
                    mapDiv.style.zIndex = '10';
                    mapDiv.style.background = '#e5e7eb';
                    
                    // Initialiser la carte avec une position par défaut
                    const map = L.map('eventMap', {
                        zoomControl: true,
                        scrollWheelZoom: true,
                        preferCanvas: false,
                        fadeAnimation: true,
                        zoomAnimation: true,
                        attributionControl: true
                    }).setView([6.4969, 2.6283], 13);
                    
                    console.log('Carte initialisée avec position par défaut');
                    
                    // Ajouter les tuiles
                    const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                        maxZoom: 19,
                        minZoom: 1,
                        errorTileUrl: 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
                        crossOrigin: true,
                        tileSize: 256,
                        zoomOffset: 0
                    });
                    
                    tileLayer.on('tileerror', function(error, tile) {
                        console.error('Erreur de chargement de tuile:', error, tile);
                    });
                    
                    tileLayer.on('tileload', function(e) {
                        console.log('Tuile chargée:', e.tile.src);
                    });
                    
                    tileLayer.on('load', function() {
                        console.log('Toutes les tuiles chargées');
                        map.invalidateSize();
                    });
                    
                    tileLayer.addTo(map);
                    console.log('Tuiles ajoutées');
                    
                    // Forcer le redimensionnement plusieurs fois avec délais
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement immédiat');
                    }, 100);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement après 300ms');
                    }, 300);
                    
                    setTimeout(function() {
                        map.invalidateSize();
                        console.log('Redimensionnement après 600ms');
                    }, 600);
                    
                    // Construire l'adresse complète
                    let fullAddress = '{{ addslashes($event->venue_address) }}';
                    @if($event->venue_city)
                        fullAddress += ', {{ addslashes($event->venue_city) }}';
                    @endif
                    @if($event->venue_country)
                        fullAddress += ', {{ addslashes($event->venue_country) }}';
                    @endif
                    
                    console.log('Géocodage de l\'adresse:', fullAddress);
                    
                    // Géocoder l'adresse
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}&limit=1&addressdetails=1`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erreur HTTP: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Données de géocodage:', data);
                            if (data && data.length > 0) {
                                const lat = parseFloat(data[0].lat);
                                const lng = parseFloat(data[0].lon);
                                
                                if (isNaN(lat) || isNaN(lng)) {
                                    console.error('Coordonnées invalides après géocodage');
                                    return;
                                }
                                
                                // Centrer la carte sur la nouvelle position
                                map.setView([lat, lng], 15);
                                
                                // Ajouter le marqueur
                                const popupContent = '{{ addslashes($event->venue_address ?? $event->venue_name ?? $event->venue_city ?? "Lieu de l\'événement") }}';
                                L.marker([lat, lng])
                                    .addTo(map)
                                    .bindPopup(popupContent)
                                    .openPopup();
                                
                                // Forcer le redimensionnement
                                setTimeout(function() {
                                    map.invalidateSize();
                                }, 100);
                            } else {
                                console.warn('Aucun résultat de géocodage trouvé');
                            }
                        })
                        .catch(error => {
                            console.error('Erreur de géocodage:', error);
                        });
                } catch (error) {
                    console.error('Erreur lors de l\'initialisation de la carte:', error);
                }
            @endif
    }
    
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initMap, 1000);
        });
    } else {
        setTimeout(initMap, 1000);
    }
})();
</script>
@endpush
@endif
@endsection
