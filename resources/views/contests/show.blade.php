@extends('layouts.app')

@section('title', $contest->name . ' - Tikehub')

@section('content')
<!-- Hero Section -->
<section class="relative">
    @if($contest->cover_image)
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $contest->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
    @else
        <div class="h-96 bg-gradient-to-r from-purple-600 to-pink-600">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-purple-600 px-4 py-1 rounded-full text-sm font-semibold">
                <i class="fas fa-trophy mr-1"></i>Concours
            </span>
            @if($contest->isActive())
                <span class="bg-green-600 px-4 py-1 rounded-full text-sm font-semibold">Actif</span>
            @else
                <span class="bg-gray-600 px-4 py-1 rounded-full text-sm font-semibold">Terminé</span>
            @endif
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $contest->name }}</h1>
        <div class="flex flex-wrap gap-6 text-lg">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>Du {{ $contest->start_date->format('d/m/Y') }} au {{ $contest->end_date->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-coins mr-2"></i>
                <span>{{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF par vote</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-users mr-2"></i>
                <span>{{ $contest->votes()->sum('points') }} vote(s) total</span>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Description</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($contest->description)) !!}
                </div>
            </div>

            <!-- Règles -->
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
                                    <div class="text-2xl font-bold text-purple-600">{{ number_format($candidate->total_points, 0, ',', ' ') }}</div>
                                    <div class="text-sm text-gray-500">point(s)</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Aucun candidat pour le moment</p>
                @endif
            </div>

            <!-- Liste des candidats avec boutons de vote -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-bold mb-4 pb-2 border-b-2 border-purple-600">Candidats</h2>
                @if($candidates && $candidates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($candidates as $candidate)
                            <div class="border-2 border-gray-200 rounded-lg p-6 hover:border-purple-500 transition">
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-48 object-cover rounded-lg mb-4">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 rounded-lg mb-4 flex items-center justify-center">
                                        <i class="fas fa-user text-6xl text-white opacity-50"></i>
                                    </div>
                                @endif
                                
                                <div class="mb-4">
                                    <h3 class="text-xl font-bold mb-2">{{ $candidate->name }}</h3>
                                    @if($candidate->description)
                                        <p class="text-gray-600 text-sm mb-3">{{ \Illuminate\Support\Str::limit($candidate->description, 120) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <div class="text-2xl font-bold text-purple-600">{{ number_format($candidate->votes_sum_points ?? 0, 0, ',', ' ') }}</div>
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
                                            <button type="submit" class="w-full bg-purple-600 text-white px-4 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
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
                                    <button disabled class="w-full bg-gray-400 text-white px-4 py-3 rounded-lg cursor-not-allowed font-semibold">
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
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-2xl font-bold mb-4">Informations</h2>
                <div class="space-y-4">
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
                            <i class="fas fa-calendar mr-2"></i>
                            Du {{ $contest->start_date->format('d/m/Y') }}<br>
                            au {{ $contest->end_date->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-700 mb-2">Organisateur</h3>
                        <p class="text-gray-600">
                            <i class="fas fa-user mr-2"></i>
                            {{ $contest->organizer->name }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Statistiques</h3>
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
</script>
@endpush
@endsection
