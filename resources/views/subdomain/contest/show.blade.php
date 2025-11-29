@extends('layouts.app')

@section('title', $contest->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    @if($contest->cover_image)
        <div class="relative h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $contest->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <span class="bg-purple-600 px-4 py-2 rounded-full text-sm font-semibold mb-4 inline-block">Concours</span>
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $contest->name }}</h1>
                    <p class="text-xl">{{ number_format($contest->total_votes, 0, ',', ' ') }} votes</p>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-semibold mb-4 inline-block">Concours</span>
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $contest->name }}</h1>
                <p class="text-xl">{{ number_format($contest->total_votes, 0, ',', ' ') }} votes</p>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <!-- Description -->
                @if($contest->description)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">À propos</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($contest->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Règles -->
                @if($contest->rules)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Règles</h2>
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($contest->rules)) !!}
                        </div>
                    </div>
                @endif

                <!-- Classement -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Classement</h2>
                    <div class="space-y-4">
                        @foreach($ranking as $index => $candidate)
                            <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-lg {{ $index < 3 ? 'bg-yellow-50 border-yellow-300' : '' }}">
                                <div class="text-2xl font-bold text-gray-400 w-8">#{{ $index + 1 }}</div>
                                @if($candidate->photo)
                                    <img src="{{ asset('storage/' . $candidate->photo) }}" alt="{{ $candidate->name }}" class="w-16 h-16 rounded-full object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400 text-2xl"></i>
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">{{ $candidate->name }}</div>
                                    @if($candidate->description)
                                        <div class="text-sm text-gray-600">{{ Str::limit($candidate->description, 100) }}</div>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-purple-600">{{ number_format($candidate->total_points, 0, ',', ' ') }}</div>
                                    <div class="text-xs text-gray-500">points</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Informations</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Prix par vote</div>
                            <div class="text-2xl font-bold text-purple-600">
                                {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF
                            </div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Points par vote</div>
                            <div class="text-xl font-semibold text-gray-800">{{ $contest->points_per_vote }}</div>
                        </div>
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Période</div>
                            <div class="text-gray-800">
                                Du {{ $contest->start_date->format('d M Y') }}<br>
                                au {{ $contest->end_date->format('d M Y') }}
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('contests.show', $contest) }}" class="block w-full text-center bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                        Voter maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


