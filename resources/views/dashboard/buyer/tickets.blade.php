@extends('layouts.buyer-dashboard')

@section('title', 'Mes Billets')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Mes Billets</h1>
        <a href="{{ route('home') }}" class="bg-indigo-600 text-white px-3 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg w-full sm:w-auto">
            <i class="fas fa-search text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Découvrir des événements</span><span class="sm:hidden">Découvrir</span>
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 mb-4 sm:mb-6">
        <form method="GET" action="{{ route('buyer.tickets') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div class="sm:col-span-2 lg:col-span-1">
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Rechercher</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom de l'événement..." class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Filtrer par</label>
                <select name="status" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 min-h-[44px]">
                    <option value="">Tous</option>
                    <option value="upcoming" {{ request('status') === 'upcoming' ? 'selected' : '' }}>À venir</option>
                    <option value="past" {{ request('status') === 'past' ? 'selected' : '' }}>Passés</option>
                    <option value="virtual" {{ request('status') === 'virtual' ? 'selected' : '' }}>Virtuels</option>
                </select>
            </div>
            <div class="flex gap-2 items-end">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-3 sm:px-4 lg:px-6 py-2 sm:py-2.5 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm min-h-[44px] flex items-center justify-center shadow-sm hover:shadow-md">
                    <i class="fas fa-filter text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Filtrer</span><span class="sm:hidden">Filt.</span>
                </button>
                @if(request('search') || request('status'))
                    <a href="{{ route('buyer.tickets') }}" class="bg-gray-200 text-gray-700 px-3 sm:px-4 py-2 sm:py-2.5 rounded-lg hover:bg-gray-300 active:bg-gray-400 transition min-w-[44px] min-h-[44px] flex items-center justify-center">
                        <i class="fas fa-times text-xs sm:text-sm"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Liste des billets -->
    @if($tickets->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($tickets as $ticket)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($ticket->event->cover_image)
                        <img src="{{ asset('storage/' . $ticket->event->cover_image) }}" alt="{{ $ticket->event->title }}" class="w-full h-40 sm:h-48 object-cover">
                    @else
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-r from-indigo-500 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-4xl sm:text-5xl lg:text-6xl opacity-50"></i>
                        </div>
                    @endif
                    
                    <div class="p-4 sm:p-6">
                        <div class="flex items-start justify-between mb-2 sm:mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 break-words">{{ $ticket->event->title }}</h3>
                                <p class="text-xs sm:text-sm text-gray-600 truncate">{{ $ticket->ticketType->name }}</p>
                            </div>
                            @if($ticket->event->is_virtual)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 flex-shrink-0 ml-2">
                                    <i class="fas fa-video text-xs"></i> <span class="hidden sm:inline">Virtuel</span>
                                </span>
                            @endif
                        </div>

                        <div class="space-y-1.5 sm:space-y-2 mb-3 sm:mb-4 text-xs sm:text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs"></i>
                                <span class="truncate">{{ $ticket->event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                            </div>
                            @if(!$ticket->event->is_virtual && $ticket->event->venue_city)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-indigo-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs"></i>
                                    <span class="truncate">{{ $ticket->event->venue_city }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-barcode text-indigo-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs"></i>
                                <span class="font-mono text-xs truncate">{{ $ticket->code }}</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave text-indigo-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs"></i>
                                <span class="truncate">{{ number_format($ticket->price, 0, ',', ' ') }} XOF</span>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-2 sm:gap-0 pt-3 sm:pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-800 active:text-indigo-700 p-2 rounded-lg hover:bg-indigo-50 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Voir le billet">
                                    <i class="fas fa-eye text-xs sm:text-sm"></i>
                                </a>
                                <a href="{{ route('tickets.download', $ticket) }}" class="text-green-600 hover:text-green-800 active:text-green-700 p-2 rounded-lg hover:bg-green-50 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Télécharger PDF">
                                    <i class="fas fa-download text-xs sm:text-sm"></i>
                                </a>
                            </div>
                            @if($ticket->event->is_virtual && $ticket->virtual_access_token && $ticket->event->start_date >= now())
                                <a href="{{ $ticket->getVirtualAccessUrl() }}" target="_blank" class="bg-blue-600 text-white px-3 sm:px-4 py-2 rounded-lg hover:bg-blue-700 active:bg-blue-800 text-xs sm:text-sm font-medium min-h-[36px] flex items-center justify-center shadow-sm hover:shadow-md">
                                    <i class="fas fa-video mr-1 text-xs"></i>Rejoindre
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($tickets->hasPages())
            <div class="mt-4 sm:mt-6 overflow-x-auto">
                <div class="min-w-fit">
                    {{ $tickets->links() }}
                </div>
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow-md p-6 sm:p-8 lg:p-12 text-center">
            <i class="fas fa-ticket-alt text-4xl sm:text-5xl lg:text-6xl text-gray-300 mb-3 sm:mb-4"></i>
            <p class="text-sm sm:text-base text-gray-500 mb-3 sm:mb-4">Aucun billet trouvé</p>
            <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white px-4 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                <i class="fas fa-search text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Découvrir des événements
            </a>
        </div>
    @endif
</div>
@endsection

