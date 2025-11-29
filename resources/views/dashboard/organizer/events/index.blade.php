@extends('layouts.dashboard')

@section('title', 'Mes Événements')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Événements</h1>
        <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvel événement
        </a>
    </div>

    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $event->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $event->category }}</p>
                            </div>
                            <div class="ml-4">
                                @if($event->is_published)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2 w-4"></i>
                                <span>{{ $event->start_date->format('d/m/Y') }} à {{ $event->start_date->format('H:i') }}</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-ticket-alt text-indigo-600 mr-2 w-4"></i>
                                <span><strong>{{ $event->tickets_count }}</strong> billets vendus</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-tags text-indigo-600 mr-2 w-4"></i>
                                <span>{{ $event->ticket_types_count }} types de billets</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('events.edit', $event) }}" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-50" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('organizer.ticket-types.index', $event) }}" class="text-purple-600 hover:text-purple-900 p-2 rounded-lg hover:bg-purple-50" title="Types de billets">
                                    <i class="fas fa-ticket-alt"></i>
                                </a>
                                <a href="{{ route('organizer.scans.index', $event) }}" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50" title="Scans">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                            </div>
                            <form action="{{ route('organizer.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun événement créé pour le moment</p>
            <a href="{{ route('events.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer mon premier événement
            </a>
        </div>
    @endif
</div>
@endsection

