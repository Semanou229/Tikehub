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
<section class="relative bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900 overflow-hidden" style="margin-top: 0 !important; padding-top: 0 !important; position: relative; z-index: 1;">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute inset-0" style="background-image: radial-gradient(circle, rgba(99, 102, 241, 0.3) 1px, transparent 1px); background-size: 30px 30px;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 items-center">
            <!-- Left Side: Content -->
            <div class="text-white z-10">
                <!-- Badge -->
                <div class="mb-3 sm:mb-4">
                    <span class="inline-block px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20">
                        BILLETTERIE, CONCOURS & COLLECTES
                    </span>
                </div>
                
                <!-- Main Title -->
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-4 leading-tight">
                    Plus facile, plus puissant,<br>
                    <span class="text-cyan-400">moins cher</span>
                </h1>
                
                <!-- Description -->
                <p class="text-sm sm:text-base md:text-lg text-gray-300 mb-4 sm:mb-5 leading-relaxed max-w-xl">
                    La plateforme complète pour créer, gérer et vendre vos événements, organiser des concours avec votes payants et lancer des collectes de fonds en Afrique.
                </p>
                
                <!-- Three Content Types - Animated Rotator -->
                <div class="relative h-28 sm:h-32 mb-4 sm:mb-5 overflow-hidden">
                    <div id="content-types-rotator" class="relative h-full">
                        <!-- Événements -->
                        <div class="content-type-card absolute inset-0 bg-white/10 backdrop-blur-sm rounded-lg p-3 sm:p-4 border border-white/20 transition-all duration-500 ease-in-out" data-type="event">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-calendar-alt text-white text-base sm:text-lg"></i>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-white">Événements</h3>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed line-clamp-2">
                                Créez et vendez des billets pour vos événements avec notre système de billetterie sécurisé
                            </p>
                        </div>
                        
                        <!-- Concours -->
                        <div class="content-type-card absolute inset-0 bg-white/10 backdrop-blur-sm rounded-lg p-3 sm:p-4 border border-white/20 transition-all duration-500 ease-in-out opacity-0 translate-x-full" data-type="contest">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-purple-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-trophy text-white text-base sm:text-lg"></i>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-white">Concours</h3>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed line-clamp-2">
                                Organisez des concours avec votes payants et suivez les résultats en temps réel
                            </p>
                        </div>
                        
                        <!-- Collectes -->
                        <div class="content-type-card absolute inset-0 bg-white/10 backdrop-blur-sm rounded-lg p-3 sm:p-4 border border-white/20 transition-all duration-500 ease-in-out opacity-0 translate-x-full" data-type="fundraising">
                            <div class="flex items-center mb-2">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-red-500 rounded-lg flex items-center justify-center mr-3 flex-shrink-0">
                                    <i class="fas fa-heart text-white text-base sm:text-lg"></i>
                                </div>
                                <h3 class="text-sm sm:text-base font-bold text-white">Collectes</h3>
                            </div>
                            <p class="text-xs text-gray-300 leading-relaxed line-clamp-2">
                                Lancez des collectes de fonds pour vos causes et suivez les dons en temps réel
                            </p>
                        </div>
                    </div>
                    
                    <!-- Dots Indicator -->
                    <div class="flex justify-center gap-2 mt-3">
                        <button class="type-dot w-2 h-2 rounded-full bg-cyan-400 transition-all duration-300" data-index="0"></button>
                        <button class="type-dot w-2 h-2 rounded-full bg-white/30 transition-all duration-300" data-index="1"></button>
                        <button class="type-dot w-2 h-2 rounded-full bg-white/30 transition-all duration-300" data-index="2"></button>
                    </div>
                </div>
                
                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                    <a href="{{ route('register') }}" class="bg-cyan-500 hover:bg-cyan-600 text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base transition duration-300 shadow-lg hover:shadow-xl min-h-[40px] sm:min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-plus-circle mr-2 text-xs sm:text-sm"></i>Créer une billetterie
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base transition duration-300 border-2 border-cyan-500/50 min-h-[40px] sm:min-h-[44px] flex items-center justify-center">
                            <i class="fas fa-tachometer-alt mr-2 text-xs sm:text-sm"></i>Mon tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-indigo-700 hover:bg-indigo-800 text-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base transition duration-300 border-2 border-cyan-500/50 min-h-[40px] sm:min-h-[44px] flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2 text-xs sm:text-sm"></i>Connexion
                        </a>
                    @endauth
                </div>
            </div>
            
            <!-- Right Side: Content Types Slider -->
            <div class="relative z-10">
                <div class="relative h-[280px] sm:h-[320px] lg:h-[360px] overflow-hidden">
                    @php
                        // Préparer les items pour le slider (un par type)
                        $sliderItems = collect();
                        
                        // Prendre un événement
                        $event = $upcomingEvents->first();
                        if ($event) {
                            $sliderItems->push([
                                'type' => 'event',
                                'title' => $event->title,
                                'date' => $event->start_date,
                                'location' => $event->venue_city,
                                'image' => $event->cover_image,
                                'url' => route('events.show', $event),
                            ]);
                        }
                        
                        // Prendre un concours
                        $contest = $activeContests->first();
                        if ($contest) {
                            $sliderItems->push([
                                'type' => 'contest',
                                'title' => $contest->name,
                                'date' => $contest->end_date,
                                'location' => null,
                                'image' => $contest->cover_image,
                                'url' => route('contests.show', $contest),
                                'price_per_vote' => $contest->price_per_vote,
                            ]);
                        }
                        
                        // Prendre une collecte
                        $fundraising = $activeFundraisings->first();
                        if ($fundraising) {
                            $sliderItems->push([
                                'type' => 'fundraising',
                                'title' => $fundraising->name,
                                'date' => $fundraising->end_date,
                                'location' => null,
                                'image' => $fundraising->cover_image,
                                'url' => route('fundraisings.show', $fundraising),
                                'progress' => $fundraising->progress_percentage,
                            ]);
                        }
                        
                        // Si pas d'items, créer des exemples
                        if ($sliderItems->isEmpty()) {
                            $sliderItems = collect([
                                ['type' => 'event', 'title' => 'Concert de Jazz', 'date' => now()->addDays(7), 'location' => 'Cotonou', 'image' => null, 'url' => '#'],
                                ['type' => 'contest', 'title' => 'Concours de Talents', 'date' => now()->addDays(14), 'location' => null, 'image' => null, 'url' => '#'],
                                ['type' => 'fundraising', 'title' => 'Collecte Solidaire', 'date' => now()->addDays(21), 'location' => null, 'image' => null, 'url' => '#'],
                            ]);
                        }
                    @endphp
                    
                    @foreach($sliderItems as $index => $item)
                        <div class="hero-slide-item absolute inset-0 transition-all duration-700 ease-in-out {{ $index === 0 ? 'opacity-100 translate-x-0 z-10' : 'opacity-0 translate-x-full z-0' }}" data-slide-index="{{ $index }}">
                            <a href="{{ $item['url'] ?? '#' }}" class="block h-full">
                                <div class="bg-white/10 backdrop-blur-sm rounded-xl border border-white/20 p-6 sm:p-8 h-full flex flex-col hover:bg-white/15 transition duration-300">
                                    @if(isset($item['image']) && $item['image'])
                                        <div class="relative h-32 sm:h-36 lg:h-40 mb-4 rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                        </div>
                                    @else
                                        <div class="relative h-32 sm:h-36 lg:h-40 mb-4 rounded-lg overflow-hidden bg-gradient-to-br 
                                            @if($item['type'] === 'event') from-indigo-500 to-purple-600
                                            @elseif($item['type'] === 'contest') from-purple-500 to-pink-600
                                            @else from-red-500 to-orange-600
                                            @endif flex items-center justify-center">
                                            <i class="fas 
                                                @if($item['type'] === 'event') fa-calendar-alt
                                                @elseif($item['type'] === 'contest') fa-trophy
                                                @else fa-heart
                                                @endif text-5xl sm:text-6xl text-white opacity-30"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1 flex flex-col">
                                        <div class="mb-3">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                                @if($item['type'] === 'event') bg-indigo-500/30 text-indigo-200 border border-indigo-400/30
                                                @elseif($item['type'] === 'contest') bg-purple-500/30 text-purple-200 border border-purple-400/30
                                                @else bg-red-500/30 text-red-200 border border-red-400/30
                                                @endif">
                                                @if($item['type'] === 'event')
                                                    <i class="fas fa-calendar-alt mr-1"></i>Événement
                                                @elseif($item['type'] === 'contest')
                                                    <i class="fas fa-trophy mr-1"></i>Concours
                                                @else
                                                    <i class="fas fa-heart mr-1"></i>Collecte
                                                @endif
                                            </span>
                                        </div>
                                        
                                        <h3 class="text-lg sm:text-xl font-bold text-white mb-3 line-clamp-2">
                                            {{ $item['title'] }}
                                        </h3>
                                        
                                        <div class="flex items-center text-sm text-gray-300 mb-3">
                                            @if(isset($item['date']))
                                                <i class="fas fa-calendar mr-2 text-cyan-400"></i>
                                                <span>{{ is_object($item['date']) ? $item['date']->format('d/m/Y') : date('d/m/Y', strtotime($item['date'])) }}</span>
                                            @endif
                                            @if(isset($item['location']) && $item['location'])
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-map-marker-alt mr-2 text-cyan-400"></i>
                                                <span>{{ $item['location'] }}</span>
                                            @endif
                                        </div>
                                        
                                        @if($item['type'] === 'contest' && isset($item['price_per_vote']))
                                            <div class="mt-auto pt-3 border-t border-white/10">
                                                <div class="text-xs text-gray-400 mb-1">Prix par vote</div>
                                                <div class="text-lg font-bold text-white">{{ number_format($item['price_per_vote'], 0, ',', ' ') }} XOF</div>
                                            </div>
                                        @elseif($item['type'] === 'fundraising' && isset($item['progress']))
                                            <div class="mt-auto pt-3 border-t border-white/10">
                                                <div class="text-xs text-gray-400 mb-1">Progression</div>
                                                <div class="text-lg font-bold text-white">{{ number_format($item['progress'], 0) }}%</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                <!-- Slider Navigation Dots -->
                @if($sliderItems->count() > 1)
                    <div class="flex justify-center gap-2 mt-4">
                        @foreach($sliderItems as $index => $item)
                            <button class="hero-slide-dot w-2 h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-cyan-400 w-8' : 'bg-white/30' }}" data-slide-index="{{ $index }}"></button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Categories Section - Animated Carousel -->
<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2">Explorez par catégorie</h2>
            <p class="text-gray-300 text-sm sm:text-base">Découvrez nos événements selon vos centres d'intérêt</p>
        </div>
        
        <div class="relative overflow-hidden">
            <div class="categories-wrapper">
                <div id="categories-carousel" class="flex gap-3 sm:gap-4">
                    @php
                        $categories = [
                            ['name' => 'Concert', 'icon' => 'fa-music', 'color' => 'indigo'],
                            ['name' => 'Sport', 'icon' => 'fa-futbol', 'color' => 'green'],
                            ['name' => 'Culture', 'icon' => 'fa-theater-masks', 'color' => 'purple'],
                            ['name' => 'Business', 'icon' => 'fa-briefcase', 'color' => 'blue'],
                            ['name' => 'Éducation', 'icon' => 'fa-graduation-cap', 'color' => 'yellow'],
                            ['name' => 'Autre', 'icon' => 'fa-star', 'color' => 'gray'],
                        ];
                    @endphp
                    
                    <!-- First set -->
                    @foreach($categories as $index => $category)
                        <a href="{{ route('events.index', ['category' => $category['name']]) }}" class="category-item group bg-white/10 backdrop-blur-sm rounded-lg p-4 sm:p-5 border border-white/20 hover:bg-white/20 hover:border-cyan-500/50 transition duration-300 text-center flex-shrink-0 min-w-[120px] sm:min-w-[140px] animate-float" style="animation-delay: {{ $index * 0.1 }}s;">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-{{ $category['color'] }}-500/20 group-hover:bg-{{ $category['color'] }}-500/30 rounded-lg flex items-center justify-center transition group-hover:scale-110">
                                    <i class="fas {{ $category['icon'] }} text-{{ $category['color'] }}-400 text-xl sm:text-2xl transition-transform"></i>
                                </div>
                            </div>
                            <div class="text-white font-semibold text-sm sm:text-base group-hover:text-cyan-400 transition">
                                {{ $category['name'] }}
                            </div>
                        </a>
                    @endforeach
                    
                    <!-- Duplicate set for seamless loop -->
                    @foreach($categories as $index => $category)
                        <a href="{{ route('events.index', ['category' => $category['name']]) }}" class="category-item group bg-white/10 backdrop-blur-sm rounded-lg p-4 sm:p-5 border border-white/20 hover:bg-white/20 hover:border-cyan-500/50 transition duration-300 text-center flex-shrink-0 min-w-[120px] sm:min-w-[140px] animate-float" style="animation-delay: {{ ($index + 6) * 0.1 }}s;">
                            <div class="mb-3 flex justify-center">
                                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-{{ $category['color'] }}-500/20 group-hover:bg-{{ $category['color'] }}-500/30 rounded-lg flex items-center justify-center transition group-hover:scale-110">
                                    <i class="fas {{ $category['icon'] }} text-{{ $category['color'] }}-400 text-xl sm:text-2xl transition-transform"></i>
                                </div>
                            </div>
                            <div class="text-white font-semibold text-sm sm:text-base group-hover:text-cyan-400 transition">
                                {{ $category['name'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    /* Hero Section - Override main margin */
    section:first-of-type {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
    
    /* Content Types Rotator Animation */
    .content-type-card {
        transform: translateX(0);
    }
    
    .content-type-card.hidden {
        opacity: 0;
        transform: translateX(-100%);
    }
    
    .content-type-card.active {
        opacity: 1;
        transform: translateX(0);
    }
    
    .content-type-card.next {
        opacity: 0;
        transform: translateX(100%);
    }
    
    .type-dot.active {
        background-color: rgb(34, 211, 238) !important;
        width: 1.5rem !important;
    }
    
    /* Categories Carousel Animation */
    .categories-wrapper {
        overflow: hidden;
        position: relative;
    }
    
    #categories-carousel {
        display: flex;
        width: fit-content;
        animation: scroll-categories 20s linear infinite;
    }
    
    @keyframes scroll-categories {
        0% {
            transform: translateX(0);
        }
        100% {
            transform: translateX(calc(-50% - 0.75rem));
        }
    }
    
    #categories-carousel:hover {
        animation-play-state: paused;
    }
    
    /* Ensure categories stay visible */
    .category-item {
        will-change: transform;
    }
    
    /* Float Animation for Categories */
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .animate-float {
        animation: float 3s ease-in-out infinite;
    }
    
    /* Pause animation on hover */
    #categories-carousel:hover .animate-float {
        animation-play-state: paused;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Content Types Rotator
    const contentCards = document.querySelectorAll('.content-type-card');
    const typeDots = document.querySelectorAll('.type-dot');
    let currentTypeIndex = 0;
    let typeInterval;
    
    function showContentType(index) {
        contentCards.forEach((card, i) => {
            card.classList.remove('active', 'hidden', 'next');
            if (i === index) {
                card.classList.add('active');
                card.style.opacity = '1';
                card.style.transform = 'translateX(0)';
            } else if (i < index) {
                card.classList.add('hidden');
                card.style.opacity = '0';
                card.style.transform = 'translateX(-100%)';
            } else {
                card.classList.add('next');
                card.style.opacity = '0';
                card.style.transform = 'translateX(100%)';
            }
        });
        
        typeDots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.add('active');
                dot.style.backgroundColor = 'rgb(34, 211, 238)';
                dot.style.width = '1.5rem';
            } else {
                dot.classList.remove('active');
                dot.style.backgroundColor = 'rgba(255, 255, 255, 0.3)';
                dot.style.width = '0.5rem';
            }
        });
        
        currentTypeIndex = index;
    }
    
    function nextContentType() {
        const nextIndex = (currentTypeIndex + 1) % contentCards.length;
        showContentType(nextIndex);
    }
    
    // Auto-rotate content types every 4 seconds
    function startTypeRotation() {
        typeInterval = setInterval(nextContentType, 4000);
    }
    
    // Click on dots to navigate
    typeDots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            clearInterval(typeInterval);
            showContentType(index);
            startTypeRotation();
        });
    });
    
    // Initialize
    showContentType(0);
    startTypeRotation();
    
    // Pause on hover
    const rotator = document.getElementById('content-types-rotator');
    if (rotator) {
        rotator.addEventListener('mouseenter', () => clearInterval(typeInterval));
        rotator.addEventListener('mouseleave', startTypeRotation);
    }
    
    // Hero Content Types Slider
    const heroSlideItems = document.querySelectorAll('.hero-slide-item');
    const heroSlideDots = document.querySelectorAll('.hero-slide-dot');
    
    if (heroSlideItems.length > 1) {
        let currentHeroSlide = 0;
        let heroSlideInterval;
        
        function showHeroSlide(index) {
            heroSlideItems.forEach((slide, i) => {
                if (i === index) {
                    slide.style.opacity = '1';
                    slide.style.transform = 'translateX(0)';
                    slide.style.zIndex = '10';
                } else {
                    slide.style.opacity = '0';
                    slide.style.zIndex = '0';
                    if (i < index) {
                        slide.style.transform = 'translateX(-100%)';
                    } else {
                        slide.style.transform = 'translateX(100%)';
                    }
                }
            });
            
            heroSlideDots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.add('bg-cyan-400', 'w-8');
                    dot.classList.remove('bg-white/30', 'w-2');
                } else {
                    dot.classList.add('bg-white/30', 'w-2');
                    dot.classList.remove('bg-cyan-400', 'w-8');
                }
            });
            
            currentHeroSlide = index;
        }
        
        function nextHeroSlide() {
            const nextIndex = (currentHeroSlide + 1) % heroSlideItems.length;
            showHeroSlide(nextIndex);
        }
        
        function startHeroSlideRotation() {
            if (heroSlideInterval) clearInterval(heroSlideInterval);
            heroSlideInterval = setInterval(nextHeroSlide, 4000); // Change every 4 seconds
        }
        
        // Click on dots to navigate
        heroSlideDots.forEach((dot, index) => {
            dot.addEventListener('click', () => {
                clearInterval(heroSlideInterval);
                showHeroSlide(index);
                startHeroSlideRotation();
            });
        });
        
        // Initialize hero slides
        showHeroSlide(0);
        startHeroSlideRotation();
        
        // Pause hero slide rotation on hover
        const heroSliderContainer = document.querySelector('.relative.z-10');
        if (heroSliderContainer) {
            heroSliderContainer.addEventListener('mouseenter', () => {
                if (heroSlideInterval) clearInterval(heroSlideInterval);
            });
            heroSliderContainer.addEventListener('mouseleave', startHeroSlideRotation);
        }
    }
});
</script>
@endpush

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
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border-2 border-indigo-200">
                    <a href="{{ route('events.show', $event) }}" class="block">
                        @if($event->cover_image)
                            <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title ?? 'Événement' }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                            </div>
                        @endif
                    </a>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-2">
                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                                <i class="fas fa-calendar-check mr-1"></i> À venir
                            </span>
                            <div class="flex items-center gap-2">
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

@endsection
