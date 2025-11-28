@extends('layouts.app')

@section('title', $fundraising->name . ' - Tikehub')

@section('content')
<!-- Hero Section avec image -->
<section class="relative">
    @if($fundraising->cover_image)
        <div class="h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $fundraising->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        </div>
    @else
        <div class="h-96 bg-gradient-to-r from-green-600 to-teal-600">
            <div class="absolute inset-0 bg-black bg-opacity-30"></div>
        </div>
    @endif
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-white">
        <div class="flex items-center gap-2 mb-4">
            <span class="bg-green-600 px-4 py-1 rounded-full text-sm font-semibold">
                <i class="fas fa-heart mr-1"></i>Collecte de fonds
            </span>
            @if($fundraising->isActive())
                <span class="bg-green-600 px-4 py-1 rounded-full text-sm font-semibold">Active</span>
            @else
                <span class="bg-gray-600 px-4 py-1 rounded-full text-sm font-semibold">Terminée</span>
            @endif
        </div>
        <h1 class="text-4xl md:text-5xl font-bold mb-4">{{ $fundraising->name }}</h1>
        
        <!-- Barre de progression -->
        <div class="mt-6">
            <div class="flex justify-between text-lg mb-2">
                <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
            </div>
            <div class="w-full bg-gray-700 rounded-full h-4">
                <div class="bg-green-400 h-4 rounded-full transition-all duration-500" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
            </div>
            <p class="text-center mt-2 text-lg font-semibold">{{ number_format($fundraising->progress_percentage, 1) }}% de l'objectif atteint</p>
        </div>

        <div class="flex flex-wrap gap-6 mt-6 text-lg">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>
                <span>Du {{ $fundraising->start_date->format('d/m/Y') }} au {{ $fundraising->end_date->format('d/m/Y') }}</span>
            </div>
            <div class="flex items-center">
                <i class="fas fa-users mr-2"></i>
                <span>{{ $fundraising->donations()->count() }} donateur(s)</span>
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
                <h2 class="text-2xl font-bold mb-4">À propos de cette collecte</h2>
                <div class="prose max-w-none">
                    {!! nl2br(e($fundraising->description)) !!}
                </div>
            </div>

            <!-- Paliers -->
            @if($fundraising->milestones && count($fundraising->milestones) > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Paliers d'objectifs</h2>
                    <div class="space-y-4">
                        @foreach($fundraising->milestones as $milestone)
                            <div class="border-l-4 border-green-500 pl-4 py-2">
                                <h3 class="font-semibold">{{ $milestone['name'] ?? 'Palier' }}</h3>
                                <p class="text-gray-600">{{ $milestone['description'] ?? '' }}</p>
                                <p class="text-green-600 font-semibold mt-1">
                                    Objectif: {{ number_format($milestone['amount'] ?? 0, 0, ',', ' ') }} XOF
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Derniers donateurs -->
            @if($fundraising->show_donors && $fundraising->donations->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold mb-4">Derniers donateurs</h2>
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
                                </div>
                                <div class="text-lg font-bold text-green-600">
                                    {{ number_format($donation->amount, 0, ',', ' ') }} XOF
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Contribution -->
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
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

            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Informations</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Organisateur</p>
                        <p class="font-semibold">{{ $fundraising->organizer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Période</p>
                        <p class="font-semibold">
                            Du {{ $fundraising->start_date->format('d/m/Y') }}<br>
                            au {{ $fundraising->end_date->format('d/m/Y') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Nombre de donateurs</p>
                        <p class="font-semibold">{{ $fundraising->donations()->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4">Statistiques</h3>
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
    function setAmount(amount) {
        document.getElementById('amount').value = amount;
    }
</script>
@endpush
@endsection
