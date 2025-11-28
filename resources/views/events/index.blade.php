@extends('layouts.app')

@section('title', 'Événements - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Découvrez nos événements</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2">{{ $event->title }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
                    @if($event->start_date)
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            {{ $event->start_date->format('d/m/Y H:i') }}
                        </div>
                    @endif
                    @if($event->venue_city)
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            {{ $event->venue_city }}
                        </div>
                    @endif
                    <a href="{{ route('events.show', $event) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 inline-block">
                        Voir l'événement
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Aucun événement disponible pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if(isset($events) && method_exists($events, 'hasPages') && $events->hasPages())
        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection

