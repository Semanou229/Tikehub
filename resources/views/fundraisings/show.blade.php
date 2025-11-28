@extends('layouts.app')

@section('title', $fundraising->name . ' - Tikehub')

@section('content')
<!-- Hero Section avec effet parallaxe -->
<section class="relative overflow-hidden">
    @if($fundraising->cover_image)
        <div class="h-[500px] bg-cover bg-center bg-fixed" style="background-image: url('{{ asset('storage/' . $fundraising->cover_image) }}')">
            <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-green-900/70 to-black/80"></div>
        </div>
    @else
        <div class="h-[500px] bg-gradient-to-br from-green-500 via-teal-600 to-green-700 relative overflow-hidden">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="absolute top-0 left-0 w-full h-full">
                <div class="absolute top-20 left-20 w-72 h-72 bg-green-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
                <div class="absolute top-40 right-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-1/2 w-72 h-72 bg-emerald-300 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
            </div>
        </div>
    @endif
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-white">
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <span class="bg-green-600/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg flex items-center gap-2">
                <i class="fas fa-heart"></i>Collecte de fonds
            </span>
            @if($fundraising->isActive())
                <span class="bg-green-500/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                    <i class="fas fa-circle mr-2"></i>Active maintenant
                </span>
            @else
                <span class="bg-gray-600/90 backdrop-blur-sm px-5 py-2 rounded-full text-sm font-bold shadow-lg">
                    Terminée
                </span>
            @endif
        </div>
        
        <h1 class="text-5xl md:text-7xl font-black mb-8 leading-tight drop-shadow-2xl">
            {{ $fundraising->name }}
        </h1>
        
        <!-- Barre de progression moderne -->
        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border border-white/20 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <div class="text-sm opacity-80 mb-1">Collecté</div>
                    <div class="text-4xl font-black">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</div>
                </div>
                <div class="text-right">
                    <div class="text-sm opacity-80 mb-1">Objectif</div>
                    <div class="text-4xl font-black">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</div>
                </div>
            </div>
            <div class="relative w-full bg-white/20 rounded-full h-8 mb-4 overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 rounded-full transition-all duration-1000 ease-out shadow-lg" style="width: {{ min(100, $fundraising->progress_percentage) }}%">
                    <div class="absolute inset-0 bg-white/30 animate-shimmer"></div>
                </div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-white font-black text-sm drop-shadow-lg">{{ number_format($fundraising->progress_percentage, 1) }}%</span>
                </div>
            </div>
            @if($fundraising->goal_amount > $fundraising->current_amount)
                <p class="text-center text-lg font-semibold">
                    Il reste <span class="text-yellow-300 font-black">{{ number_format($fundraising->goal_amount - $fundraising->current_amount, 0, ',', ' ') }} XOF</span> à collecter
                </p>
            @else
                <p class="text-center text-lg font-semibold text-yellow-300">
                    <i class="fas fa-check-circle mr-2"></i>Objectif atteint !
                </p>
            @endif
        </div>

        <div class="flex flex-wrap gap-6 mt-8 text-xl">
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl">
                <i class="fas fa-calendar-alt text-2xl"></i>
                <div>
                    <div class="text-sm opacity-80">Période</div>
                    <div class="font-bold">{{ $fundraising->start_date->format('d M') }} - {{ $fundraising->end_date->format('d M Y') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white/10 backdrop-blur-md px-6 py-3 rounded-xl">
                <i class="fas fa-users text-2xl"></i>
                <div>
                    <div class="text-sm opacity-80">Donateurs</div>
                    <div class="font-bold">{{ $fundraising->donations()->count() }} personne(s)</div>
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
                    <span class="w-1 h-10 bg-gradient-to-b from-green-600 to-teal-600 rounded-full"></span>
                    À propos de cette collecte
                </h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {!! nl2br(e($fundraising->description)) !!}
                </div>
            </div>

            <!-- Paliers d'objectifs avec design moderne -->
            @if($fundraising->milestones && count($fundraising->milestones) > 0)
                <div class="bg-gradient-to-br from-green-50 to-teal-50 rounded-2xl shadow-xl p-8 border border-green-100">
                    <h2 class="text-3xl font-bold mb-8 flex items-center gap-3 text-green-900">
                        <i class="fas fa-flag-checkered text-green-600"></i>
                        Paliers d'objectifs
                    </h2>
                    <div class="space-y-6">
                        @foreach($fundraising->milestones as $index => $milestone)
                            @php
                                $milestoneAmount = $milestone['amount'] ?? 0;
                                $milestoneProgress = $fundraising->goal_amount > 0 ? min(100, ($fundraising->current_amount / $milestoneAmount) * 100) : 0;
                                $isReached = $fundraising->current_amount >= $milestoneAmount;
                            @endphp
                            <div class="bg-white rounded-xl p-6 border-2 {{ $isReached ? 'border-green-500 shadow-lg' : 'border-gray-200' }} transition-all duration-300 hover:shadow-xl">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-4">
                                        <div class="w-16 h-16 rounded-full flex items-center justify-center font-black text-xl {{ $isReached ? 'bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg' : 'bg-gray-200 text-gray-600' }}">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <h3 class="font-black text-xl text-gray-900">{{ $milestone['name'] ?? 'Palier ' . ($index + 1) }}</h3>
                                            @if(isset($milestone['description']))
                                                <p class="text-gray-600 text-sm mt-1">{{ $milestone['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    @if($isReached)
                                        <span class="bg-gradient-to-r from-green-500 to-emerald-600 text-white px-5 py-2 rounded-full text-sm font-bold shadow-lg flex items-center gap-2">
                                            <i class="fas fa-check-circle"></i>Atteint
                                        </span>
                                    @else
                                        <span class="text-gray-500 text-sm font-semibold">
                                            {{ number_format(max(0, $milestoneAmount - $fundraising->current_amount), 0, ',', ' ') }} XOF restants
                                        </span>
                                    @endif
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between text-sm text-gray-600 font-semibold">
                                        <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                        <span>{{ number_format($milestoneAmount, 0, ',', ' ') }} XOF</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                        <div class="h-3 rounded-full bg-gradient-to-r from-green-500 to-teal-500 transition-all duration-1000 shadow-md" style="width: {{ min(100, $milestoneProgress) }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Derniers donateurs avec design moderne -->
            @if($fundraising->show_donors && $fundraising->donations->count() > 0)
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h2 class="text-3xl font-bold mb-8 flex items-center gap-3">
                        <i class="fas fa-heart text-red-500"></i>
                        Derniers contributeurs
                    </h2>
                    <div class="space-y-4">
                        @foreach($fundraising->donations()->latest()->take(20)->get() as $donation)
                            <div class="flex justify-between items-center p-5 bg-gradient-to-r from-green-50 to-teal-50 rounded-xl hover:shadow-lg transition-all duration-300 border border-green-100">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-teal-600 rounded-full flex items-center justify-center text-white font-black text-lg shadow-lg">
                                        @if($donation->is_anonymous)
                                            <i class="fas fa-user-secret"></i>
                                        @else
                                            {{ strtoupper(substr($donation->user->name ?? $donation->donor_name ?? 'D', 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">
                                            @if($donation->is_anonymous)
                                                <i class="fas fa-user-secret text-gray-500 mr-2"></i>Donateur anonyme
                                            @else
                                                {{ $donation->user->name ?? $donation->donor_name ?? 'Donateur' }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <i class="far fa-clock mr-1"></i>{{ $donation->created_at->diffForHumans() }}
                                        </p>
                                        @if($donation->message)
                                            <p class="text-sm text-gray-600 italic mt-1">"{{ \Illuminate\Support\Str::limit($donation->message, 50) }}"</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-teal-600">
                                        {{ number_format($donation->amount, 0, ',', ' ') }}
                                    </div>
                                    <div class="text-sm text-gray-500 font-semibold">XOF</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($fundraising->donations()->count() > 20)
                        <button class="mt-6 w-full text-green-600 hover:text-green-700 font-bold py-3 rounded-xl hover:bg-green-50 transition">
                            Voir tous les contributeurs ({{ $fundraising->donations()->count() }})
                        </button>
                    @endif
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Formulaire de contribution moderne -->
            <div class="bg-gradient-to-br from-green-600 to-teal-600 rounded-2xl shadow-2xl p-6 text-white sticky top-4">
                <h2 class="text-2xl font-black mb-6 flex items-center gap-2">
                    <i class="fas fa-hand-holding-heart"></i>
                    Contribuer
                </h2>
                
                <!-- Barre de progression compacte -->
                <div class="mb-6 p-4 bg-white/10 backdrop-blur-sm rounded-xl">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="opacity-80">Collecté</span>
                        <span class="font-bold">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between text-sm mb-3">
                        <span class="opacity-80">Objectif</span>
                        <span class="font-bold">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="w-full bg-white/20 rounded-full h-2 mb-2">
                        <div class="bg-white h-2 rounded-full transition-all duration-500" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                    </div>
                    <p class="text-center text-xs opacity-80">{{ number_format($fundraising->progress_percentage, 1) }}% atteint</p>
                </div>

                @if($fundraising->isActive())
                    @auth
                        <form action="{{ route('fundraisings.donate', $fundraising) }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label for="amount" class="block text-sm font-bold mb-2">Montant (XOF)</label>
                                <div class="relative">
                                    <input type="number" name="amount" id="amount" min="100" step="100" value="1000" required class="w-full px-4 py-4 border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-xl focus:ring-2 focus:ring-white focus:border-white text-white placeholder-white/50 font-bold text-lg">
                                    <span class="absolute right-4 top-4 text-white/80 font-semibold">XOF</span>
                                </div>
                                <div class="grid grid-cols-4 gap-2 mt-3">
                                    <button type="button" onclick="setAmount(500)" class="px-3 py-2 text-sm border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-lg hover:bg-white/20 transition font-semibold">500</button>
                                    <button type="button" onclick="setAmount(1000)" class="px-3 py-2 text-sm border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-lg hover:bg-white/20 transition font-semibold">1000</button>
                                    <button type="button" onclick="setAmount(5000)" class="px-3 py-2 text-sm border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-lg hover:bg-white/20 transition font-semibold">5000</button>
                                    <button type="button" onclick="setAmount(10000)" class="px-3 py-2 text-sm border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-lg hover:bg-white/20 transition font-semibold">10K</button>
                                </div>
                            </div>
                            <div>
                                <label for="message" class="block text-sm font-bold mb-2">Message (optionnel)</label>
                                <textarea name="message" id="message" rows="3" class="w-full px-4 py-3 border-2 border-white/30 bg-white/10 backdrop-blur-sm rounded-xl focus:ring-2 focus:ring-white focus:border-white text-white placeholder-white/50 resize-none" placeholder="Laissez un message de soutien..."></textarea>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_anonymous" id="is_anonymous" class="mr-3 w-5 h-5 rounded border-white/30 bg-white/10 text-green-600 focus:ring-2 focus:ring-white">
                                <label for="is_anonymous" class="text-sm">Contribuer de manière anonyme</label>
                            </div>
                            <button type="submit" class="w-full bg-white text-green-600 px-6 py-4 rounded-xl hover:bg-gray-100 transition-all duration-300 font-black text-lg shadow-2xl hover:shadow-3xl transform hover:scale-105">
                                <i class="fas fa-heart mr-2"></i>Contribuer maintenant
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block w-full bg-white text-green-600 text-center px-6 py-4 rounded-xl hover:bg-gray-100 transition-all duration-300 font-black text-lg shadow-2xl hover:shadow-3xl transform hover:scale-105">
                            <i class="fas fa-sign-in-alt mr-2"></i>Se connecter pour contribuer
                        </a>
                    @endif
                @else
                    <div class="text-center py-8">
                        <i class="fas fa-lock text-5xl text-white/50 mb-4"></i>
                        <p class="font-bold text-lg">Cette collecte est terminée</p>
                        <p class="text-sm opacity-80 mt-2">Merci à tous les contributeurs !</p>
                    </div>
                @endif
            </div>

            <!-- Informations -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-info-circle text-green-600"></i>
                    Informations
                </h3>
                <div class="space-y-4">
                    <div class="p-3 bg-green-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Organisateur</p>
                        <p class="font-bold text-gray-900">{{ $fundraising->organizer->name }}</p>
                    </div>
                    <div class="p-3 bg-teal-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Période</p>
                        <p class="font-bold text-gray-900">
                            Du {{ $fundraising->start_date->format('d/m/Y') }}<br>
                            au {{ $fundraising->end_date->format('d/m/Y') }}
                        </p>
                    </div>
                    <div class="p-3 bg-emerald-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Nombre de donateurs</p>
                        <p class="font-bold text-green-600 text-2xl">{{ $fundraising->donations()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100">
                <h3 class="text-xl font-bold mb-4 flex items-center gap-2">
                    <i class="fas fa-chart-line text-green-600"></i>
                    Statistiques
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Collecté</span>
                        <span class="text-2xl font-black text-green-600">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-teal-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Objectif</span>
                        <span class="text-2xl font-black text-teal-600">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gradient-to-r from-green-50 to-teal-50 rounded-lg">
                        <span class="text-gray-700 font-semibold">Reste</span>
                        <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-teal-600">
                            {{ number_format(max(0, $fundraising->goal_amount - $fundraising->current_amount), 0, ',', ' ') }} XOF
                        </span>
                    </div>
                    @if($fundraising->donations()->count() > 0)
                        <div class="flex justify-between items-center p-3 bg-emerald-50 rounded-lg">
                            <span class="text-gray-700 font-semibold">Don moyen</span>
                            <span class="text-xl font-black text-emerald-600">
                                {{ number_format($fundraising->current_amount / $fundraising->donations()->count(), 0, ',', ' ') }} XOF
                            </span>
                        </div>
                    @endif
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
    @keyframes shimmer {
        0% {
            background-position: -1000px 0;
        }
        100% {
            background-position: 1000px 0;
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
    .animate-shimmer {
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        background-size: 1000px 100%;
        animation: shimmer 2s infinite;
    }
</style>
@endpush

@push('scripts')
<script>
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
    }
</script>
@endpush
@endsection
