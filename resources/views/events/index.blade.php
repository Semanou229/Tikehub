@extends('layouts.app')

@section('title', 'Événements - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8 py-4 sm:py-6 lg:py-8">
    <div class="mb-4 sm:mb-6 lg:mb-8">
        <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2">Découvrez nos événements</h1>
        <p class="text-sm sm:text-base text-gray-600">Trouvez l'événement parfait pour vous</p>
    </div>

    <!-- Layout avec sidebar de filtres -->
    <div class="flex flex-col lg:flex-row gap-4 sm:gap-6">
        <!-- Sidebar des filtres (sticky) -->
        <aside class="lg:w-80 flex-shrink-0 order-2 lg:order-1">
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6 lg:sticky lg:top-20 relative">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-3 sm:mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-indigo-600"></i>Filtres
                </h2>
                <form method="GET" action="{{ route('events.index') }}" class="space-y-3 sm:space-y-4">
                    <div class="space-y-3 sm:space-y-4">
                <!-- Recherche -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Recherche</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, description..." 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Catégorie</label>
                    <select name="category" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                        <option value="">Toutes les catégories</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date de début -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Date de fin -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Date de fin</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Localisation -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Localisation</label>
                    <input type="text" name="location" value="{{ request('location') }}" placeholder="Ville..." 
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Prix minimum -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Prix min (XOF)</label>
                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Prix maximum -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Prix max (XOF)</label>
                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="∞" min="0"
                           class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                        <option value="">Tous les organisateurs</option>
                        @foreach($organizers ?? [] as $organizer)
                            <option value="{{ $organizer->id }}" {{ request('organizer') == $organizer->id ? 'selected' : '' }}>{{ $organizer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Options -->
                <div class="flex flex-col space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Options</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="free" value="true" {{ request('free') == 'true' ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Gratuit uniquement</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="virtual" value="true" {{ request('virtual') == 'true' ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Événements virtuels</span>
                    </label>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Trier par</label>
                    <select name="sort" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                        <option value="date_desc" {{ request('sort') == 'date_desc' ? 'selected' : '' }}>Date (récent)</option>
                        <option value="date_asc" {{ request('sort') == 'date_asc' ? 'selected' : '' }}>Date (ancien)</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Plus populaires</option>
                    </select>
                </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-3 sm:pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition min-h-[44px] text-sm sm:text-base font-medium">
                            <i class="fas fa-filter mr-2"></i>Appliquer les filtres
                        </button>
                        <a href="{{ route('events.index') }}" class="w-full text-center text-xs sm:text-sm text-gray-600 hover:text-indigo-600 py-2 min-h-[44px] flex items-center justify-center">
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
                {{ $events->total() }} événement(s) trouvé(s)
            </div>

            <!-- Grille d'événements -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="{{ route('events.show', $event) }}" class="block">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-40 sm:h-48 object-cover">
                    @else
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar text-4xl sm:text-6xl text-white opacity-50"></i>
                        </div>
                    @endif
                </a>
                <div class="p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $event->category ?? 'Événement' }}
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
                    <a href="{{ route('events.show', $event) }}">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                    @if($event->start_date)
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $event->start_date->translatedFormat('d/m/Y H:i') }}
                        </div>
                    @endif
                    @if($event->venue_city)
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $event->venue_city }}
                        </div>
                    @endif
                    @if($event->organizer)
                        <div class="flex items-center text-sm text-gray-600 mb-3">
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
                        <div class="mb-3">
                            <span class="text-lg font-bold text-indigo-600">
                                À partir de {{ number_format($minPrice, 0, ',', ' ') }} XOF
                            </span>
                        </div>
                    @elseif($event->is_free)
                        <div class="mb-3">
                            <span class="text-lg font-bold text-green-600">
                                Gratuit
                            </span>
                        </div>
                    @endif
                    <a href="{{ route('events.show', $event) }}" class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Voir l'événement
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun événement trouvé</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        @endforelse
    </div>

            <!-- Pagination -->
            @if($events->hasPages())
                <div class="mt-8 flex justify-center">
                    <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                        {{ $events->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
