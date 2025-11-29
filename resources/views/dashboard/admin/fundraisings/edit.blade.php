@extends('layouts.admin')

@section('title', 'Modifier la Collecte de Fonds')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier la Collecte de Fonds</h1>
        <a href="{{ route('admin.fundraisings.show', $fundraising) }}" class="text-red-600 hover:text-red-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.fundraisings.update', $fundraising) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur *</label>
                    <select name="organizer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @foreach($organizers as $organizer)
                            <option value="{{ $organizer->id }}" {{ $fundraising->organizer_id == $organizer->id ? 'selected' : '' }}>
                                {{ $organizer->name }} ({{ $organizer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('organizer_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la collecte *</label>
                            <input type="text" name="name" value="{{ old('name', $fundraising->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('description', $fundraising->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            @if($fundraising->cover_image)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $fundraising->cover_image) }}" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Objectif financier -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Objectif financier</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant objectif (XOF) *</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount', $fundraising->goal_amount) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @error('goal_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-green-600 mt-2">
                            <strong>Actuellement collecté :</strong> {{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF
                        </p>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $fundraising->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $fundraising->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Options</h2>
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_donors" value="1" {{ old('show_donors', $fundraising->show_donors) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm text-gray-700">Afficher la liste des donateurs publiquement</span>
                        </label>
                    </div>
                </div>

                <!-- Événement associé -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événement associé (optionnel)</label>
                    <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Aucun événement</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $fundraising->event_id) == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} - {{ $event->organizer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Statut -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statut</h2>
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published', $fundraising->is_published) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm text-gray-700">Publier</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $fundraising->is_active) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm text-gray-700">Actif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('admin.fundraisings.show', $fundraising) }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


