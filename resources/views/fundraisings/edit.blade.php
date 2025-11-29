@extends('layouts.dashboard')

@section('title', 'Modifier une Collecte de Fonds')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier la Collecte de Fonds</h1>
        <a href="{{ route('organizer.fundraisings.index') }}" class="text-green-600 hover:text-green-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('fundraisings.update', $fundraising) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la collecte *</label>
                            <input type="text" name="name" value="{{ old('name', $fundraising->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Ex: Aide aux Victimes des Inondations">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="6" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Décrivez votre collecte de fonds...">{{ old('description', $fundraising->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            @if($fundraising->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($fundraising->cover_image) }}" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Objectif financier -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Objectif financier</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant objectif (XOF) *</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount', $fundraising->goal_amount) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="1000000">
                        @error('goal_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Montant total que vous souhaitez collecter</p>
                        <p class="text-sm text-green-600 mt-2">
                            <strong>Actuellement collecté :</strong> {{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF 
                            ({{ number_format($fundraising->progress_percentage, 1) }}%)
                        </p>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $fundraising->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $fundraising->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Options</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="show_donors" id="show_donors" value="1" {{ old('show_donors', $fundraising->show_donors) ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500">
                            <label for="show_donors" class="ml-2 text-sm text-gray-700">
                                Afficher la liste des donateurs publiquement
                            </label>
                        </div>
                        <p class="text-sm text-gray-500">Si coché, les noms des donateurs seront visibles sur la page de la collecte</p>
                    </div>
                </div>

                <!-- Événement associé (optionnel) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Événement associé (optionnel)</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lier à un événement</label>
                        <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <option value="">Aucun événement</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $fundraising->event_id) == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} ({{ $event->start_date->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez associer cette collecte à un événement existant</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('organizer.fundraisings.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Statistiques -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-sm text-gray-600 mb-1">Montant collecté</div>
                <div class="text-2xl font-bold text-green-600">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</div>
            </div>
            <div>
                <div class="text-sm text-gray-600 mb-1">Objectif</div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</div>
            </div>
            <div>
                <div class="text-sm text-gray-600 mb-1">Nombre de dons</div>
                <div class="text-2xl font-bold text-purple-600">{{ $fundraising->donations()->count() }}</div>
            </div>
        </div>
    </div>
</div>
@endsection

