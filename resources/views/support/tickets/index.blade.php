@extends('layouts.app')

@section('title', 'Mes Tickets de Support')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Mes Tickets de Support</h1>
                <p class="text-gray-600">Gérez vos demandes d'assistance</p>
            </div>
            <a href="{{ route('support.tickets.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                <i class="fas fa-plus mr-2"></i>Nouveau Ticket
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="{{ route('support.tickets.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les statuts</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Ouvert</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Résolu</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Fermé</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Priorité</label>
                    <select name="priority" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les priorités</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Basse</option>
                        <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Moyenne</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Haute</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgente</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-filter mr-2"></i>Filtrer
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Liste des tickets -->
    <div class="space-y-4">
        @forelse($tickets as $ticket)
            <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition duration-300 border-l-4 
                @if($ticket->priority == 'urgent') border-red-500
                @elseif($ticket->priority == 'high') border-orange-500
                @elseif($ticket->priority == 'medium') border-yellow-500
                @else border-green-500
                @endif">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <a href="{{ route('support.tickets.show', $ticket) }}" class="text-xl font-semibold text-gray-800 hover:text-indigo-600 transition">
                                #{{ $ticket->ticket_number }} - {{ $ticket->subject }}
                            </a>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($ticket->status == 'open') bg-green-100 text-green-800
                                @elseif($ticket->status == 'in_progress') bg-blue-100 text-blue-800
                                @elseif($ticket->status == 'resolved') bg-gray-100 text-gray-800
                                @else bg-red-100 text-red-800
                                @endif">
                                @if($ticket->status == 'open') Ouvert
                                @elseif($ticket->status == 'in_progress') En cours
                                @elseif($ticket->status == 'resolved') Résolu
                                @else Fermé
                                @endif
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($ticket->priority == 'urgent') bg-red-100 text-red-800
                                @elseif($ticket->priority == 'high') bg-orange-100 text-orange-800
                                @elseif($ticket->priority == 'medium') bg-yellow-100 text-yellow-800
                                @else bg-green-100 text-green-800
                                @endif">
                                @if($ticket->priority == 'urgent') Urgente
                                @elseif($ticket->priority == 'high') Haute
                                @elseif($ticket->priority == 'medium') Moyenne
                                @else Basse
                                @endif
                            </span>
                        </div>
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($ticket->description, 150) }}</p>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span><i class="fas fa-calendar mr-1"></i>Créé le {{ $ticket->created_at->translatedFormat('d/m/Y à H:i') }}</span>
                            @if($ticket->last_replied_at)
                                <span><i class="fas fa-reply mr-1"></i>Dernière réponse le {{ $ticket->last_replied_at->translatedFormat('d/m/Y à H:i') }}</span>
                            @endif
                            @if($ticket->assignedTo)
                                <span><i class="fas fa-user-shield mr-1"></i>Assigné à {{ $ticket->assignedTo->name }}</span>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('support.tickets.show', $ticket) }}" class="ml-4 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-eye mr-2"></i>Voir
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-ticket-alt text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun ticket trouvé</p>
                <p class="text-gray-400 text-sm mb-6">Créez votre premier ticket de support pour commencer</p>
                <a href="{{ route('support.tickets.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Créer un ticket
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($tickets->hasPages())
        <div class="mt-8 flex justify-center">
            <div class="bg-white rounded-lg shadow-md px-4 py-3 inline-flex items-center space-x-2">
                {{ $tickets->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

