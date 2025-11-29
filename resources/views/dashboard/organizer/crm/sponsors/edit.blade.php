@extends('layouts.dashboard')

@section('title', 'Modifier Sponsor')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Sponsor</h1>
        <a href="{{ route('organizer.crm.sponsors.show', $sponsor) }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.crm.sponsors.update', $sponsor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" name="name" value="{{ old('name', $sponsor->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                    <input type="text" name="company" value="{{ old('company', $sponsor->company) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $sponsor->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone', $sponsor->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de sponsor *</label>
                    <select name="sponsor_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="gold" {{ old('sponsor_type', $sponsor->sponsor_type) == 'gold' ? 'selected' : '' }}>Gold</option>
                        <option value="silver" {{ old('sponsor_type', $sponsor->sponsor_type) == 'silver' ? 'selected' : '' }}>Silver</option>
                        <option value="bronze" {{ old('sponsor_type', $sponsor->sponsor_type) == 'bronze' ? 'selected' : '' }}>Bronze</option>
                        <option value="partner" {{ old('sponsor_type', $sponsor->sponsor_type) == 'partner' ? 'selected' : '' }}>Partenaire</option>
                        <option value="media" {{ old('sponsor_type', $sponsor->sponsor_type) == 'media' ? 'selected' : '' }}>Média</option>
                        <option value="other" {{ old('sponsor_type', $sponsor->sponsor_type) == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Statut *</label>
                    <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="prospect" {{ old('status', $sponsor->status) == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="negotiating" {{ old('status', $sponsor->status) == 'negotiating' ? 'selected' : '' }}>En négociation</option>
                        <option value="confirmed" {{ old('status', $sponsor->status) == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                        <option value="delivered" {{ old('status', $sponsor->status) == 'delivered' ? 'selected' : '' }}>Livré</option>
                        <option value="closed" {{ old('status', $sponsor->status) == 'closed' ? 'selected' : '' }}>Clôturé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant de contribution *</label>
                    <input type="number" name="contribution_amount" value="{{ old('contribution_amount', $sponsor->contribution_amount) }}" step="0.01" min="0" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Devise *</label>
                    <select name="currency" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="XOF" {{ old('currency', $sponsor->currency) == 'XOF' ? 'selected' : '' }}>XOF</option>
                        <option value="EUR" {{ old('currency', $sponsor->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                        <option value="USD" {{ old('currency', $sponsor->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événement</label>
                    <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Aucun événement spécifique</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $sponsor->event_id) == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contact existant</label>
                    <select name="contact_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Aucun contact</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('contact_id', $sponsor->contact_id) == $contact->id ? 'selected' : '' }}>{{ $contact->full_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date début contrat</label>
                    <input type="date" name="contract_start_date" value="{{ old('contract_start_date', $sponsor->contract_start_date?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date fin contrat</label>
                    <input type="date" name="contract_end_date" value="{{ old('contract_end_date', $sponsor->contract_end_date?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Avantages accordés</label>
                    <textarea name="benefits" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('benefits', $sponsor->benefits) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('notes', $sponsor->notes) }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="{{ route('organizer.crm.sponsors.show', $sponsor) }}" class="text-gray-600 hover:text-gray-800 px-8 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

