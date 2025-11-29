@extends('layouts.app')

@section('title', 'Mon billet - Tikehub')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Mon billet</h1>
        
        <div class="border rounded-lg p-6 mb-4">
            <h2 class="text-xl font-semibold mb-2">{{ $ticket->event->title }}</h2>
            <div class="space-y-2 text-sm text-gray-600 mb-4">
                <p><strong>Type:</strong> {{ $ticket->ticketType->name }}</p>
                <p><strong>Code:</strong> <span class="font-mono">{{ $ticket->code }}</span></p>
                <p><strong>Date:</strong> {{ $ticket->event->start_date->format('d/m/Y H:i') }}</p>
                @if($ticket->event->is_virtual)
            <p><strong>Type:</strong> Événement virtuel ({{ ucfirst(str_replace('_', ' ', $ticket->event->platform_type ?? 'Visioconférence')) }})</p>
            @if($ticket->virtual_access_token)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                    <h3 class="font-bold text-blue-800 mb-2">Accès à l'événement virtuel</h3>
                    <a href="{{ $ticket->getVirtualAccessUrl() }}" target="_blank" class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition mb-2">
                        <i class="fas fa-video mr-2"></i>Rejoindre l'événement
                    </a>
                    @if($ticket->event->virtual_access_instructions)
                        <p class="text-sm text-gray-700 mt-2">
                            <strong>Instructions:</strong> {{ $ticket->event->virtual_access_instructions }}
                        </p>
                    @endif
                    @if($ticket->event->meeting_password)
                        <p class="text-sm text-gray-700 mt-1">
                            <strong>Mot de passe:</strong> {{ $ticket->event->meeting_password }}
                        </p>
                    @endif
                </div>
            @endif
        @else
            <p><strong>Lieu:</strong> {{ $ticket->event->venue_name }}, {{ $ticket->event->venue_city }}</p>
        @endif
                <p><strong>Acheteur:</strong> {{ $ticket->buyer_name }}</p>
            </div>
            
            @if($ticket->qr_code)
                <div class="text-center my-6">
                    <img src="{{ asset('storage/' . $ticket->qr_code) }}" alt="QR Code" class="mx-auto" style="width: 200px;">
                    <p class="text-sm text-gray-500 mt-2">Présentez ce QR code à l'entrée</p>
                </div>
            @endif
            
            <div class="flex space-x-4 mt-6">
                <a href="{{ route('tickets.download', $ticket) }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700">
                    Télécharger PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

