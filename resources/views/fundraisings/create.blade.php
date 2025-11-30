@extends('layouts.dashboard')

@section('title', 'Créer une Collecte de Fonds')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Créer une Collecte de Fonds</h1>
        <a href="{{ route('dashboard') }}" class="text-green-600 hover:text-green-800 active:text-green-900 min-h-[44px] flex items-center justify-center sm:justify-start">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="{{ route('fundraisings.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la collecte *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Aide aux Victimes des Inondations">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="6" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm sm:text-base min-h-[144px]" placeholder="Décrivez votre collecte de fonds, son objectif et son importance...">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Objectif financier -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Objectif financier</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Montant objectif (XOF) *</label>
                        <input type="number" name="goal_amount" value="{{ old('goal_amount') }}" min="0" step="0.01" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm sm:text-base min-h-[44px]" placeholder="1000000">
                        @error('goal_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Montant total que vous souhaitez collecter</p>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm sm:text-base min-h-[44px]">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm sm:text-base min-h-[44px]">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Options -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Options</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="show_donors" id="show_donors" value="1" {{ old('show_donors') ? 'checked' : '' }} class="rounded border-gray-300 text-green-600 focus:ring-green-500">
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
                            @foreach(\App\Models\Event::where('organizer_id', auth()->id())->get() as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} ({{ $event->start_date->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez associer cette collecte à un événement existant</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4">
                <button type="submit" class="bg-green-600 text-white px-6 sm:px-8 py-3 rounded-lg hover:bg-green-700 active:bg-green-800 transition font-semibold text-sm sm:text-base min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i>Créer la collecte
                </button>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800 active:text-gray-900 text-center sm:text-left py-3 sm:py-0 min-h-[44px] flex items-center justify-center sm:justify-start">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Note importante -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Note importante :</p>
                <p>La collecte sera créée en mode "Brouillon". Vous pourrez la publier une fois que vous serez prêt. Après publication, les utilisateurs pourront faire des dons. Vous pourrez également ajouter des paliers (milestones) pour suivre la progression de la collecte.</p>
            </div>
        </div>
    </div>
</div>
@endsection


