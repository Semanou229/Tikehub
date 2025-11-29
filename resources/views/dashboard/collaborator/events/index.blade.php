@extends('layouts.collaborator')

@section('title', 'Mes Événements')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Événements</h1>
        <p class="text-gray-600 mt-2">Événements qui vous sont assignés</p>
    </div>

    @if($assignedEvents->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($assignedEvents as $event)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($event->cover_image)
                        <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl"></i>
                        </div>
                    @endif
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ Str::limit($event->description, 100) }}</p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2 text-indigo-600"></i>
                                <span>{{ $event->start_date->translatedFormat('d M Y à H:i') }}</span>
                            </div>
                            @if($event->venue_name)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                                    <span>{{ $event->venue_name }}, {{ $event->venue_city }}</span>
                                </div>
                            @endif
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user mr-2 text-indigo-600"></i>
                                <span>{{ $event->organizer->name }}</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('collaborator.events.show', $event) }}" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-center">
                                <i class="fas fa-eye mr-2"></i>Voir détails
                            </a>
                            <a href="{{ route('collaborator.scans.index', $event) }}" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-center">
                                <i class="fas fa-qrcode mr-2"></i>Scanner
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun événement assigné</h3>
            <p class="text-gray-600">Vous n'avez pas encore d'événements assignés. Contactez votre organisateur pour être ajouté à un événement.</p>
        </div>
    @endif
</div>
@endsection

