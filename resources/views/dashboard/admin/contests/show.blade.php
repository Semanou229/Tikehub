@extends('layouts.admin')

@section('title', $contest->name)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.contests.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
                <h1 class="text-3xl font-bold text-gray-800">{{ $contest->name }}</h1>
            </div>
            <a href="{{ route('admin.contests.edit', $contest) }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                <p class="text-gray-700">{{ $contest->description }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Candidats</h2>
                @if($contest->candidates->count() > 0)
                    <div class="space-y-3">
                        @foreach($contest->candidates->sortByDesc('points') as $candidate)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $candidate->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">{{ $candidate->description }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-purple-600">{{ $candidate->points }}</p>
                                        <p class="text-xs text-gray-500">points</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Aucun candidat</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Total votes</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['total_votes'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Revenus</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Votants uniques</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['unique_voters'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Organisateur</p>
                        <p class="font-semibold">{{ $contest->organizer->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date de fin</p>
                        <p class="font-semibold">{{ $contest->end_date->translatedFormat('d M Y à H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Prix du vote</p>
                        <p class="font-semibold">{{ number_format($contest->vote_price, 0, ',', ' ') }} XOF</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

