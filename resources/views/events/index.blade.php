@extends('layouts.app')

@section('title', 'Événements - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Découvrez nos événements</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
            <a href="{{ route('events.show', $event) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                @if($event->cover_image)
                    <img src="{{ asset('storage/' . $event->cover_image) }}" alt="{{ $event->title }}" class="w-full h-48 object-cover">
                @endif
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $event->category }}
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
                    <h3 class="text-xl font-semibold mb-2 hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ \Illuminate\Support\Str::limit($event->description, 100) }}</p>
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
                    <span class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Voir l'événement
                    </span>
                </div>
            </a>
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

