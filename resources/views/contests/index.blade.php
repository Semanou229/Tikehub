@extends('layouts.app')

@section('title', 'Concours & Votes - Tikehub')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Concours & Votes payants</h1>
        @auth
            @if(auth()->user()->isOrganizer())
                <a href="{{ route('contests.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700">
                    <i class="fas fa-plus mr-2"></i>Créer un concours
                </a>
            @endif
        @endauth
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($contests as $contest)
            <a href="{{ route('contests.show', $contest) }}" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                @if($contest->cover_image)
                    <img src="{{ asset('storage/' . $contest->cover_image) }}" alt="{{ $contest->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                        <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Concours
                        </span>
                        <span class="text-sm text-gray-500">
                            {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF/vote
                        </span>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 hover:text-purple-600 transition">{{ $contest->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4">{{ \Illuminate\Support\Str::limit($contest->description, 100) }}</p>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au {{ $contest->end_date->translatedFormat('d/m/Y') }}</span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-users mr-2"></i>
                        <span>{{ $contest->votes_count }} vote(s)</span>
                    </div>
                    <span class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700">
                        Voir le concours
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg">Aucun concours actif pour le moment.</p>
            </div>
        @endforelse
    </div>

    @if($contests->hasPages())
        <div class="mt-6">
            {{ $contests->links() }}
        </div>
    @endif
</div>
@endsection

