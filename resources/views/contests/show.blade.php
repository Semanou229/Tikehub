@extends('layouts.app')

@section('title', $contest->name . ' - Tikehub')

@section('content')
<!-- Hero Section avec effet parallaxe -->
<section class="relative overflow-hidden">
    @if($contest->cover_image)
        <div class="h-[500px] bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('storage/' . $contest->cover_image) }}')">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-purple-900/70 to-black/80"></div>
        </div>
    @else
        <div class="h-[500px] bg-gradient-to-br from-purple-600 via-pink-600 to-purple-800 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-20 w-72 h-72 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                <div class="absolute top-40 right-20 w-72 h-72 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
            </div>
        </div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-white">
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <span class="bg-purple-600/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg flex items-center gap-2">
                <i class="fas fa-trophy"></i>Concours
            </span>
            @if($contest->isActive())
                <span class="bg-green-500/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                    <i class="fas fa-circle mr-2"></i>Actif maintenant
                </span>
            @else
                <span class="bg-gray-600/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg">
                    Terminé
                </span>
            @endif
        </div>
        
        <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight drop-shadow-2xl">
            {{ $contest->name }}
        </h1>
        
        <div class="flex flex-wrap gap-8 text-xl mb-8">
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl">
                <i class="fas fa-calendar-alt text-2xl"></i>
                <div>
                    <div class="text-sm opacity-80">Période</div>
                    <div class="font-bold">{{ $contest->start_date->format('d M') }} - {{ $contest->end_date->format('d M Y') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl">
                <i class="fas fa-coins text-2xl"></i>
                <div>
                    <div class="text-sm opacity-80">Prix par vote</div>
                    <div class="font-bold">{{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl">
                <i class="fas fa-users text-2xl"></i>
                <div>
                    <div class="text-sm opacity-80">Total votes</div>
                    <div class="font-bold">{{ number_format($contest->votes()->sum('points'), 0, ',', ' ') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contenu principal -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Description -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold mb-6 flex items-center gap-3">
                    <span class="w-1 h-10 bg-gradient-to-b from-purple-600 to-pink-600 rounded-full"></span>
                    Description
                </h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($contest->description)) !!}
                </div>
            </div>

            <!-- Règles -->
            @if($contest->rules)
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-2xl shadow-xl p-8 border border-purple-100">
                    <h2 class="text-3xl font-bold mb-6 flex items-center gap-3 text-purple-900">
                        <i class="fas fa-gavel text-purple-600"></i>
                        Règles du concours
                    </h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($contest->rules)) !!}
                    </div>
                </div>
            @endif

            <!-- Classement avec podium -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold mb-8 flex items-center gap-3">
                    <i class="fas fa-trophy text-yellow-500"></i>
                    Classement
                </h2>
                @if($ranking && $ranking->count() > 0)
                    <!-- Podium pour top 3 -->
                    @if($ranking->count() >= 3)
                        <div class="flex items-end justify-center gap-4 mb-8 pb-8 border-b-2 border-gray-200">
                            <!-- 2ème place -->
                            <div class="text-center transform hover:scale-105 transition duration-300">
                                <div class="w-24 h-24 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full flex items-center justify-center text-3xl font-black text-gray-800 mb-3 shadow-lg">
                                    2
                                </div>
                                <div class="bg-gray-100 rounded-lg p-4 min-w-[150px]">
                                    <h3 class="font-bold text-lg mb-1">{{ $ranking[1]->name }}</h3>
                                    <div class="text-2xl font-black text-gray-600">{{ number_format($ranking[1]->total_points ?? 0, 0, ',', ' ') }}</div>
                                    <div class="text-xs text-gray-500">points</div>
                                </div>
                            </div>
                            
                            <!-- 1ère place -->
                            <div class="text-center transform hover:scale-110 transition duration-300">
                                <div class="w-32 h-32 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center text-4xl font-black text-yellow-900 mb-3 shadow-2xl relative">
                                    <i class="fas fa-crown absolute -top-2 text-yellow-500"></i>
                                    <span class="mt-4">1</span>
                                </div>
                                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg p-5 min-w-[180px] border-2 border-yellow-400">
                                    <h3 class="font-bold text-xl mb-1">{{ $ranking[0]->name }}</h3>
                                    <div class="text-3xl font-black text-yellow-700">{{ number_format($ranking[0]->total_points ?? 0, 0, ',', ' ') }}</div>
                                    <div class="text-sm text-yellow-600 font-semibold">points</div>
                                </div>
                            </div>
                            
                            <!-- 3ème place -->
                            <div class="text-center transform hover:scale-105 transition duration-300">
                                <div class="w-24 h-24 bg-gradient-to-br from-orange-300 to-orange-500 rounded-full flex items-center justify-center text-3xl font-black text-orange-900 mb-3 shadow-lg">
                                    3
                                </div>
                                <div class="bg-orange-50 rounded-lg p-4 min-w-[150px] border border-orange-200">
                                    <h3 class="font-bold text-lg mb-1">{{ $ranking[2]->name }}</h3>
                                    <div class="text-2xl font-black text-orange-600">{{ number_format($ranking[2]->total_points ?? 0, 0, ',', ' ') }}</div>
                                    <div class="text-xs text-orange-500">points</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Liste complète du classement -->
                    <div class="space-y-3">
                        @foreach($ranking as $candidate)
                            @php
                                $totalPoints = (int)($candidate->total_points ?? 0);
                                $maxPoints = $ranking->max('total_points') ?? 1;
                                $percentage = $maxPoints > 0 ? ($totalPoints / $maxPoints) * 100 : 0;
                            @endphp
                            <div class="flex items-center p-5 rounded-xl border-2 transition-all duration-300 hover:shadow-lg {{ $candidate->position <= 3 ? 'bg-gradient-to-r from-yellow-50 to-orange-50 border-yellow-300' : 'bg-white border-gray-200 hover:border-purple-300' }}">
                                <div class="flex-shrink-0 w-14 h-14 flex items-center justify-center rounded-full font-black text-xl mr-4
                                    {{ $candidate->position === 1 ? 'bg-gradient-to-br from-yellow-400 to-yellow-600 text-yellow-900 shadow-lg' : ($candidate->position === 2 ? 'bg-gradient-to-br from-gray-300 to-gray-500 text-gray-800 shadow-md' : ($candidate->position === 3 ? 'bg-gradient-to-br from-orange-300 to-orange-500 text-orange-900 shadow-md' : 'bg-gradient-to-br from-purple-100 to-purple-200 text-purple-700')) }}">
                                    {{ $candidate->position }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-bold text-lg text-gray-900">{{ $candidate->name }}</h3>
                                        <div class="text-right">
                                            <div class="text-2xl font-black text-purple-600">{{ number_format($totalPoints, 0, ',', ' ') }}</div>
                                            <div class="text-xs text-gray-500 font-semibold">points</div>
                                        </div>
                                    </div>
                                    @if($candidate->description)
                                        <p class="text-gray-600 text-sm mb-2">{{ \Illuminate\Support\Str::limit($candidate->description, 100) }}</p>
                                    @endif
                                    <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                        <div class="h-2 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Aucun candidat pour le moment</p>
                    </div>
                @endif
            </div>

            <!-- Liste des candidats avec cartes modernes -->
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                <h2 class="text-3xl font-bold mb-8 flex items-center gap-3">
                    <i class="fas fa-user-friends text-purple-600"></i>
                    Votez pour votre candidat favori
                </h2>
                @if($candidates && $candidates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($candidates as $candidate)
                            @php
                                $totalPoints = (int)($candidate->votes_sum_points ?? 0);
                            @endphp
                            <div class="group relative bg-gradient-to-br from-white to-purple-50 rounded-2xl p-6 border-2 border-gray-200 hover:border-purple-400 transition-all duration-300 hover:shadow-2xl transform hover:-translate-y-2">
                                <!-- Badge position -->
                                <div class="absolute -top-3 -right-3 w-12 h-12 bg-gradient-to-br from-purple-600 to-pink-600 rounded-full flex items-center justify-center text-white font-black shadow-lg z-10">
                                    #{{ $candidate->position ?? $loop->iteration }}
                                </div>

                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-full h-56 object-cover rounded-xl mb-4 shadow-md group-hover:shadow-xl transition duration-300">
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-purple-400 via-pink-400 to-purple-600 rounded-xl mb-4 flex items-center justify-center shadow-md group-hover:shadow-xl transition duration-300 relative overflow-hidden">
                                        <div class="absolute inset-0 bg-black/10"></div>
                                        <i class="fas fa-user text-8xl text-white/50"></i>
                                    </div>
                                @endif
                                
                                <div class="mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-2xl font-black text-gray-900">{{ $candidate->name }}</h3>
                                        @if($candidate->number)
                                            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-bold">
                                                #{{ $candidate->number }}
                                            </span>
                                        @endif
                                    </div>
                                    @if($candidate->description)
                                        <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ \Illuminate\Support\Str::limit($candidate->description, 120) }}</p>
                                    @endif
                                    
                                    <!-- Points avec animation -->
                                    <div class="bg-gradient-to-r from-purple-100 to-pink-100 rounded-xl p-4 mb-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="text-xs text-gray-600 font-semibold mb-1">POINTS ACTUELS</div>
                                                <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                                                    {{ number_format($totalPoints, 0, ',', ' ') }}
                                                </div>
                                            </div>
                                            <div class="text-4xl text-purple-300">
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if($contest->isActive())
                                    @auth
                                        <form action="{{ route('contests.vote', ['contest' => $contest, 'candidate' => $candidate]) }}" method="POST" class="space-y-4">
                                            @csrf
                                            <div class="bg-gray-50 rounded-xl p-4">
                                                <label for="quantity_{{ $candidate->id }}" class="block text-sm font-bold text-gray-700 mb-2">
                                                    <i class="fas fa-vote-yea mr-2 text-purple-600"></i>Nombre de votes
                                                </label>
                                                <div class="flex items-center gap-3">
                                                    <input type="number" name="quantity" id="quantity_{{ $candidate->id }}" min="1" max="100" value="1" class="flex-1 px-4 py-3 border-2 border-purple-200 rounded-xl text-center font-bold text-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                                                    <div class="text-sm text-gray-600">
                                                        <div class="font-semibold">= <span id="amount_{{ $candidate->id }}" class="text-purple-600 font-black">{{ number_format($contest->price_per_vote, 0, ',', ' ') }}</span> XOF</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-4 rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-2xl transform hover:scale-105">
                                                <i class="fas fa-vote-yea mr-2"></i>Voter maintenant
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="block w-full bg-gradient-to-r from-purple-600 to-pink-600 text-white text-center px-6 py-4 rounded-xl hover:from-purple-700 hover:to-pink-700 transition-all duration-300 font-bold text-lg shadow-lg hover:shadow-2xl transform hover:scale-105">
                                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter pour voter
                                        </a>
                                    @endauth
                                @else
                                    <button disabled class="w-full bg-gray-300 text-gray-600 px-6 py-4 rounded-xl cursor-not-allowed font-bold text-lg">
                                        <i class="fas fa-lock mr-2"></i>Concours terminé
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-16">
                        <i class="fas fa-user-friends text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-500 text-lg">Aucun candidat pour le moment</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl shadow-2xl p-6 text-white sticky top-4">
                <h2 class="text-2xl font-black mb-6 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    Informations
                </h2>
                <div class="space-y-5">
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-sm opacity-80 mb-1">Prix par vote</div>
                        <div class="text-3xl font-black">{{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-sm opacity-80 mb-1">Points par vote</div>
                        <div class="text-2xl font-bold">{{ $contest->points_per_vote }} point(s)</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-sm opacity-80 mb-1">Période</div>
                        <div class="font-semibold">
                            Du {{ $contest->start_date->format('d/m/Y') }}<br>
                            au {{ $contest->end_date->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-xl p-4">
                        <div class="text-sm opacity-80 mb-1">Organisateur</div>
                        <div class="font-semibold">{{ $contest->organizer->name }}</div>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-bar text-purple-600"></i>
                    Statistiques
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Total votes</span>
                        <span class="text-2xl font-black text-purple-600">{{ number_format($contest->votes()->sum('points'), 0, ',', ' ') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-pink-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Candidats</span>
                        <span class="text-2xl font-black text-pink-600">{{ $candidates->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Revenus</span>
                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-pink-600">
                            {{ number_format($contest->votes()->count() * $contest->price_per_vote, 0, ',', ' ') }} XOF
                        </span>
                    </div>
                </div>
            </div>

            <!-- Partage -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <h3 class="text-xl font-bold mb-4">Partager</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="flex-1 bg-blue-600 text-white px-4 py-3 rounded-xl text-center hover:bg-blue-700 transition font-semibold shadow-lg hover:shadow-xl">
                        <i class="fab fa-facebook-f mr-2"></i>Facebook
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}" target="_blank" class="flex-1 bg-blue-400 text-white px-4 py-3 rounded-xl text-center hover:bg-blue-500 transition font-semibold shadow-lg hover:shadow-xl">
                        <i class="fab fa-twitter mr-2"></i>Twitter
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @keyframes blob {
        0%, 100% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endpush

@push('scripts')
<script>
    // Calculer le montant total en fonction du nombre de votes
    document.querySelectorAll('input[type="number"][name="quantity"]').forEach(input => {
        const candidateId = input.id.replace('quantity_', '');
        const pricePerVote = {{ $contest->price_per_vote }};
        
        input.addEventListener('input', function() {
            const quantity = parseInt(this.value) || 1;
            const total = pricePerVote * quantity;
            
            document.getElementById('amount_' + candidateId).textContent = total.toLocaleString('fr-FR');
        });
    });
</script>
@endpush
@endsection
