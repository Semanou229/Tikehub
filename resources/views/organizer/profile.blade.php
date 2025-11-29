@extends('layouts.app')

@section('title', 'Profil de ' . $organizer->name . ' - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header du profil -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                <!-- Avatar -->
                <div class="flex-shrink-0">
                    @if($organizer->avatar)
                        <img src="{{ asset('storage/' . $organizer->avatar) }}" alt="{{ $organizer->name }}" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    @else
                        <div class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white flex items-center justify-center">
                            <span class="text-4xl font-bold text-indigo-600">{{ strtoupper(substr($organizer->name, 0, 2)) }}</span>
                        </div>
                    @endif
                </div>
                
                <!-- Informations -->
                <div class="flex-1 text-center md:text-left text-white">
                    <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $organizer->name }}</h1>
                    @if($organizer->company_name)
                        <p class="text-xl text-indigo-100 mb-2">{{ $organizer->company_name }}</p>
                    @endif
                    @if($organizer->bio)
                        <p class="text-indigo-100 mb-4">{{ $organizer->bio }}</p>
                    @endif
                    
                    <!-- Statistiques -->
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold">{{ $stats['total_events'] }}</div>
                            <div class="text-sm text-indigo-100">Événements</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold">{{ $stats['total_contests'] }}</div>
                            <div class="text-sm text-indigo-100">Concours</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold">{{ $stats['total_fundraisings'] }}</div>
                            <div class="text-sm text-indigo-100">Collectes</div>
                        </div>
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <div class="text-2xl font-bold">{{ $stats['total_tickets_sold'] }}</div>
                            <div class="text-sm text-indigo-100">Billets vendus</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Informations de contact -->
        <div class="p-6">
            <div class="flex flex-wrap items-center gap-6">
                @if($organizer->phone)
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-phone text-indigo-600 mr-2"></i>
                        <span>{{ $organizer->phone }}</span>
                    </div>
                @endif
                @if($organizer->email)
                    <div class="flex items-center text-gray-700">
                        <i class="fas fa-envelope text-indigo-600 mr-2"></i>
                        <span>{{ $organizer->email }}</span>
                    </div>
                @endif
                
                <!-- Réseaux sociaux -->
                @php
                    $socialNetworks = [
                        'facebook' => ['url' => $organizer->facebook_url, 'icon' => 'fab fa-facebook-f', 'color' => 'text-blue-600'],
                        'twitter' => ['url' => $organizer->twitter_url, 'icon' => 'fab fa-twitter', 'color' => 'text-blue-400'],
                        'instagram' => ['url' => $organizer->instagram_url, 'icon' => 'fab fa-instagram', 'color' => 'text-pink-600'],
                        'linkedin' => ['url' => $organizer->linkedin_url, 'icon' => 'fab fa-linkedin-in', 'color' => 'text-blue-700'],
                        'youtube' => ['url' => $organizer->youtube_url, 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                        'website' => ['url' => $organizer->website_url, 'icon' => 'fas fa-globe', 'color' => 'text-gray-600'],
                    ];
                    $hasSocialNetworks = collect($socialNetworks)->filter(fn($network) => !empty($network['url']))->isNotEmpty();
                @endphp
                
                @if($hasSocialNetworks)
                    <div class="flex items-center gap-3">
                        @foreach($socialNetworks as $name => $network)
                            @if(!empty($network['url']))
                                <a href="{{ $network['url'] }}" target="_blank" rel="noopener noreferrer" 
                                   class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition {{ $network['color'] }}"
                                   title="{{ ucfirst($name) }}">
                                    <i class="{{ $network['icon'] }}"></i>
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Navigation par onglets -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="border-b border-gray-200">
            <nav class="flex -mb-px">
                <button onclick="showTab('events')" id="tab-events" class="tab-button active px-6 py-4 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                    Événements
                </button>
                <button onclick="showTab('contests')" id="tab-contests" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Concours
                </button>
                <button onclick="showTab('fundraisings')" id="tab-fundraisings" class="tab-button px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Collectes
                </button>
            </nav>
        </div>
    </div>

    <!-- Contenu des onglets -->
    <!-- Événements -->
    <div id="content-events" class="tab-content">
        <!-- Événements en cours -->
        @if($activeEvents->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Événements en cours</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            @if($event->cover_image)
                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="p-4">
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
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition">{{ $event->title }}</h3>
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                                </div>
                                @if($event->organizer)
                                    <div class="flex items-center text-sm text-gray-600 mb-2">
                                        <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                                        <span>Par</span>
                                        <a href="{{ route('organizer.profile.show', $event->organizer) }}" class="ml-1 text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                                            {{ $event->organizer->name }}
                                        </a>
                                    </div>
                                @endif
                                @php
                                    $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                                @endphp
                                @if($minPrice > 0)
                                    <div class="mb-2">
                                        <span class="text-sm font-bold text-indigo-600">
                                            À partir de {{ number_format($minPrice, 0, ',', ' ') }} XOF
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Événements terminés -->
        @if($pastEvents->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Événements terminés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pastEvents as $event)
                        <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            @if($event->cover_image)
                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-6xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $event->title }}</h3>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-calendar mr-2"></i>
                                    <span>{{ $event->start_date->translatedFormat('d/m/Y') }}</span>
                                </div>
                                <span class="inline-block mt-2 px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeEvents->count() == 0 && $pastEvents->count() == 0)
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun événement disponible</p>
            </div>
        @endif
    </div>

    <!-- Concours -->
    <div id="content-contests" class="tab-content hidden">
        <!-- Concours en cours -->
        @if($activeContests->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Concours en cours</h2>
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
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-purple-600 transition">{{ $contest->name }}</h3>
                                <div class="mb-2">
                                    <span class="text-sm font-bold text-purple-600">
                                        À partir de {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF/vote
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500">
                                    <i class="fas fa-users mr-2"></i>
                                    <span>{{ $contest->votes_count }} vote(s)</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Concours terminés -->
        @if($pastContests->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Concours terminés</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pastContests as $contest)
                        <a href="{{ route('contests.show', $contest) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            @if($contest->cover_image)
                                <img src="{{ asset('storage/' . $contest->cover_image) }}" alt="{{ $contest->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $contest->name }}</h3>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeContests->count() == 0 && $pastContests->count() == 0)
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucun concours disponible</p>
            </div>
        @endif
    </div>

    <!-- Collectes -->
    <div id="content-fundraisings" class="tab-content hidden">
        <!-- Collectes en cours -->
        @if($activeFundraisings->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Collectes en cours</h2>
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
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800 hover:text-green-600 transition">{{ $fundraising->name }}</h3>
                                <div class="mb-2">
                                    <div class="flex justify-between text-xs text-gray-600 mb-1">
                                        <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                        <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-600">{{ number_format($fundraising->progress_percentage, 1) }}% atteint</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Collectes terminées -->
        @if($pastFundraisings->count() > 0)
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Collectes terminées</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($pastFundraisings as $fundraising)
                        <a href="{{ route('fundraisings.show', $fundraising) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 opacity-75">
                            @if($fundraising->cover_image)
                                <img src="{{ asset('storage/' . $fundraising->cover_image) }}" alt="{{ $fundraising->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center">
                                    <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="text-lg font-semibold mb-2 text-gray-800">{{ $fundraising->name }}</h3>
                                <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-gray-200 text-gray-700">
                                    Terminé
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        @if($activeFundraisings->count() == 0 && $pastFundraisings->count() == 0)
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500">Aucune collecte disponible</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function showTab(tabName) {
    // Masquer tous les contenus
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Désactiver tous les onglets
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'text-indigo-600', 'border-indigo-600');
        button.classList.add('text-gray-500');
    });
    
    // Afficher le contenu sélectionné
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activer l'onglet sélectionné
    const activeButton = document.getElementById('tab-' + tabName);
    activeButton.classList.add('active', 'text-indigo-600', 'border-b-2', 'border-indigo-600');
    activeButton.classList.remove('text-gray-500');
}
</script>
@endpush
@endsection

