@extends('layouts.app')

@section('title', 'Collectes de fonds - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-0 mb-2">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Collectes de fonds</h1>
                <p class="text-sm sm:text-base text-gray-600">Soutenez les causes qui vous tiennent à cœur</p>
            </div>
            @auth
                @if(auth()->user()->isOrganizer())
                    <a href="{{ route('fundraisings.create') }}" class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:from-green-700 hover:to-teal-700 active:from-green-800 active:to-teal-800 transition shadow-md hover:shadow-lg text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Créer une collecte</span><span class="sm:hidden">Créer</span>
                    </a>
                @endif
            @endauth
        </div>
    </div>

    <!-- Layout avec sidebar de filtres -->
    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
        <!-- Sidebar des filtres (sticky) -->
        <aside class="lg:w-80 flex-shrink-0 order-2 lg:order-1">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:sticky lg:top-20 relative">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-green-600"></i>Filtres
                </h2>
                <form method="GET" action="{{ route('fundraisings.index') }}" class="space-y-3 sm:space-y-4">
                    <div class="space-y-3 sm:space-y-4">
                <!-- Montant objectif minimum -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Objectif min (XOF)</label>
                    <input type="number" name="goal_min" value="{{ request('goal_min') }}" placeholder="0" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Montant objectif maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Objectif max (XOF)</label>
                    <input type="number" name="goal_max" value="{{ request('goal_max') }}" placeholder="∞" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Progression minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progression min (%)</label>
                    <input type="number" name="progress_min" value="{{ request('progress_min') }}" placeholder="0" min="0" max="100"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Progression maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progression max (%)</label>
                    <input type="number" name="progress_max" value="{{ request('progress_max') }}" placeholder="100" min="0" max="100"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Date de fin (début) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin après le</label>
                    <input type="date" name="end_date_from" value="{{ request('end_date_from') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Date de fin (fin) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin avant le</label>
                    <input type="date" name="end_date_to" value="{{ request('end_date_to') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 min-h-[44px]">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tous les organisateurs</option>
                        @foreach($organizers ?? [] as $organizer)
                            <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>{{ $organizer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="progress" {{ request('sort') == 'progress' ? 'selected' : '' }}>Progression</option>
                        <option value="goal_asc" {{ request('sort') == 'goal_asc' ? 'selected' : '' }}>Objectif (croissant)</option>
                        <option value="goal_desc" {{ request('sort') == 'goal_desc' ? 'selected' : '' }}>Objectif (décroissant)</option>
                        <option value="amount_asc" {{ request('sort') == 'amount_asc' ? 'selected' : '' }}>Montant (croissant)</option>
                        <option value="amount_desc" {{ request('sort') == 'amount_desc' ? 'selected' : '' }}>Montant (décroissant)</option>
                        <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>Fin proche</option>
                    </select>
                </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-3 sm:pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 active:bg-green-800 transition min-h-[44px] text-sm sm:text-base font-medium">
                            <i class="fas fa-filter mr-2"></i>Appliquer les filtres
                        </button>
                        <a href="{{ route('fundraisings.index') }}" class="w-full text-center text-xs sm:text-sm text-gray-600 hover:text-green-600 py-2 min-h-[44px] flex items-center justify-center">
                            <i class="fas fa-redo mr-1"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="flex-1 min-w-0">
            <!-- Résultats -->
            <div class="mb-4 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-2"></i>
                {{ $fundraisings->total() }} collecte(s) trouvée(s)
            </div>

            <!-- Grille de collectes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($fundraisings as $fundraising)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="{{ route('fundraisings.show', $fundraising) }}" class="block">
                    @if($fundraising->cover_image)
                        <img src="{{ asset('storage/' . $fundraising->cover_image) }}" alt="{{ $fundraising->name }}" class="w-full h-40 sm:h-48 object-cover">
                    @else
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-heart text-4xl sm:text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                </a>
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Collecte
                        </span>
                        <span class="text-sm font-bold text-green-600">
                            {{ number_format($fundraising->progress_percentage, 0) }}%
                        </span>
                    </div>
                    <a href="{{ route('fundraisings.show', $fundraising) }}">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-green-600 transition">{{ $fundraising->name }}</h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($fundraising->description, 100) }}</p>
                    
                    <!-- Barre de progression -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                            <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au {{ $fundraising->end_date->translatedFormat('d/m/Y') }}</span>
                    </div>
                    @if($fundraising->organizer)
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-user-circle mr-2 text-green-600"></i>
                            <span>Par</span>
                            <a href="{{ route('organizer.profile.show', $fundraising->organizer) }}" class="ml-1 text-green-600 hover:text-green-800 font-semibold hover:underline">
                                {{ $fundraising->organizer->name }}
                            </a>
                        </div>
                    @endif
                    <a href="{{ route('fundraisings.show', $fundraising) }}" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Contribuer
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucune collecte trouvée</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        @endforelse
    </div>

            <!-- Pagination -->
            @if($fundraisings->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                        {{ $fundraisings->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
