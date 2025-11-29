@extends('layouts.dashboard')

@section('title', 'Créer un Événement')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Événement</h1>
        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Concert de Musique Live">
                            @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Décrivez votre événement...">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                            <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Musique" {{ old('category') == 'Musique' ? 'selected' : '' }}>Musique</option>
                                <option value="Sport" {{ old('category') == 'Sport' ? 'selected' : '' }}>Sport</option>
                                <option value="Culture" {{ old('category') == 'Culture' ? 'selected' : '' }}>Culture</option>
                                <option value="Art" {{ old('category') == 'Art' ? 'selected' : '' }}>Art</option>
                                <option value="Business" {{ old('category') == 'Business' ? 'selected' : '' }}>Business</option>
                                <option value="Éducation" {{ old('category') == 'Éducation' ? 'selected' : '' }}>Éducation</option>
                                <option value="Santé" {{ old('category') == 'Santé' ? 'selected' : '' }}>Santé</option>
                                <option value="Technologie" {{ old('category') == 'Technologie' ? 'selected' : '' }}>Technologie</option>
                                <option value="Gastronomie" {{ old('category') == 'Gastronomie' ? 'selected' : '' }}>Gastronomie</option>
                                <option value="Divertissement" {{ old('category') == 'Divertissement' ? 'selected' : '' }}>Divertissement</option>
                                <option value="Famille" {{ old('category') == 'Famille' ? 'selected' : '' }}>Famille</option>
                                <option value="Mode" {{ old('category') == 'Mode' ? 'selected' : '' }}>Mode</option>
                                <option value="Autre" {{ old('category') == 'Autre' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('category')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
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
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" name="venue_name" id="venue_name" value="{{ old('venue_name') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Stade de l'Amitié">
                            @error('venue_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <div class="flex gap-2">
                                <input type="text" name="venue_address" id="venue_address" value="{{ old('venue_address') }}" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Rue 123, Quartier...">
                                <button type="button" id="geocodeBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-search-location"></i> Localiser
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Saisissez l'adresse et cliquez sur "Localiser" pour afficher sur la carte</p>
                            @error('venue_address')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" id="venue_city" value="{{ old('venue_city') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Cotonou">
                                @error('venue_city')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="venue_country" id="venue_country" value="{{ old('venue_country') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Bénin">
                                @error('venue_country')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <!-- Carte OpenStreetMap -->
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-medium text-gray-700">Localisation sur la carte</label>
                                <button type="button" id="geolocateBtn" class="px-3 py-1.5 text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 transition flex items-center gap-2">
                                    <i class="fas fa-crosshairs"></i> Ma localisation
                                </button>
                            </div>
                            <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <p class="text-sm text-gray-500 mt-2">Saisissez une adresse et cliquez sur "Localiser", utilisez "Ma localisation", ou cliquez directement sur la carte</p>
                            <input type="hidden" name="venue_latitude" id="venue_latitude" value="{{ old('venue_latitude') }}">
                            <input type="hidden" name="venue_longitude" id="venue_longitude" value="{{ old('venue_longitude') }}">
                            @error('venue_latitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            @error('venue_longitude')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Créer l'événement
                </button>
                <a href="{{ route('organizer.events.index') }}" class="text-gray-600 hover:text-gray-800">
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
                <p>L'événement sera créé en mode "Brouillon". Après création, vous pourrez ajouter des types de billets et publier l'événement.</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { z-index: 0; }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Initialiser la carte OpenStreetMap
    let map = L.map('map').setView([6.4969, 2.6283], 13); // Cotonou par défaut
    
    // Ajouter la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    let marker = null;
    
    // Gérer le clic sur la carte
    map.on('click', function(e) {
        const lat = e.latlng.lat;
        const lng = e.latlng.lng;
        
        // Mettre à jour les champs cachés
        document.getElementById('venue_latitude').value = lat;
        document.getElementById('venue_longitude').value = lng;
        
        // Supprimer l'ancien marqueur s'il existe
        if (marker) {
            map.removeLayer(marker);
        }
        
        // Ajouter un nouveau marqueur
        marker = L.marker([lat, lng]).addTo(map);
        
        // Faire un reverse geocoding pour remplir l'adresse
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(response => response.json())
            .then(data => {
                if (data.address) {
                    if (data.address.road && !document.getElementById('venue_address').value) {
                        document.getElementById('venue_address').value = data.address.road;
                    }
                    if (data.address.city && !document.getElementById('venue_city').value) {
                        document.getElementById('venue_city').value = data.address.city;
                    } else if (data.address.town && !document.getElementById('venue_city').value) {
                        document.getElementById('venue_city').value = data.address.town;
                    }
                    if (data.address.country && !document.getElementById('venue_country').value) {
                        document.getElementById('venue_country').value = data.address.country;
                    }
                }
            })
            .catch(err => console.error('Erreur de géocodage:', err));
    });
    
    // Si des coordonnées existent déjà (en cas d'erreur de validation)
    const existingLat = document.getElementById('venue_latitude').value;
    const existingLng = document.getElementById('venue_longitude').value;
    if (existingLat && existingLng) {
        map.setView([existingLat, existingLng], 13);
        marker = L.marker([existingLat, existingLng]).addTo(map);
    }

    // Géolocalisation automatique
    document.getElementById('geolocateBtn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
        
        if (!navigator.geolocation) {
            alert('La géolocalisation n\'est pas supportée par votre navigateur.');
            btn.disabled = false;
            btn.innerHTML = originalText;
            return;
        }
        
        // Options de géolocalisation plus permissives
        const options = {
            enableHighAccuracy: false, // Désactiver pour éviter les erreurs
            timeout: 15000, // Augmenter le timeout à 15 secondes
            maximumAge: 60000 // Accepter une position jusqu'à 1 minute
        };
        
        navigator.geolocation.getCurrentPosition(
            function(position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                
                console.log('Position détectée:', lat, lng);
                
                // Mettre à jour les champs cachés
                document.getElementById('venue_latitude').value = lat;
                document.getElementById('venue_longitude').value = lng;
                
                // Centrer la carte sur la position
                map.setView([lat, lng], 15);
                
                // Supprimer l'ancien marqueur
                if (marker) {
                    map.removeLayer(marker);
                }
                
                // Ajouter un nouveau marqueur
                marker = L.marker([lat, lng]).addTo(map);
                
                // Faire un reverse géocodage pour remplir l'adresse
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1&zoom=18`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur HTTP: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Données de reverse géocodage:', data);
                        
                        if (data && data.address) {
                            const address = data.address;
                            
                            // Construire l'adresse complète
                            let fullAddress = '';
                            if (address.house_number) {
                                fullAddress += address.house_number + ' ';
                            }
                            if (address.road) {
                                fullAddress += address.road;
                            } else if (address.pedestrian) {
                                fullAddress += address.pedestrian;
                            } else if (address.path) {
                                fullAddress += address.path;
                            }
                            
                            // Remplir l'adresse
                            if (fullAddress.trim() && !document.getElementById('venue_address').value) {
                                document.getElementById('venue_address').value = fullAddress.trim();
                            } else if (address.road && !document.getElementById('venue_address').value) {
                                document.getElementById('venue_address').value = address.road;
                            }
                            
                            // Remplir la ville (priorité: city > town > village > municipality)
                            if (!document.getElementById('venue_city').value) {
                                if (address.city) {
                                    document.getElementById('venue_city').value = address.city;
                                } else if (address.town) {
                                    document.getElementById('venue_city').value = address.town;
                                } else if (address.village) {
                                    document.getElementById('venue_city').value = address.village;
                                } else if (address.municipality) {
                                    document.getElementById('venue_city').value = address.municipality;
                                } else if (address.county) {
                                    document.getElementById('venue_city').value = address.county;
                                }
                            }
                            
                            // Remplir le pays
                            if (!document.getElementById('venue_country').value && address.country) {
                                document.getElementById('venue_country').value = address.country;
                            }
                            
                            // Remplir le nom du lieu si disponible
                            if (!document.getElementById('venue_name').value) {
                                if (address.building) {
                                    document.getElementById('venue_name').value = address.building;
                                } else if (address.amenity) {
                                    document.getElementById('venue_name').value = address.amenity;
                                } else if (address.leisure) {
                                    document.getElementById('venue_name').value = address.leisure;
                                }
                            }
                            
                            // Afficher un message de succès
                            const successMsg = document.createElement('div');
                            successMsg.className = 'mt-2 p-2 bg-green-100 text-green-800 rounded text-sm';
                            successMsg.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Localisation détectée et informations remplies automatiquement';
                            btn.parentElement.parentElement.appendChild(successMsg);
                            setTimeout(() => successMsg.remove(), 5000);
                        } else {
                            console.warn('Aucune adresse trouvée dans les données de géocodage');
                        }
                        
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                    })
                    .catch(error => {
                        console.error('Erreur de reverse géocodage:', error);
                        btn.disabled = false;
                        btn.innerHTML = originalText;
                        
                        // Afficher un avertissement mais garder les coordonnées
                        const warningMsg = document.createElement('div');
                        warningMsg.className = 'mt-2 p-2 bg-yellow-100 text-yellow-800 rounded text-sm';
                        warningMsg.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Position détectée mais impossible de récupérer l\'adresse. Vous pouvez la saisir manuellement.';
                        btn.parentElement.parentElement.appendChild(warningMsg);
                        setTimeout(() => warningMsg.remove(), 5000);
                    });
            },
            function(error) {
                console.error('Erreur de géolocalisation complète:', error);
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                let errorMessage = '';
                let errorCode = error ? error.code : 'UNKNOWN';
                
                // Gérer les différents codes d'erreur
                if (errorCode === 1 || errorCode === error.PERMISSION_DENIED) {
                    errorMessage = 'Permission refusée. Veuillez autoriser l\'accès à votre localisation dans les paramètres de votre navigateur.\n\nPour autoriser :\n1. Cliquez sur l\'icône de cadenas dans la barre d\'adresse\n2. Activez l\'autorisation pour la localisation\n3. Rechargez la page et réessayez';
                } else if (errorCode === 2 || errorCode === error.POSITION_UNAVAILABLE) {
                    errorMessage = 'Position indisponible. Vérifiez que votre GPS est activé et que vous avez une connexion Internet.';
                } else if (errorCode === 3 || errorCode === error.TIMEOUT) {
                    errorMessage = 'Délai d\'attente dépassé. Veuillez réessayer.';
                } else {
                    // Si l'erreur est un objet, essayer d'extraire le message
                    let errorDetails = '';
                    if (error && error.message) {
                        errorDetails = error.message;
                    } else if (error && typeof error === 'object') {
                        errorDetails = JSON.stringify(error);
                    } else {
                        errorDetails = String(error);
                    }
                    errorMessage = 'Erreur lors de la géolocalisation.\n\nDétails: ' + errorDetails + '\n\nVous pouvez utiliser le bouton "Localiser" avec une adresse à la place.';
                }
                
                alert(errorMessage);
            },
            options
            );
        }
    });

    // Géocodage automatique de l'adresse
    document.getElementById('geocodeBtn').addEventListener('click', function() {
        const address = document.getElementById('venue_address').value;
        const city = document.getElementById('venue_city').value;
        const country = document.getElementById('venue_country').value;
        
        if (!address) {
            alert('Veuillez saisir une adresse');
            return;
        }
        
        // Construire l'adresse complète
        let fullAddress = address;
        if (city) fullAddress += ', ' + city;
        if (country) fullAddress += ', ' + country;
        
        // Afficher un indicateur de chargement
        const btn = this;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Recherche...';
        
        // Appel à l'API Nominatim
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(fullAddress)}&limit=1`)
            .then(response => response.json())
            .then(data => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                if (data && data.length > 0) {
                    const lat = parseFloat(data[0].lat);
                    const lng = parseFloat(data[0].lon);
                    
                    // Mettre à jour les champs cachés
                    document.getElementById('venue_latitude').value = lat;
                    document.getElementById('venue_longitude').value = lng;
                    
                    // Centrer la carte sur la nouvelle position
                    map.setView([lat, lng], 15);
                    
                    // Supprimer l'ancien marqueur
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    
                    // Ajouter un nouveau marqueur
                    marker = L.marker([lat, lng]).addTo(map);
                    
                    // Compléter les champs manquants si disponibles
                    if (data[0].address) {
                        if (!city && data[0].address.city) {
                            document.getElementById('venue_city').value = data[0].address.city;
                        } else if (!city && data[0].address.town) {
                            document.getElementById('venue_city').value = data[0].address.town;
                        }
                        if (!country && data[0].address.country) {
                            document.getElementById('venue_country').value = data[0].address.country;
                        }
                    }
                } else {
                    alert('Adresse non trouvée. Veuillez cliquer directement sur la carte pour définir l\'emplacement.');
                }
            })
            .catch(error => {
                btn.disabled = false;
                btn.innerHTML = originalText;
                console.error('Erreur de géocodage:', error);
                alert('Erreur lors de la recherche de l\'adresse. Veuillez cliquer directement sur la carte.');
            });
    });
</script>
@endpush
@endsection

