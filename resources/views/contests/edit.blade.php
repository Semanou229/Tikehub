@extends('layouts.dashboard')

@section('title', 'Modifier un Concours')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier le Concours</h1>
        <a href="{{ route('organizer.contests.index') }}" class="text-purple-600 hover:text-purple-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('contests.update', $contest) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du concours *</label>
                            <input type="text" name="name" value="{{ old('name', $contest->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Ex: Miss Bénin 2025">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Décrivez votre concours...">{{ old('description', $contest->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Règles du concours</label>
                            <textarea name="rules" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Règles et conditions de participation...">{{ old('rules', $contest->rules) }}</textarea>
                            @error('rules')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            @if($contest->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($contest->cover_image) }}" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
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
                            <input type="number" name="price_per_vote" value="{{ old('price_per_vote', $contest->price_per_vote) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="100">
                            @error('price_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points par vote *</label>
                            <input type="number" name="points_per_vote" value="{{ old('points_per_vote', $contest->points_per_vote) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="1">
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
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $contest->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $contest->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
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
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $contest->event_id) == $event->id ? 'selected' : '' }}>
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
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('organizer.contests.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Section candidats -->
    <div class="mt-6 bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">Candidats ({{ $contest->candidates->count() }})</h2>
            <a href="{{ route('contests.show', $contest) }}" class="text-purple-600 hover:text-purple-800 text-sm">
                <i class="fas fa-eye mr-1"></i>Voir les candidats
            </a>
        </div>
        @if($contest->candidates->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($contest->candidates as $candidate)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-semibold text-purple-600">#{{ $candidate->number }}</span>
                            <span class="text-xs text-gray-500">{{ $candidate->votes()->sum('points') }} points</span>
                        </div>
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $candidate->name }}</h3>
                        @if($candidate->description)
                            <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($candidate->description, 60) }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-sm">Aucun candidat ajouté. Vous pouvez les ajouter depuis la page de détail du concours.</p>
        @endif
    </div>
</div>
@endsection

