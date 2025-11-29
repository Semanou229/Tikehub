@extends('layouts.app')

@section('title', $contest->name . ' - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec date en rouge -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Date Box (Rouge) -->
            <div class="bg-purple-600 text-white p-6 text-center min-w-[120px] flex flex-col justify-center items-center">
                <div class="text-2xl font-bold uppercase">{{ $contest->start_date->translatedFormat('M') }}</div>
                <div class="text-5xl font-bold">{{ $contest->start_date->format('d') }}</div>
                <div class="text-lg mt-2">{{ $contest->start_date->translatedFormat('l') }}</div>
            </div>

            <!-- Contenu principal du header -->
            <div class="flex-1 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-purple-600 px-3 py-1 rounded-full text-xs font-semibold text-white">
                                <i class="fas fa-trophy mr-1"></i>Concours
                            </span>
                            @if($contest->isActive())
                                <span class="bg-green-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Actif</span>
                            @else
                                <span class="bg-gray-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Terminé</span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $contest->name }}</h1>
                        
                        <!-- Informations date et prix -->
                        <div class="space-y-2 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-purple-600 mr-3 w-5"></i>
                                <span>
                                    Du {{ $contest->start_date->translatedFormat('D, d M Y') }} 
                                    au {{ $contest->end_date->translatedFormat('D, d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-coins text-purple-600 mr-3 w-5"></i>
                                <span>{{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF par vote ({{ $contest->points_per_vote }} point(s))</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-purple-600 mr-3 w-5"></i>
                                <span>{{ number_format($contest->votes()->sum('points'), 0, ',', ' ') }} vote(s) total</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-2 md:min-w-[150px]">
                        <button onclick="shareContest()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>PARTAGER</span>
                        </button>
                        <button onclick="reportContest()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
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
        
        <!-- Modal de signalement -->
        <div id="reportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">Signaler ce concours</h3>
                    <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Raison du signalement *</label>
                        <select id="report-reason" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">Sélectionnez une raison</option>
                            <option value="inappropriate_content">Contenu inapproprié</option>
                            <option value="false_information">Informations erronées</option>
                            <option value="spam">Spam</option>
                            <option value="scam">Arnaque</option>
                            <option value="copyright">Violation de droits d'auteur</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Votre message *</label>
                        <textarea id="report-message" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                  placeholder="Décrivez le problème en détail..."></textarea>
                        <p class="text-xs text-gray-500 mt-1">Maximum 1000 caractères</p>
                    </div>
                    <div class="flex gap-2">
                        <button onclick="submitReport()" id="submit-report-btn"
                                class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-paper-plane mr-2"></i>Envoyer le signalement
                        </button>
                        <button onclick="closeReportModal()" 
                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Annuler
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
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Description</h2>
                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($contest->description)) !!}
                </div>

                <!-- Points à puces avec checkmarks verts -->
                <div class="space-y-3 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Votez pour votre candidat favori</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Chaque vote compte et fait la différence</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Concours organisé par {{ $contest->organizer->name }}</span>
                    </div>
                </div>

                <!-- Call to action avec icône -->
                @if($contest->isActive())
                    <div class="mt-6 p-4 bg-purple-50 border-l-4 border-purple-500 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-vote-yea text-purple-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">
                                Le concours est actuellement actif ! Votez maintenant pour soutenir votre candidat favori et l'aider à remporter la victoire.
                            </p>
                        </div>
                    </div>
                @endif

                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                        <p class="text-gray-700">
                            Ne manquez pas cette opportunité unique : participez au vote et faites gagner votre candidat préféré !
                        </p>
                    </div>
                </div>
            </div>

            <!-- Règles du concours -->
            @if($contest->rules)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Règles du concours</h2>
                    <div class="prose max-w-none">
                        {!! nl2br(e($contest->rules)) !!}
                    </div>
                </div>
            @endif

            <!-- Classement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Classement</h2>
                @if($ranking && $ranking->count() > 0)
                    <div class="space-y-4">
                        @foreach($ranking as $candidate)
                            @php
                                $totalPoints = (int)($candidate->total_points ?? 0);
                            @endphp
                            <div class="flex items-center p-4 border-2 rounded-lg {{ $candidate->position <= 3 ? 'border-yellow-400 bg-yellow-50' : 'border-gray-200' }}">
                                <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-full font-bold text-lg
                                    {{ $candidate->position === 1 ? 'bg-yellow-400 text-yellow-900' : ($candidate->position === 2 ? 'bg-gray-300 text-gray-800' : ($candidate->position === 3 ? 'bg-orange-300 text-orange-900' : 'bg-gray-200 text-gray-600')) }}">
                                    {{ $candidate->position }}
                                </div>
                                <div class="flex-1 ml-4">
                                    <h3 class="font-semibold text-lg">{{ $candidate->name }}</h3>
                                    @if($candidate->description)
                                        <p class="text-gray-600 text-sm mt-1">{{ \Illuminate\Support\Str::limit($candidate->description, 80) }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-600">{{ number_format($totalPoints, 0, ',', ' ') }}</div>
                                    <div class="text-sm text-gray-500">point(s)</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                @endif
            </div>

            <!-- Lieu sur carte -->
            @php
                $event = $contest->event;
                $hasLocation = $event && ($event->venue_latitude && $event->venue_longitude || $event->venue_address);
            @endphp
            @if($hasLocation)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Lieu sur carte</h2>
                    <div id="contestMap" class="w-full h-96 rounded-lg border border-gray-300 mb-4"></div>
                    @if($event->venue_name || $event->venue_address)
                        <div class="space-y-2 text-gray-700">
                            @if($event->venue_name)
                                <p class="font-semibold"><i class="fas fa-map-marker-alt text-purple-600 mr-2"></i>{{ $event->venue_name }}</p>
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

            <!-- Candidats -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Candidats</h2>
                @if($candidates && $candidates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($candidates as $candidate)
                            @php
                                $totalPoints = (int)($candidate->votes_sum_points ?? 0);
                            @endphp
                            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-purple-500 transition">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg mb-4 flex items-center justify-center">
                                        <i class="fas fa-user text-6xl text-white opacity-50"></i>
                                    </div>
                                @endif
                                
                                <div class="mb-4">
                                    <h3 class="text-xl font-semibold mb-2">{{ $candidate->name }}</h3>
                                    @if($candidate->description)
                                        <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($candidate->description, 120) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-2xl font-bold text-purple-600">{{ number_format($totalPoints, 0, ',', ' ') }}</div>
                                            <div class="text-xs text-gray-500">point(s)</div>
                                        </div>
                                        @if($candidate->number)
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                #{{ $candidate->number }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if($contest->isActive())
                                    @auth
                                        <form action="{{ route('contests.vote', ['contest' => $contest, 'candidate' => $candidate]) }}" method="POST" class="space-y-3">
                                            @csrf
                                            <div class="flex items-center gap-2">
                                                <label for="quantity_{{ $candidate->id }}" class="text-sm text-gray-700">Nombre de votes:</label>
                                                <input type="number" name="quantity" id="quantity_{{ $candidate->id }}" min="1" max="100" value="1" class="w-20 px-2 py-1 border border-gray-300 rounded text-center" required>
                                            </div>
                                            <button type="submit" class="block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                                                <i class="fas fa-vote-yea mr-2"></i>Voter pour {{ $candidate->name }}
                                            </button>
                                            <p class="text-xs text-gray-500 text-center">
                                                Total: {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF × <span id="total_{{ $candidate->id }}">1</span> = 
                                                <span class="font-semibold" id="amount_{{ $candidate->id }}">{{ number_format($contest->price_per_vote, 0, ',', ' ') }}</span> XOF
                                            </p>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block w-full bg-purple-600 text-white text-center px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                                            Se connecter pour voter
                                        </a>
                                    @endauth
                                @else
                                    <button disabled class="block w-full bg-gray-400 text-white text-center px-4 py-3 rounded-lg cursor-not-allowed font-semibold">
                                        Concours terminé
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                @endif
            </div>

            <!-- Calendrier du concours -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Calendrier du concours</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                Du {{ $contest->start_date->translatedFormat('l, d F Y') }} 
                                au {{ $contest->end_date->translatedFormat('l, d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Période de vote active
                            </p>
                        </div>
                        @if($contest->end_date->isPast())
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Terminé
                            </span>
                        @elseif($contest->start_date->isFuture())
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
        </div>

        <!-- Sidebar -->
        <div class="space-y-6 sticky top-4 self-start">
            <!-- Organisateur -->
            <div class="bg-gray-100 rounded-lg p-6">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                            {{ strtoupper(substr($contest->organizer->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $contest->organizer->name }}</h3>
                            <p class="text-sm text-gray-500">ORGANISATEUR</p>
                        </div>
                    </div>
                    
                    <!-- Réseaux sociaux -->
                    @php
                        $socialNetworks = [
                            'facebook' => ['url' => $contest->organizer->facebook_url, 'icon' => 'fab fa-facebook-f', 'color' => 'text-blue-600'],
                            'twitter' => ['url' => $contest->organizer->twitter_url, 'icon' => 'fab fa-twitter', 'color' => 'text-blue-400'],
                            'instagram' => ['url' => $contest->organizer->instagram_url, 'icon' => 'fab fa-instagram', 'color' => 'text-pink-600'],
                            'linkedin' => ['url' => $contest->organizer->linkedin_url, 'icon' => 'fab fa-linkedin-in', 'color' => 'text-blue-700'],
                            'youtube' => ['url' => $contest->organizer->youtube_url, 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                            'website' => ['url' => $contest->organizer->website_url, 'icon' => 'fas fa-globe', 'color' => 'text-gray-600'],
                        ];
                        $hasSocialNetworks = collect($socialNetworks)->filter(fn($network) => !empty($network['url']))->isNotEmpty();
                    @endphp
                    
                    @if($hasSocialNetworks)
                        <div class="flex flex-wrap gap-2 mb-4">
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
                    
                    @if($contest->organizer->phone)
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-phone text-purple-600 mr-2 w-5"></i>
                                <span>{{ $contest->organizer->phone }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <button onclick="contactOrganizer('{{ $contest->organizer->email }}')" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Envoyer un message</span>
                    </button>
                    
                    <!-- Modal pour afficher l'email -->
                    <div id="contactModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-xl font-bold">Contacter l'organisateur</h3>
                                <button onclick="closeContactModal()" class="text-gray-500 hover:text-gray-700">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email de l'organisateur</label>
                                    <div class="flex items-center gap-2">
                                        <input type="email" id="organizer-email" readonly 
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">
                                        <button onclick="copyEmail()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Votre message</label>
                                    <textarea id="contact-message" rows="4" 
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                                              placeholder="Écrivez votre message ici..."></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <a id="mailto-link" href="#" 
                                       class="flex-1 bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-center">
                                        <i class="fas fa-envelope mr-2"></i>Ouvrir dans votre client email
                                    </a>
                                    <button onclick="closeContactModal()" 
                                            class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                                        Annuler
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Informations</h3>
                <div class="space-y-3">
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Prix par vote</h3>
                        <p class="text-2xl font-bold text-purple-600">
                            {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Points par vote</h3>
                        <p class="text-lg text-gray-600">{{ $contest->points_per_vote }} point(s)</p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Période</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-calendar mr-2 text-purple-600"></i>
                            Du {{ $contest->start_date->translatedFormat('d/m/Y') }}<br>
                            au {{ $contest->end_date->translatedFormat('d/m/Y') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total votes</span>
                        <span class="font-semibold">{{ number_format($contest->votes()->sum('points'), 0, ',', ' ') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Candidats</span>
                        <span class="font-semibold">{{ $candidates->count() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Revenus</span>
                        <span class="font-semibold">{{ number_format($contest->votes()->count() * $contest->price_per_vote, 0, ',', ' ') }} XOF</span>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Partager</h3>
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

@if($hasLocation)
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush
@endif

@push('scripts')
<script>
    // Calculer le montant total en fonction du nombre de votes
    document.querySelectorAll('input[type="number"][name="quantity"]').forEach(input => {
        const candidateId = input.id.replace('quantity_', '');
        const pricePerVote = {{ $contest->price_per_vote }};
        
        input.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 1;
            const total = pricePerVote * quantity;
            
            document.getElementById('total_' + candidateId).textContent = quantity;
            document.getElementById('amount_' + candidateId).textContent = total.toLocaleString('fr-FR');
        });
    });
    
    function shareContest() {
        const shareData = {
            title: '{{ addslashes($contest->name) }}',
            text: '{{ addslashes(Str::limit(strip_tags($contest->description), 100)) }}',
            url: window.location.href
        };
        
        if (navigator.share && navigator.canShare && navigator.canShare(shareData)) {
            navigator.share(shareData).catch(err => {
                console.log('Erreur de partage:', err);
                fallbackShare();
            });
        } else {
            fallbackShare();
        }
        
        function fallbackShare() {
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(window.location.href).then(() => {
                    alert('Lien copié dans le presse-papiers !');
                }).catch(() => {
                    promptShare();
                });
            } else {
                promptShare();
            }
        }
        
        function promptShare() {
            const url = window.location.href;
            prompt('Copiez ce lien pour partager:', url);
        }
    }
    
    function reportContest() {
        const modal = document.getElementById('reportModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.getElementById('report-reason').value = '';
            document.getElementById('report-message').value = '';
        }
    }
    
    function closeReportModal() {
        const modal = document.getElementById('reportModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
    
    function submitReport() {
        const reason = document.getElementById('report-reason').value;
        const message = document.getElementById('report-message').value;
        
        if (!reason) {
            alert('Veuillez sélectionner une raison');
            return;
        }
        
        if (!message || message.trim() === '') {
            alert('Veuillez saisir un message');
            return;
        }
        
        const submitBtn = document.getElementById('submit-report-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Envoi en cours...';
        
        fetch('{{ route("contests.report", $contest) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                reason: reason,
                message: message.trim()
            })
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message || 'Votre signalement a été enregistré. Merci !');
            closeReportModal();
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue. Veuillez réessayer.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Envoyer le signalement';
        });
    }
    
    // Fermer le modal en cliquant en dehors
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('reportModal');
        if (e.target === modal) {
            closeReportModal();
        }
    });
    
    function addToCalendar() {
        window.location.href = '{{ route("contests.calendar", $contest) }}';
    }
    
    function contactOrganizer(email) {
        if (!email) {
            alert('Email de l\'organisateur non disponible');
            return;
        }
        
        const modal = document.getElementById('contactModal');
        const emailInput = document.getElementById('organizer-email');
        const mailtoLink = document.getElementById('mailto-link');
        
        emailInput.value = email;
        mailtoLink.href = 'mailto:' + email;
        
        modal.classList.remove('hidden');
    }
    
    function closeContactModal() {
        const modal = document.getElementById('contactModal');
        modal.classList.add('hidden');
        document.getElementById('contact-message').value = '';
    }
    
    function copyEmail() {
        const emailInput = document.getElementById('organizer-email');
        emailInput.select();
        emailInput.setSelectionRange(0, 99999); // Pour mobile
        
        try {
            document.execCommand('copy');
            const copyBtn = event.target.closest('button');
            const originalIcon = copyBtn.innerHTML;
            copyBtn.innerHTML = '<i class="fas fa-check text-green-600"></i>';
            setTimeout(() => {
                copyBtn.innerHTML = originalIcon;
            }, 2000);
        } catch (err) {
            alert('Impossible de copier l\'email');
        }
    }
    
    // Fermer le modal en cliquant en dehors
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('contactModal');
        if (e.target === modal) {
            closeContactModal();
        }
    });
</script>
@if($hasLocation)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if($event->venue_latitude && $event->venue_longitude)
            // Si les coordonnées existent, les utiliser directement
            const lat = {{ $event->venue_latitude }};
            const lng = {{ $event->venue_longitude }};
            const map = L.map('contestMap').setView([lat, lng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            
            L.marker([lat, lng])
                .addTo(map)
                .bindPopup('{{ $event->venue_name ?? $event->venue_city ?? "Lieu du concours" }}')
                .openPopup();
        @elseif($event->venue_address)
            // Si seulement l'adresse existe, géocoder l'adresse
            const map = L.map('contestMap').setView([6.4969, 2.6283], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            
            let fullAddress = '{{ $event->venue_address }}';
            @if($event->venue_city)
                fullAddress += ', {{ $event->venue_city }}';
            @endif
            @if($event->venue_country)
                fullAddress += ', {{ $event->venue_country }}';
            @endif
            
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}&limit=1`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lng = parseFloat(data[0].lon);
                        
                        map.setView([lat, lng], 15);
                        
                        L.marker([lat, lng])
                            .addTo(map)
                            .bindPopup('{{ $event->venue_name ?? $event->venue_address ?? "Lieu du concours" }}')
                            .openPopup();
                    }
                })
                .catch(error => console.error('Erreur de géocodage:', error));
        @endif
    });
</script>
@endif
@endpush
@endsection
