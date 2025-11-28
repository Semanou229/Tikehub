@extends('layouts.app')

@section('title', 'Collectes de fonds - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Collectes de fonds</h1>
        @auth
            @if(auth()->user()->isOrganizer())
                <a href="{{ route('fundraisings.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">
                    <i class="fas fa-plus mr-2"></i>Créer une collecte
                </a>
            @endif
        @endauth
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($fundraisings as $fundraising)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                @if($fundraising->cover_image)
                    <img src="{{ asset('storage/' . $fundraising->cover_image) }}" alt="{{ $fundraising->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                        <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Collecte
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ number_format($fundraising->progress_percentage, 0) }}%
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">{{ $fundraising->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($fundraising->description, 100) }}</p>
                    
                    <!-- Barre de progression -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                            <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au {{ $fundraising->end_date->format('d/m/Y') }}</span>
                    </div>
                    <a href="{{ route('fundraisings.show', $fundraising) }}" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700">
                        Contribuer
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Aucune collecte active pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if($fundraisings->hasPages())
        <div class="mt-6">
            {{ $fundraisings->links() }}
        </div>
    @endif
</div>
@endsection

