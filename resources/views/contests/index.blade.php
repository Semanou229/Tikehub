@extends('layouts.app')

@section('title', 'Concours & Votes - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 sm:gap-0 mb-2">
            <div>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Concours & Votes payants</h1>
                <p class="text-sm sm:text-base text-gray-600">Participez aux concours et votez pour vos favoris</p>
            </div>
            @auth
                @if(auth()->user()->isOrganizer())
                    <a href="{{ route('contests.create') }}" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:from-purple-700 hover:to-pink-700 active:from-purple-800 active:to-pink-800 transition shadow-md hover:shadow-lg text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Créer un concours</span><span class="sm:hidden">Créer</span>
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
                    <i class="fas fa-filter mr-2 text-purple-600"></i>Filtres
                </h2>
                <form method="GET" action="{{ route('contests.index') }}" class="space-y-3 sm:space-y-4">
                    <div class="space-y-3 sm:space-y-4">
                <!-- Prix minimum par vote -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Prix min/vote (XOF)</label>
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 min-h-[44px]">
                </div>

                <!-- Prix maximum par vote -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix max/vote (XOF)</label>
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="∞" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 min-h-[44px]">
                </div>

                <!-- Date de fin (début) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin après le</label>
                    <input type="date" name="end_date_from" value="{{ request('end_date_from') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 min-h-[44px]">
                </div>

                <!-- Date de fin (fin) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin avant le</label>
                    <input type="date" name="end_date_to" value="{{ request('end_date_to') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 min-h-[44px]">
                </div>

                <!-- Nombre minimum de votes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min votes</label>
                    <input type="number" name="min_votes" value="{{ request('min_votes') }}" placeholder="0" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 min-h-[44px]">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Tous les organisateurs</option>
                        @foreach($organizers ?? [] as $organizer)
                            <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>{{ $organizer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                        <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>Fin proche</option>
                    </select>
                </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-filter mr-2"></i>Appliquer les filtres
                        </button>
                        <a href="{{ route('contests.index') }}" class="w-full text-center text-sm text-gray-600 hover:text-purple-600 py-2">
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
                {{ $contests->total() }} concours trouvé(s)
            </div>

            <!-- Grille de concours -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($contests as $contest)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="{{ route('contests.show', $contest) }}" class="block">
                    @if($contest->cover_image)
                        <img src="{{ asset('storage/' . $contest->cover_image) }}" alt="{{ $contest->name }}" class="w-full h-40 sm:h-48 object-cover">
                    @else
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-trophy text-4xl sm:text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                </a>
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Concours
                        </span>
                        <span class="text-sm font-bold text-purple-600">
                            {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF/vote
                        </span>
                    </div>
                    <a href="{{ route('contests.show', $contest) }}">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-purple-600 transition">{{ $contest->name }}</h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ \Illuminate\Support\Str::limit($contest->description, 100) }}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au {{ $contest->end_date->translatedFormat('d/m/Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $contest->votes_count ?? 0 }} vote(s)</span>
                    </div>
                    @if($contest->organizer)
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-user-circle mr-2 text-purple-600"></i>
                            <span>Par</span>
                            <a href="{{ route('organizer.profile.show', $contest->organizer) }}" class="ml-1 text-purple-600 hover:text-purple-800 font-semibold hover:underline">
                                {{ $contest->organizer->name }}
                            </a>
                        </div>
                    @endif
                    <a href="{{ route('contests.show', $contest) }}" class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        Voir le concours
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun concours trouvé</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        @endforelse
    </div>

            <!-- Pagination -->
            @if($contests->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                        {{ $contests->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
