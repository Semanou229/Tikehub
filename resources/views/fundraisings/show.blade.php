@extends('layouts.app')

@section('title', $fundraising->name . ' - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header avec date en vert -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="flex flex-col md:flex-row">
            <!-- Date Box (Vert) -->
            <div class="bg-green-600 text-white p-6 text-center min-w-[120px] flex flex-col justify-center items-center">
                <div class="text-2xl font-bold uppercase">{{ $fundraising->start_date->translatedFormat('M') }}</div>
                <div class="text-5xl font-bold">{{ $fundraising->start_date->format('d') }}</div>
                <div class="text-lg mt-2">{{ $fundraising->start_date->translatedFormat('l') }}</div>
            </div>

            <!-- Contenu principal du header -->
            <div class="flex-1 p-6">
                <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="bg-green-600 px-3 py-1 rounded-full text-xs font-semibold text-white">
                                <i class="fas fa-heart mr-1"></i>Collecte de fonds
                            </span>
                            @if($fundraising->isActive())
                                <span class="bg-green-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Active</span>
                            @else
                                <span class="bg-gray-600 px-3 py-1 rounded-full text-xs font-semibold text-white">Terminée</span>
                            @endif
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $fundraising->name }}</h1>
                        
                        <!-- Barre de progression -->
                        <div class="mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                <span class="text-gray-600">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3">
                                <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                            </div>
                            <p class="text-center mt-2 text-sm font-semibold text-green-600">{{ number_format($fundraising->progress_percentage, 1) }}% de l'objectif atteint</p>
                        </div>

                        <!-- Informations date et donateurs -->
                        <div class="space-y-2 text-gray-700">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-green-600 mr-3 w-5"></i>
                                <span>
                                    Du {{ $fundraising->start_date->translatedFormat('D, d M Y') }} 
                                    au {{ $fundraising->end_date->translatedFormat('D, d M Y') }}
                                </span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-users text-green-600 mr-3 w-5"></i>
                                <span>{{ $fundraising->donations()->count() }} donateur(s)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="flex flex-col gap-2 md:min-w-[150px]">
                        <button onclick="shareFundraising()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-share-alt"></i>
                            <span>PARTAGER</span>
                        </button>
                        <button onclick="reportFundraising()" class="flex items-center justify-center gap-2 px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition text-sm">
                            <i class="fas fa-flag"></i>
                            <span>SIGNALER</span>
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
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-green-600">Description</h2>
                <div class="prose max-w-none mb-6">
                    {!! nl2br(e($fundraising->description)) !!}
                </div>

                <!-- Points à puces avec checkmarks verts -->
                <div class="space-y-3 mt-6">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Votre contribution fait la différence</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Transparence totale sur l'utilisation des fonds</span>
                    </div>
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-600 mr-3 mt-1"></i>
                        <span>Collecte organisée par {{ $fundraising->organizer->name }}</span>
                    </div>
                </div>

                <!-- Call to action avec icône -->
                @if($fundraising->isActive())
                    <div class="mt-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                        <div class="flex items-start">
                            <i class="fas fa-heart text-green-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">
                                La collecte est actuellement active ! Chaque contribution compte et nous rapproche de notre objectif. Merci pour votre générosité.
                            </p>
                        </div>
                    </div>
                @endif

                <div class="mt-4 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-600 mr-3 mt-1"></i>
                        <p class="text-gray-700">
                            Ne manquez pas cette opportunité de faire une différence : contribuez maintenant et aidez-nous à atteindre notre objectif !
                        </p>
                    </div>
                </div>
            </div>

            <!-- Paliers d'objectifs -->
            @if($fundraising->milestones && count($fundraising->milestones) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-green-600">Paliers d'objectifs</h2>
                    <div class="space-y-4">
                        @foreach($fundraising->milestones as $index => $milestone)
                            @php
                                $milestoneAmount = $milestone['amount'] ?? 0;
                                $milestoneProgress = $fundraising->goal_amount > 0 ? min(100, ($fundraising->current_amount / $milestoneAmount) * 100) : 0;
                                $isReached = $fundraising->current_amount >= $milestoneAmount;
                            @endphp
                            <div class="border-l-4 {{ $isReached ? 'border-green-500 bg-green-50' : 'border-gray-300' }} pl-4 py-3 rounded">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="font-semibold text-lg">{{ $milestone['name'] ?? 'Palier ' . ($index + 1) }}</h3>
                                    @if($isReached)
                                        <span class="bg-green-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                            <i class="fas fa-check-circle mr-1"></i>Atteint
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-sm">
                                            {{ number_format(max(0, $milestoneAmount - $fundraising->current_amount), 0, ',', ' ') }} XOF restants
                                        </span>
                                    @endif
                                </div>
                                @if(isset($milestone['description']))
                                    <p class="text-gray-600 mb-2">{{ $milestone['description'] }}</p>
                                @endif
                                <p class="text-green-600 font-semibold">
                                    Objectif: {{ number_format($milestoneAmount, 0, ',', ' ') }} XOF
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Lieu sur carte -->
            @php
                $event = $fundraising->event;
                $hasLocation = $event && ($event->venue_latitude && $event->venue_longitude || $event->venue_address);
            @endphp
            @if($hasLocation)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-green-600">Lieu sur carte</h2>
                    <div id="fundraisingMap" class="w-full h-96 rounded-lg border border-gray-300 mb-4"></div>
                    @if($event->venue_name || $event->venue_address)
                        <div class="space-y-2 text-gray-700">
                            @if($event->venue_name)
                                <p class="font-semibold"><i class="fas fa-map-marker-alt text-green-600 mr-2"></i>{{ $event->venue_name }}</p>
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

            <!-- Derniers donateurs -->
            @if($fundraising->show_donors && $fundraising->donations->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-green-600">Derniers donateurs</h2>
                    <div class="space-y-3">
                        @foreach($fundraising->donations()->latest()->take(10)->get() as $donation)
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="font-semibold">
                                        @if($donation->is_anonymous)
                                            Donateur anonyme
                                        @else
                                            {{ $donation->user->name ?? $donation->donor_name ?? 'Donateur' }}
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-500">{{ $donation->created_at->diffForHumans() }}</p>
                                    @if($donation->message)
                                        <p class="text-sm text-gray-600 italic mt-1">"{{ $donation->message }}"</p>
                                    @endif
                                </div>
                                <div class="text-lg font-bold text-green-600">
                                    {{ number_format($donation->amount, 0, ',', ' ') }} XOF
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Calendrier de la collecte -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-green-600">Calendrier de la collecte</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-semibold">
                                Du {{ $fundraising->start_date->translatedFormat('l, d F Y') }} 
                                au {{ $fundraising->end_date->translatedFormat('l, d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600 mt-1">
                                Période de collecte active
                            </p>
                        </div>
                        @if($fundraising->end_date->isPast())
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                Terminée
                            </span>
                        @elseif($fundraising->start_date->isFuture())
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
            <!-- Contribution -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4">Contribuer</h2>
                
                <div class="mb-6">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Collecté</span>
                        <span class="font-bold text-lg">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Objectif</span>
                        <span class="font-bold text-lg">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3 mt-4">
                        <div class="bg-green-600 h-3 rounded-full transition-all duration-500" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                    </div>
                    <p class="text-center mt-2 text-sm text-gray-600">{{ number_format($fundraising->progress_percentage, 1) }}% atteint</p>
                </div>

                @if($fundraising->isActive())
                    @auth
                        <form action="{{ route('fundraisings.donate', $fundraising) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">Montant (XOF)</label>
                                <input type="number" name="amount" id="amount" min="100" step="100" value="1000" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <div class="flex gap-2 mt-2">
                                    <button type="button" onclick="setAmount(500)" class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">500</button>
                                    <button type="button" onclick="setAmount(1000)" class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">1000</button>
                                    <button type="button" onclick="setAmount(5000)" class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">5000</button>
                                    <button type="button" onclick="setAmount(10000)" class="flex-1 px-3 py-1 text-sm border border-gray-300 rounded hover:bg-gray-50">10000</button>
                                </div>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Message (optionnel)</label>
                                <textarea name="message" id="message" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Laissez un message de soutien..."></textarea>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_anonymous" id="is_anonymous" class="mr-2">
                                <label for="is_anonymous" class="text-sm text-gray-600">Don anonyme</label>
                            </div>
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                                <i class="fas fa-heart mr-2"></i>Contribuer maintenant
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                            Se connecter pour contribuer
                        </a>
                    @endif
                @else
                    <p class="text-center text-gray-500 py-4">Cette collecte est terminée</p>
                @endif
            </div>

            <!-- Organisateur -->
            <div class="bg-gray-100 rounded-lg p-6">
                <div class="bg-white rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl mr-3">
                            {{ strtoupper(substr($fundraising->organizer->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $fundraising->organizer->name }}</h3>
                            <p class="text-sm text-gray-500">ORGANISATEUR</p>
                        </div>
                    </div>
                    
                    <!-- Réseaux sociaux -->
                    @php
                        $socialNetworks = [
                            'facebook' => ['url' => $fundraising->organizer->facebook_url, 'icon' => 'fab fa-facebook-f', 'color' => 'text-blue-600'],
                            'twitter' => ['url' => $fundraising->organizer->twitter_url, 'icon' => 'fab fa-twitter', 'color' => 'text-blue-400'],
                            'instagram' => ['url' => $fundraising->organizer->instagram_url, 'icon' => 'fab fa-instagram', 'color' => 'text-pink-600'],
                            'linkedin' => ['url' => $fundraising->organizer->linkedin_url, 'icon' => 'fab fa-linkedin-in', 'color' => 'text-blue-700'],
                            'youtube' => ['url' => $fundraising->organizer->youtube_url, 'icon' => 'fab fa-youtube', 'color' => 'text-red-600'],
                            'website' => ['url' => $fundraising->organizer->website_url, 'icon' => 'fas fa-globe', 'color' => 'text-gray-600'],
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
                    
                    @if($fundraising->organizer->phone)
                        <div class="mb-4">
                            <div class="flex items-center text-sm text-gray-700">
                                <i class="fas fa-phone text-green-600 mr-2 w-5"></i>
                                <span>{{ $fundraising->organizer->phone }}</span>
                            </div>
                        </div>
                    @endif
                    
                    <button onclick="contactOrganizer('{{ $fundraising->organizer->email }}')" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center justify-center gap-2">
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
                                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                              placeholder="Écrivez votre message ici..."></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <a id="mailto-link" href="#" 
                                       class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-center">
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

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Montant collecté</span>
                        <span class="font-semibold">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Objectif</span>
                        <span class="font-semibold">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Reste à collecter</span>
                        <span class="font-semibold text-green-600">
                            {{ number_format(max(0, $fundraising->goal_amount - $fundraising->current_amount), 0, ',', ' ') }} XOF
                        </span>
                    </div>
                    @if($fundraising->donations()->count() > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Don moyen</span>
                            <span class="font-semibold">
                                {{ number_format($fundraising->current_amount / $fundraising->donations()->count(), 0, ',', ' ') }} XOF
                            </span>
                        </div>
                    @endif
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
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
    }
    
    function shareFundraising() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $fundraising->name }}',
                text: '{{ Str::limit($fundraising->description, 100) }}',
                url: window.location.href
            });
        } else {
            navigator.clipboard.writeText(window.location.href);
            alert('Lien copié dans le presse-papiers !');
        }
    }
    
    function reportFundraising() {
        if (confirm('Voulez-vous signaler cette collecte ?')) {
            alert('Fonctionnalité de signalement à venir');
        }
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
            const map = L.map('fundraisingMap').setView([lat, lng], 15);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors',
                maxZoom: 19
            }).addTo(map);
            
            L.marker([lat, lng])
                .addTo(map)
                .bindPopup('{{ $event->venue_name ?? $event->venue_city ?? "Lieu de la collecte" }}')
                .openPopup();
        @elseif($event->venue_address)
            // Si seulement l'adresse existe, géocoder l'adresse
            const map = L.map('fundraisingMap').setView([6.4969, 2.6283], 13);
            
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
                            .bindPopup('{{ $event->venue_name ?? $event->venue_address ?? "Lieu de la collecte" }}')
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
