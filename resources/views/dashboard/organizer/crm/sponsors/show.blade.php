@extends('layouts.dashboard')

@section('title', $sponsor->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $sponsor->name }}</h1>
            @if($sponsor->company)
                <p class="text-gray-600 mt-1">{{ $sponsor->company }}</p>
            @endif
        </div>
        <div class="flex gap-3">
            <a href="{{ route('organizer.crm.sponsors.edit', $sponsor) }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('organizer.crm.sponsors.index') }}" class="text-indigo-600 hover:text-indigo-800 px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Informations</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Type:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($sponsor->sponsor_type) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Statut:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full
                        {{ $sponsor->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $sponsor->status === 'prospect' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $sponsor->status === 'negotiating' ? 'bg-blue-100 text-blue-800' : '' }}">
                        {{ ucfirst($sponsor->status) }}
                    </span>
                </div>
                @if($sponsor->email)
                    <div>
                        <span class="text-sm text-gray-600">Email:</span>
                        <span class="ml-2">{{ $sponsor->email }}</span>
                    </div>
                @endif
                @if($sponsor->phone)
                    <div>
                        <span class="text-sm text-gray-600">Téléphone:</span>
                        <span class="ml-2">{{ $sponsor->phone }}</span>
                    </div>
                @endif
                @if($sponsor->event)
                    <div>
                        <span class="text-sm text-gray-600">Événement:</span>
                        <span class="ml-2">{{ $sponsor->event->title }}</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Contribution</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Montant:</span>
                    <span class="ml-2 text-2xl font-bold text-green-600">
                        {{ number_format($sponsor->contribution_amount, 0, ',', ' ') }} {{ $sponsor->currency }}
                    </span>
                </div>
                @if($sponsor->contract_start_date)
                    <div>
                        <span class="text-sm text-gray-600">Début contrat:</span>
                        <span class="ml-2">{{ $sponsor->contract_start_date->format('d/m/Y') }}</span>
                    </div>
                @endif
                @if($sponsor->contract_end_date)
                    <div>
                        <span class="text-sm text-gray-600">Fin contrat:</span>
                        <span class="ml-2">{{ $sponsor->contract_end_date->format('d/m/Y') }}</span>
                    </div>
                @endif
            </div>
        </div>

        @if($sponsor->benefits)
            <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Avantages accordés</h3>
                <div class="text-gray-700 whitespace-pre-wrap">{{ $sponsor->benefits }}</div>
            </div>
        @endif

        @if($sponsor->notes)
            <div class="md:col-span-2 bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold text-gray-800 mb-4">Notes</h3>
                <div class="text-gray-700 whitespace-pre-wrap">{{ $sponsor->notes }}</div>
            </div>
        @endif
    </div>
</div>
@endsection


