@extends('layouts.admin')

@section('title', 'Modifier l\'Événement')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'Événement</h1>
        <a href="{{ route('admin.events.show', $event) }}" class="text-red-600 hover:text-red-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur *</label>
                    <select name="organizer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        @foreach($organizers as $organizer)
                            <option value="{{ $organizer->id }}" {{ $event->organizer_id == $organizer->id ? 'selected' : '' }}>
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('description', $event->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                            <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="Musique" {{ old('category', $event->category) == 'Musique' ? 'selected' : '' }}>Musique</option>
                                <option value="Sport" {{ old('category', $event->category) == 'Sport' ? 'selected' : '' }}>Sport</option>
                                <option value="Culture" {{ old('category', $event->category) == 'Culture' ? 'selected' : '' }}>Culture</option>
                                <option value="Art" {{ old('category', $event->category) == 'Art' ? 'selected' : '' }}>Art</option>
                                <option value="Business" {{ old('category', $event->category) == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Éducation" {{ old('category', $event->category) == 'Éducation' ? 'selected' : '' }}>Éducation</option>
                                <option value="Santé" {{ old('category', $event->category) == 'Santé' ? 'selected' : '' }}>Santé</option>
                                <option value="Technologie" {{ old('category', $event->category) == 'Technologie' ? 'selected' : '' }}>Technologie</option>
                                <option value="Gastronomie" {{ old('category', $event->category) == 'Gastronomie' ? 'selected' : '' }}>Gastronomie</option>
                                <option value="Divertissement" {{ old('category', $event->category) == 'Divertissement' ? 'selected' : '' }}>Divertissement</option>
                                <option value="Famille" {{ old('category', $event->category) == 'Famille' ? 'selected' : '' }}>Famille</option>
                                <option value="Mode" {{ old('category', $event->category) == 'Mode' ? 'selected' : '' }}>Mode</option>
                                <option value="Autre" {{ old('category', $event->category) == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Lieu -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Lieu</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du lieu</label>
                            <input type="text" name="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <input type="text" name="venue_address" value="{{ old('venue_address', $event->venue_address) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" value="{{ old('venue_city', $event->venue_city) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="venue_country" value="{{ old('venue_country', $event->venue_country) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                <input type="number" step="any" name="venue_latitude" value="{{ old('venue_latitude', $event->venue_latitude) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                <input type="number" step="any" name="venue_longitude" value="{{ old('venue_longitude', $event->venue_longitude) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image et statut -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Image et statut</h2>
                    <div class="space-y-4">
                        @if($event->cover_image)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                                <img src="{{ asset('storage/' . $event->cover_image) }}" alt="Cover" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouvelle image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $event->is_published) ? 'checked' : '' }} class="mr-2">
                                <span class="text-sm text-gray-700">Publier</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Publié</option>
                                <option value="cancelled" {{ old('status', $event->status) == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('admin.events.show', $event) }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Annuler
                    </a>
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

