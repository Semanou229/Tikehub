@extends('layouts.admin')

@section('title', $fundraising->name)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.fundraisings.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
                    <i class="fas fa-arrow-left mr-2"></i>Retour
                </a>
                <h1 class="text-3xl font-bold text-gray-800">{{ $fundraising->name }}</h1>
            </div>
            <a href="{{ route('admin.fundraisings.edit', $fundraising) }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                <p class="text-gray-700">{{ $fundraising->description }}</p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Dons récents</h2>
                @if($fundraising->donations->count() > 0)
                    <div class="space-y-3">
                        @foreach($fundraising->donations->take(10) as $donation)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-semibold text-gray-800">{{ $donation->user->name ?? 'Anonyme' }}</h3>
                                        <p class="text-sm text-gray-500">{{ $donation->created_at->translatedFormat('d M Y à H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-green-600">{{ number_format($donation->amount, 0, ',', ' ') }} XOF</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Aucun don</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Montant collecté</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_amount'], 0, ',', ' ') }} XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Objectif</p>
                        <p class="text-2xl font-bold text-gray-600">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Progression</p>
                        <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                            <div class="bg-green-600 h-4 rounded-full" style="width: {{ min($stats['progress'], 100) }}%"></div>
                        </div>
                        <p class="text-sm text-gray-500 mt-1">{{ number_format($stats['progress'], 1) }}%</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total dons</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total_donations'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Donateurs uniques</p>
                        <p class="text-2xl font-bold text-purple-600">{{ $stats['unique_donors'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Organisateur</p>
                        <p class="font-semibold">{{ $fundraising->organizer->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Date de fin</p>
                        <p class="font-semibold">{{ $fundraising->end_date->translatedFormat('d M Y à H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

