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
                <p><strong>Lieu:</strong> {{ $ticket->event->venue_name }}, {{ $ticket->event->venue_city }}</p>
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

