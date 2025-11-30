@extends('layouts.app')

@push('head')
<!-- SEO Meta Tags optimisés pour l'Afrique -->
<meta name="description" content="Tikehub - Plateforme de billetterie en ligne pour événements, concours et collectes de fonds en Afrique. Créez, gérez et vendez vos billets facilement avec notre CRM intégré. Paiements sécurisés via Moneroo. Commission transparente de {{ $commissionRate }}%.">
<meta name="keywords" content="billetterie en ligne, événements Afrique, vente de billets, gestion d'événements, CRM événements, concours en ligne, collectes de fonds, paiements mobiles Afrique, Moneroo, XOF, Bénin, Côte d'Ivoire, Sénégal, Togo, Burkina Faso">
<meta name="author" content="Tikehub">
<meta name="robots" content="index, follow">
<meta name="language" content="French">
<meta name="geo.region" content="AF">
<meta name="geo.placename" content="Afrique de l'Ouest">
<meta name="distribution" content="global">
<meta name="rating" content="general">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:title" content="Tikehub - Plateforme de Billetterie en Ligne pour l'Afrique">
<meta property="og:description" content="Créez, gérez et vendez vos billets d'événements facilement. CRM intégré, paiements sécurisés, concours et collectes de fonds. Commission transparente de {{ $commissionRate }}%.">
<meta property="og:image" content="{{ asset('images/og-image.jpg') }}">
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="Tikehub">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url('/') }}">
<meta property="twitter:title" content="Tikehub - Plateforme de Billetterie en Ligne pour l'Afrique">
<meta property="twitter:description" content="Créez, gérez et vendez vos billets d'événements facilement. CRM intégré, paiements sécurisés, concours et collectes de fonds.">
<meta property="twitter:image" content="{{ asset('images/og-image.jpg') }}">

<!-- Structured Data JSON-LD -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Tikehub",
  "url": "{{ url('/') }}",
  "logo": "{{ asset('images/logo.png') }}",
  "description": "Plateforme de billetterie en ligne pour événements, concours et collectes de fonds en Afrique",
  "address": {
    "@type": "PostalAddress",
    "addressCountry": "BJ",
    "addressRegion": "Afrique de l'Ouest"
  },
  "contactPoint": {
    "@type": "ContactPoint",
    "contactType": "Customer Service",
    "availableLanguage": ["French"]
  },
  "sameAs": [
    "https://www.facebook.com/tikehub",
    "https://www.twitter.com/tikehub",
    "https://www.instagram.com/tikehub"
  ],
  "offers": {
    "@type": "Offer",
    "price": "{{ $commissionRate }}",
    "priceCurrency": "XOF",
    "description": "Commission de {{ $commissionRate }}% sur les ventes"
  }
}
</script>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "Tikehub",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "{{ url('/events?search={search_term_string}') }}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endpush

@section('title', 'Tikehub - Plateforme de Billetterie en Ligne pour l\'Afrique | Événements, Concours & Collectes')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white py-16 sm:py-20 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-4 sm:mb-6 leading-tight">
                Organisez vos événements<br>
                <span class="text-yellow-300">en toute simplicité</span>
            </h1>
            <p class="text-lg sm:text-xl md:text-2xl mb-6 sm:mb-8 text-indigo-100 max-w-3xl mx-auto">
                La plateforme complète pour créer, gérer et vendre des billets pour vos événements en Afrique. 
                CRM intégré, paiements sécurisés, concours et collectes de fonds.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('events.index') }}" class="bg-white text-indigo-600 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:bg-indigo-50 transition duration-300 shadow-lg min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-calendar-alt mr-2"></i>Découvrir les événements
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-indigo-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-tachometer-alt mr-2"></i>Mon tableau de bord
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-indigo-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold text-base sm:text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>Créer un compte
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-8 text-center">
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-3xl md:text-4xl font-bold text-indigo-600 mb-2">{{ $stats['total_events'] }}</div>
                <div class="text-sm md:text-base text-gray-600">Événements</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-3xl md:text-4xl font-bold text-purple-600 mb-2">{{ $stats['active_contests'] }}</div>
                <div class="text-sm md:text-base text-gray-600">Concours actifs</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-3xl md:text-4xl font-bold text-green-600 mb-2">{{ $stats['active_fundraisings'] }}</div>
                <div class="text-sm md:text-base text-gray-600">Collectes actives</div>
            </div>
            <div class="bg-white p-4 md:p-6 rounded-lg shadow-md hover:shadow-lg transition">
                <div class="text-3xl md:text-4xl font-bold text-yellow-600 mb-2">100%</div>
                <div class="text-sm md:text-base text-gray-600">Sécurisé</div>
            </div>
        </div>
    </div>
</section>

<!-- Section Commission Transparente -->
<section class="py-12 sm:py-16 bg-gradient-to-r from-green-50 to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl shadow-xl p-6 sm:p-8 lg:p-12 text-center">
            <div class="inline-block bg-green-100 rounded-full p-3 sm:p-4 mb-4">
                <i class="fas fa-percentage text-3xl sm:text-4xl text-green-600"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-4">
                Commission Transparente
            </h2>
            <p class="text-lg sm:text-xl text-gray-600 mb-6 max-w-2xl mx-auto">
                Nous prélevons uniquement <span class="font-bold text-green-600 text-2xl sm:text-3xl">{{ $commissionRate }}%</span> de commission sur chaque vente.
                <br class="hidden sm:block">
                <span class="text-sm sm:text-base text-gray-500">Aucun frais caché, tout est transparent.</span>
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6 mt-8">
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-2">0%</div>
                    <div class="text-sm text-gray-600">Frais d'inscription</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-2">{{ $commissionRate }}%</div>
                    <div class="text-sm text-gray-600">Commission par vente</div>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="text-2xl font-bold text-indigo-600 mb-2">0%</div>
                    <div class="text-sm text-gray-600">Frais de retrait</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Fonctionnalités Complètes -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Pourquoi choisir Tikehub ?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Une plateforme complète avec toutes les fonctionnalités dont vous avez besoin pour réussir vos événements
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Billetterie -->
            <div class="bg-white border-2 border-indigo-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-ticket-alt text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Billetterie Sécurisée</h3>
                <p class="text-gray-600 mb-4">QR codes uniques, billets numériques et physiques, tout en sécurité. Gestion multi-types de billets avec codes promo.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>QR codes uniques</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Billets numériques & physiques</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Codes promo intégrés</li>
                </ul>
            </div>

            <!-- CRM -->
            <div class="bg-white border-2 border-purple-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users-cog text-3xl text-purple-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">CRM Intégré</h3>
                <p class="text-gray-600 mb-4">Gérez vos contacts, segments, campagnes email, automations et sponsors. Pipeline de vente complet.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Gestion de contacts</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Campagnes email</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Automations marketing</li>
                </ul>
            </div>

            <!-- Paiements -->
            <div class="bg-white border-2 border-green-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-credit-card text-3xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Paiements Sécurisés</h3>
                <p class="text-gray-600 mb-4">Intégration Moneroo pour des paiements rapides et sécurisés. Support mobile money et cartes bancaires.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Moneroo intégré</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Mobile money</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Cartes bancaires</li>
                </ul>
            </div>

            <!-- Concours & Votes -->
            <div class="bg-white border-2 border-pink-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-pink-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-trophy text-3xl text-pink-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Concours & Votes</h3>
                <p class="text-gray-600 mb-4">Créez des concours avec votes payants. Gérez les candidats, suivez les votes en temps réel.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Votes payants</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Gestion de candidats</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Statistiques en temps réel</li>
                </ul>
            </div>

            <!-- Collectes de Fonds -->
            <div class="bg-white border-2 border-red-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-red-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-heart text-3xl text-red-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Collectes de Fonds</h3>
                <p class="text-gray-600 mb-4">Organisez des collectes de fonds pour vos causes. Suivez les dons et la progression en temps réel.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Dons sécurisés</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Barre de progression</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Messages de donateurs</li>
                </ul>
            </div>

            <!-- Rapports & Analytics -->
            <div class="bg-white border-2 border-yellow-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-chart-line text-3xl text-yellow-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Rapports Détaillés</h3>
                <p class="text-gray-600 mb-4">Suivez vos ventes, performances et statistiques en temps réel. Exportez vos données facilement.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Statistiques en temps réel</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Export Excel/PDF</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Graphiques interactifs</li>
                </ul>
            </div>

            <!-- Événements Virtuels -->
            <div class="bg-white border-2 border-blue-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-video text-3xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Événements Virtuels</h3>
                <p class="text-gray-600 mb-4">Organisez des événements en ligne avec intégration Zoom, Teams et autres plateformes de visioconférence.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Intégration Zoom/Teams</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Accès sécurisé</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Gestion des participants</li>
                </ul>
            </div>

            <!-- Gestion d'Équipe -->
            <div class="bg-white border-2 border-indigo-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-indigo-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-users text-3xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Gestion d'Équipe</h3>
                <p class="text-gray-600 mb-4">Créez des équipes, assignez des agents, gérez les permissions et suivez les performances de votre équipe.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Équipes & agents</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Gestion des permissions</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Tâches assignées</li>
                </ul>
            </div>

            <!-- Support Client -->
            <div class="bg-white border-2 border-teal-100 rounded-xl p-6 hover:shadow-lg transition">
                <div class="bg-teal-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-headset text-3xl text-teal-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2 text-gray-800">Support Client</h3>
                <p class="text-gray-600 mb-4">Système de tickets intégré pour le support client. Chat en temps réel avec vos clients et organisateurs.</p>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Système de tickets</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Chat en temps réel</li>
                    <li><i class="fas fa-check text-green-500 mr-2"></i>Gestion des priorités</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Événements à venir -->
@if($upcomingEvents->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 sm:mb-0">Événements à venir</h2>
            <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($upcomingEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                {{ $event->category }}
                            </span>
                            <div class="flex gap-2">
                                @if($event->is_virtual)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-video mr-1"></i>Virtuel
                                    </span>
                                @endif
                                @if($event->is_free)
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Gratuit
                                    </span>
                                @endif
                            </div>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>{{ $event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                            @if($event->venue_city)
                                <span class="mx-2">•</span>
                                <i class="fas fa-map-marker-alt mr-2"></i>
                                <span>{{ $event->venue_city }}</span>
                            @endif
                        </div>
                        <span class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Voir l'événement
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Événements populaires -->
@if($popularEvents->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2 sm:mb-0">Événements populaires</h2>
            <a href="{{ route('events.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($popularEvents as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-yellow-200">
                    <a href="{{ route('events.show', $event) }}" class="block">
                        @if($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title ?? 'Événement' }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                                <i class="fas fa-fire text-6xl text-white opacity-50"></i>
                            </div>
                        @endif
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-fire mr-1"></i> Populaire
                            </span>
                            <div class="flex items-center gap-2">
                                @if($event->is_virtual)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        <i class="fas fa-video mr-1"></i>Virtuel
                                    </span>
                                @endif
                                <span class="text-sm text-gray-500">
                                    {{ $event->tickets_count ?? 0 }} billet(s) vendu(s)
                                </span>
                            </div>
                        </div>
                        <a href="{{ route('events.show', $event) }}" class="block">
                            <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition">{{ $event->title ?? 'Sans titre' }}</h3>
                        </a>
                        @if($event->description)
                            <p class="text-gray-600 text-sm mb-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                        @endif
                        @if($event->start_date)
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <i class="fas fa-calendar mr-2"></i>
                                <span>{{ $event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                                @if($event->venue_city)
                                    <span class="mx-2">•</span>
                                    <i class="fas fa-map-marker-alt mr-2"></i>
                                    <span>{{ $event->venue_city }}</span>
                                @endif
                            </div>
                        @endif
                        @if($event->organizer)
                            <div class="flex items-center text-sm text-gray-600 mb-2">
                                <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                                <span>Par</span>
                                <a href="{{ route('organizer.profile.show', $event->organizer) }}" class="ml-1 text-indigo-600 hover:text-indigo-800 font-semibold hover:underline" onclick="event.stopPropagation()">
                                    {{ $event->organizer->name }}
                                </a>
                            </div>
                        @endif
                        @php
                            $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                        @endphp
                        @if($minPrice > 0)
                            <div class="mb-4">
                                <span class="text-lg font-bold text-indigo-600">
                                    À partir de {{ number_format($minPrice, 0, ',', ' ') }} XOF
                                </span>
                            </div>
                        @elseif($event->is_free)
                            <div class="mb-4">
                                <span class="text-lg font-bold text-green-600">
                                    Gratuit
                                </span>
                            </div>
                        @endif
                        <a href="{{ route('events.show', $event) }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">
                            Voir l'événement
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Prêt à organiser votre événement ?</h2>
        <p class="text-xl mb-8 text-indigo-100">Rejoignez des milliers d'organisateurs qui font confiance à Tikehub en Afrique</p>
        @auth
            @if(auth()->user()->isOrganizer())
                <a href="{{ route('events.create') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg inline-block min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-plus-circle mr-2"></i>Créer un événement
                </a>
            @else
                <a href="{{ route('events.index') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg inline-block min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-calendar-alt mr-2"></i>Découvrir les événements
                </a>
            @endif
        @else
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-50 transition duration-300 shadow-lg min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-user-plus mr-2"></i>Créer un compte organisateur
                </a>
                <a href="{{ route('events.index') }}" class="bg-indigo-700 text-white px-8 py-4 rounded-lg font-semibold text-lg hover:bg-indigo-800 transition duration-300 border-2 border-white min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>Voir les événements
                </a>
            </div>
        @endauth
    </div>
</section>

<!-- Concours & Votes -->
@if($activeContests->count() > 0)
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Concours & Votes payants</h2>
                <p class="text-gray-600 mt-2">Participez aux concours et votez pour vos candidats favoris</p>
            </div>
            <a href="{{ route('contests.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center mt-4 sm:mt-0">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activeContests as $contest)
                <a href="{{ route('contests.show', $contest) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-purple-200">
                    @if($contest->cover_image)
                        <img src="{{ asset('storage/' . $contest->cover_image) }}" alt="{{ $contest->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-vote-yea mr-1"></i> Concours
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="text-lg font-bold text-purple-600">
                                À partir de {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF/vote
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-purple-600 transition">{{ $contest->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($contest->description, 100) }}</p>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Jusqu'au {{ $contest->end_date->format('d/m/Y') }}</span>
                            <span class="mx-2">•</span>
                            <i class="fas fa-users mr-2"></i>
                            <span>{{ $contest->votes_count }} vote(s)</span>
                        </div>
                        <span class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-300">
                            Voir le concours
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Collectes de fonds -->
@if($activeFundraisings->count() > 0)
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Collectes de fonds</h2>
                <p class="text-gray-600 mt-2">Soutenez des causes qui vous tiennent à cœur</p>
            </div>
            <a href="{{ route('fundraisings.index') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center mt-4 sm:mt-0">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($activeFundraisings as $fundraising)
                <a href="{{ route('fundraisings.show', $fundraising) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-green-200">
                    @if($fundraising->cover_image)
                        <img src="{{ asset('storage/' . $fundraising->cover_image) }}" alt="{{ $fundraising->name }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-hand-holding-heart mr-1"></i> Collecte
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ number_format($fundraising->progress_percentage, 0) }}%
                            </span>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-green-600 transition">{{ $fundraising->name }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($fundraising->description, 100) }}</p>
                        
                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-xs text-gray-600 mb-1">
                                <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                            </div>
                        </div>

                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-calendar mr-2"></i>
                            <span>Jusqu'au {{ $fundraising->end_date->format('d/m/Y') }}</span>
                        </div>
                        <span class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                            Contribuer
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Catégories -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Explorez par catégorie</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @php
                $categories = ['Concert', 'Sport', 'Culture', 'Business', 'Éducation', 'Autre'];
            @endphp
            @foreach($categories as $category)
                <a href="{{ route('events.index', ['category' => $category]) }}" class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300 text-center group">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition duration-300">
                        @if($category === 'Concert')
                            <i class="fas fa-music text-indigo-600"></i>
                        @elseif($category === 'Sport')
                            <i class="fas fa-futbol text-green-600"></i>
                        @elseif($category === 'Culture')
                            <i class="fas fa-theater-masks text-purple-600"></i>
                        @elseif($category === 'Business')
                            <i class="fas fa-briefcase text-blue-600"></i>
                        @elseif($category === 'Éducation')
                            <i class="fas fa-graduation-cap text-yellow-600"></i>
                        @else
                            <i class="fas fa-star text-gray-600"></i>
                        @endif
                    </div>
                    <div class="font-semibold text-gray-800">{{ $category }}</div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
