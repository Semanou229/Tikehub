@extends('layouts.app')

@section('title', 'Acheter des billets - Tikehub')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Acheter des billets - {{ $event->title }}</h1>

    <form method="POST" action="{{ route('tickets.purchase') }}" class="bg-white rounded-lg shadow-lg p-6">
        @csrf
        <input type="hidden" name="event_id" value="{{ $event->id }}">
        
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Type de billet</label>
            <select name="ticket_type_id" id="ticket_type_id" required class="w-full border rounded px-4 py-2">
                @foreach($ticketTypes as $ticketType)
                    <option value="{{ $ticketType->id }}" data-price="{{ $ticketType->price }}">
                        {{ $ticketType->name }} - {{ number_format($ticketType->price, 0, ',', ' ') }} XOF
                        ({{ $ticketType->available_quantity }} disponible(s))
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Quantité</label>
            <input type="number" name="quantity" id="quantity" min="1" max="10" value="1" required
                class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Nom complet</label>
            <input type="text" name="buyer_name" value="{{ auth()->user()->name }}" required
                class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Email</label>
            <input type="email" name="buyer_email" value="{{ auth()->user()->email }}" required
                class="w-full border rounded px-4 py-2">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">Téléphone</label>
            <input type="text" name="buyer_phone" value="{{ auth()->user()->phone }}"
                class="w-full border rounded px-4 py-2">
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 w-full">
            Procéder au paiement
        </button>
    </form>
</div>
@endsection

