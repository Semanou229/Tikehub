@extends('layouts.dashboard')

@section('title', 'Créer un Concours')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Concours</h1>
        <a href="{{ route('dashboard') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('contests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du concours *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Ex: Miss Bénin 2025">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Décrivez votre concours...">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Règles du concours</label>
                            <textarea name="rules" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Règles et conditions de participation...">{{ old('rules') }}</textarea>
                            @error('rules')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Paramètres de vote -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Paramètres de vote</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix par vote (XOF) *</label>
                            <input type="number" name="price_per_vote" value="{{ old('price_per_vote') }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="100">
                            @error('price_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points par vote *</label>
                            <input type="number" name="points_per_vote" value="{{ old('points_per_vote', 1) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="1">
                            @error('points_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Nombre de points attribués par vote</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Événement associé (optionnel) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Événement associé (optionnel)</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lier à un événement</label>
                        <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Aucun événement</option>
                            @foreach(\App\Models\Event::where('organizer_id', auth()->id())->get() as $event)
                                <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} ({{ $event->start_date->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez associer ce concours à un événement existant</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Créer le concours
                </button>
                <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">
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
                <p>Le concours sera créé en mode "Brouillon". Vous pourrez le publier une fois que vous aurez ajouté des candidats. Après publication, les utilisateurs pourront voter pour les candidats.</p>
            </div>
        </div>
    </div>
</div>
@endsection

