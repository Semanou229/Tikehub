@extends('layouts.dashboard')

@section('title', 'Modifier un Événement')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'Événement</h1>
        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="{{ old('title', $event->title) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Concert de Musique Live">
                            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Décrivez votre événement...">{{ old('description', $event->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                            <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une catégorie</option>
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

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            @if($event->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($event->cover_image) }}" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name', $event->venue_name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Stade de l'Amitié">
                            @error('venue_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <input type="text" name="venue_address" id="venue_address" value="{{ old('venue_address', $event->venue_address) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Rue 123, Quartier...">
                            @error('venue_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" id="venue_city" value="{{ old('venue_city', $event->venue_city) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Cotonou">
                                @error('venue_city')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="venue_country" id="venue_country" value="{{ old('venue_country', $event->venue_country) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Bénin">
                                @error('venue_country')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <!-- Carte OpenStreetMap -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Localisation sur la carte *</label>
                            <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <p class="text-sm text-gray-500 mt-2">Cliquez sur la carte pour définir ou modifier l'emplacement exact</p>
                            <input type="hidden" name="venue_latitude" id="venue_latitude" value="{{ old('venue_latitude', $event->venue_latitude) }}" required>
                            <input type="hidden" name="venue_longitude" id="venue_longitude" value="{{ old('venue_longitude', $event->venue_longitude) }}" required>
                            @error('venue_latitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            @error('venue_longitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('organizer.events.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Actions supplémentaires -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="{{ route('organizer.ticket-types.index', $event) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
            <i class="fas fa-ticket-alt text-3xl text-indigo-600 mb-3"></i>
            <h3 class="font-semibold text-gray-900 mb-1">Types de billets</h3>
            <p class="text-sm text-gray-600">Gérer les types de billets</p>
        </a>

        <a href="{{ route('organizer.scans.index', $event) }}" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
            <i class="fas fa-qrcode text-3xl text-indigo-600 mb-3"></i>
            <h3 class="font-semibold text-gray-900 mb-1">Scans</h3>
            <p class="text-sm text-gray-600">Gérer les scans de billets</p>
        </a>

        @if(!$event->is_published)
            <form action="{{ route('events.publish', $event) }}" method="POST" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
                @csrf
                <button type="submit" class="w-full">
                    <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Publier</h3>
                    <p class="text-sm text-gray-600">Publier l'événement</p>
                </button>
            </form>
        @else
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                <h3 class="font-semibold text-gray-900 mb-1">Publié</h3>
                <p class="text-sm text-gray-600">L'événement est publié</p>
            </div>
        @endif
    </div>
</div>
@endsection

