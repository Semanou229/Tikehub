@extends('layouts.dashboard')

@section('title', 'Modifier le Type de Billet')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Modifier le Type de Billet</h1>
    <p class="text-gray-600 mb-6">{{ $event->title }} - {{ $ticketType->name }}</p>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.ticket-types.update', [$event, $ticketType]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du type *</label>
                    <input type="text" name="name" value="{{ old('name', $ticketType->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $ticketType->description) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Prix (XOF) *</label>
                        <input type="number" name="price" value="{{ old('price', $ticketType->price) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('price')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantité *</label>
                        <input type="number" name="quantity" value="{{ old('quantity', $ticketType->quantity) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('quantity')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de début de vente</label>
                        <input type="datetime-local" name="sale_start_date" value="{{ old('sale_start_date', $ticketType->sale_start_date ? $ticketType->sale_start_date->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin de vente</label>
                        <input type="datetime-local" name="sale_end_date" value="{{ old('sale_end_date', $ticketType->sale_end_date ? $ticketType->sale_end_date->format('Y-m-d\TH:i') : '') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="{{ route('organizer.ticket-types.index', $event) }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


