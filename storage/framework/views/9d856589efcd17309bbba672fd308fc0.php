<?php $__env->startSection('title', 'Modifier un Événement'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'Événement</h1>
        <a href="<?php echo e(route('organizer.events.index')); ?>" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="<?php echo e(route('events.update', $event)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="<?php echo e(old('title', $event->title)); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Concert de Musique Live">
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Décrivez votre événement..."><?php echo e(old('description', $event->description)); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                            <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Musique" <?php echo e(old('category', $event->category) == 'Musique' ? 'selected' : ''); ?>>Musique</option>
                                <option value="Sport" <?php echo e(old('category', $event->category) == 'Sport' ? 'selected' : ''); ?>>Sport</option>
                                <option value="Culture" <?php echo e(old('category', $event->category) == 'Culture' ? 'selected' : ''); ?>>Culture</option>
                                <option value="Art" <?php echo e(old('category', $event->category) == 'Art' ? 'selected' : ''); ?>>Art</option>
                                <option value="Business" <?php echo e(old('category', $event->category) == 'Business' ? 'selected' : ''); ?>>Business</option>
                                <option value="Éducation" <?php echo e(old('category', $event->category) == 'Éducation' ? 'selected' : ''); ?>>Éducation</option>
                                <option value="Santé" <?php echo e(old('category', $event->category) == 'Santé' ? 'selected' : ''); ?>>Santé</option>
                                <option value="Technologie" <?php echo e(old('category', $event->category) == 'Technologie' ? 'selected' : ''); ?>>Technologie</option>
                                <option value="Gastronomie" <?php echo e(old('category', $event->category) == 'Gastronomie' ? 'selected' : ''); ?>>Gastronomie</option>
                                <option value="Divertissement" <?php echo e(old('category', $event->category) == 'Divertissement' ? 'selected' : ''); ?>>Divertissement</option>
                                <option value="Famille" <?php echo e(old('category', $event->category) == 'Famille' ? 'selected' : ''); ?>>Famille</option>
                                <option value="Mode" <?php echo e(old('category', $event->category) == 'Mode' ? 'selected' : ''); ?>>Mode</option>
                                <option value="Autre" <?php echo e(old('category', $event->category) == 'Autre' ? 'selected' : ''); ?>>Autre</option>
                            </select>
                            <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            <?php if($event->cover_image): ?>
                                <div class="mb-2">
                                    <img src="<?php echo e(Storage::url($event->cover_image)); ?>" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            <?php endif; ?>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                            <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date', $event->start_date->format('Y-m-d\TH:i'))); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date', $event->end_date->format('Y-m-d\TH:i'))); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Lieu -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Lieu</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du lieu</label>
                            <input type="text" name="venue_name" id="venue_name" value="<?php echo e(old('venue_name', $event->venue_name)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Stade de l'Amitié">
                            <?php $__errorArgs = ['venue_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <div class="flex gap-2">
                                <input type="text" name="venue_address" id="venue_address" value="<?php echo e(old('venue_address', $event->venue_address)); ?>" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Rue 123, Quartier...">
                                <button type="button" id="geocodeBtn" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                                    <i class="fas fa-search-location"></i> Localiser
                                </button>
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Saisissez l'adresse et cliquez sur "Localiser" pour afficher sur la carte</p>
                            <?php $__errorArgs = ['venue_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" id="venue_city" value="<?php echo e(old('venue_city', $event->venue_city)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Cotonou">
                                <?php $__errorArgs = ['venue_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="venue_country" id="venue_country" value="<?php echo e(old('venue_country', $event->venue_country)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Bénin">
                                <?php $__errorArgs = ['venue_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                            <input type="hidden" name="venue_latitude" id="venue_latitude" value="<?php echo e(old('venue_latitude', $event->venue_latitude)); ?>">
                            <input type="hidden" name="venue_longitude" id="venue_longitude" value="<?php echo e(old('venue_longitude', $event->venue_longitude)); ?>">
                            <?php $__errorArgs = ['venue_latitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php $__errorArgs = ['venue_longitude'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="<?php echo e(route('organizer.events.index')); ?>" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Actions supplémentaires -->
    <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <a href="<?php echo e(route('organizer.ticket-types.index', $event)); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
            <i class="fas fa-ticket-alt text-3xl text-indigo-600 mb-3"></i>
            <h3 class="font-semibold text-gray-900 mb-1">Types de billets</h3>
            <p class="text-sm text-gray-600">Gérer les types de billets</p>
        </a>

        <a href="<?php echo e(route('organizer.scans.index', $event)); ?>" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
            <i class="fas fa-qrcode text-3xl text-indigo-600 mb-3"></i>
            <h3 class="font-semibold text-gray-900 mb-1">Scans</h3>
            <p class="text-sm text-gray-600">Gérer les scans de billets</p>
        </a>

        <?php if(!$event->is_published): ?>
            <form action="<?php echo e(route('events.publish', $event)); ?>" method="POST" class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition text-center">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full">
                    <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                    <h3 class="font-semibold text-gray-900 mb-1">Publier</h3>
                    <p class="text-sm text-gray-600">Publier l'événement</p>
                </button>
            </form>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <i class="fas fa-check-circle text-3xl text-green-600 mb-3"></i>
                <h3 class="font-semibold text-gray-900 mb-1">Publié</h3>
                <p class="text-sm text-gray-600">L'événement est publié</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map { z-index: 0; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    // Coordonnées par défaut (Cotonou) ou coordonnées existantes
    const defaultLat = <?php echo e(old('venue_latitude', $event->venue_latitude ?? 6.4969)); ?>;
    const defaultLng = <?php echo e(old('venue_longitude', $event->venue_longitude ?? 2.6283)); ?>;
    
    // Initialiser la carte OpenStreetMap
    let map = L.map('map').setView([defaultLat, defaultLng], 13);
    
    // Ajouter la couche de tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
    
    let marker = null;
    
    // Si des coordonnées existent, ajouter un marqueur
    if (defaultLat && defaultLng) {
        marker = L.marker([defaultLat, defaultLng]).addTo(map);
    }
    
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

    // Géolocalisation automatique
    document.getElementById('geolocateBtn').addEventListener('click', function() {
        const btn = this;
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Localisation...';
        
        // Vérifier si la géolocalisation est disponible
        if (!navigator.geolocation) {
            alert('La géolocalisation n\'est pas supportée par votre navigateur. Veuillez utiliser le bouton "Localiser" avec une adresse.');
            btn.disabled = false;
            btn.innerHTML = originalText;
            return;
        }
        
        // Vérifier les permissions avant de demander la position
        if (navigator.permissions) {
            navigator.permissions.query({name: 'geolocation'}).then(function(result) {
                if (result.state === 'denied') {
                    alert('L\'accès à la localisation est refusé. Veuillez autoriser l\'accès dans les paramètres de votre navigateur.');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    return;
                }
                requestGeolocation();
            }).catch(function() {
                // Si query() échoue, continuer quand même
                requestGeolocation();
            });
        } else {
            // Si permissions API n'est pas disponible, continuer directement
            requestGeolocation();
        }
        
        function requestGeolocation() {
            // Options de géolocalisation plus permissives
            const options = {
                enableHighAccuracy: false, // Désactiver pour éviter les erreurs
                timeout: 20000, // Augmenter le timeout à 20 secondes
                maximumAge: 300000 // Accepter une position jusqu'à 5 minutes
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
                        console.log('Données de reverse géocodage complètes:', data);
                        console.log('Adresse extraite:', data.address);
                        
                        if (data && data.address) {
                            const address = data.address;
                            
                            // Construire l'adresse complète (REMPLACER au lieu de seulement remplir si vide)
                            let fullAddress = '';
                            
                            // Essayer plusieurs champs pour construire l'adresse
                            if (address.house_number) {
                                fullAddress += address.house_number + ' ';
                            }
                            
                            // Priorité: road > pedestrian > path > street > residential > neighbourhood
                            if (address.road) {
                                fullAddress += address.road;
                            } else if (address.pedestrian) {
                                fullAddress += address.pedestrian;
                            } else if (address.path) {
                                fullAddress += address.path;
                            } else if (address.street) {
                                fullAddress += address.street;
                            } else if (address.residential) {
                                fullAddress += address.residential;
                            } else if (address.neighbourhood) {
                                fullAddress += address.neighbourhood;
                            } else if (address.suburb) {
                                fullAddress += address.suburb;
                            } else if (address.quarter) {
                                fullAddress += address.quarter;
                            }
                            
                            // REMPLACER l'adresse (pas seulement si vide)
                            const addressField = document.getElementById('venue_address');
                            
                            if (fullAddress.trim()) {
                                addressField.value = fullAddress.trim();
                                console.log('Adresse remplie (construite):', fullAddress.trim());
                            } else if (data.display_name) {
                                // Utiliser le nom d'affichage complet comme fallback
                                // Extraire la première partie (généralement l'adresse)
                                const displayParts = data.display_name.split(',');
                                // Prendre les 2-3 premières parties (adresse + quartier)
                                let extractedAddress = displayParts.slice(0, 2).join(', ').trim();
                                // Si c'est trop long, prendre seulement la première partie
                                if (extractedAddress.length > 100) {
                                    extractedAddress = displayParts[0].trim();
                                }
                                addressField.value = extractedAddress;
                                console.log('Adresse remplie (display_name):', extractedAddress);
                            } else {
                                // Dernier recours : utiliser tous les champs disponibles
                                const fallbackParts = [];
                                if (address.house_number) fallbackParts.push(address.house_number);
                                if (address.road) fallbackParts.push(address.road);
                                if (address.neighbourhood) fallbackParts.push(address.neighbourhood);
                                if (address.suburb) fallbackParts.push(address.suburb);
                                if (fallbackParts.length > 0) {
                                    addressField.value = fallbackParts.join(', ');
                                    console.log('Adresse remplie (fallback):', fallbackParts.join(', '));
                                } else {
                                    console.warn('Impossible de trouver une adresse dans les données');
                                }
                            }
                            
                            // REMPLACER la ville (priorité: city > town > village > municipality)
                            const cityField = document.getElementById('venue_city');
                            if (address.city) {
                                cityField.value = address.city;
                                console.log('Ville remplie (city):', address.city);
                            } else if (address.town) {
                                cityField.value = address.town;
                                console.log('Ville remplie (town):', address.town);
                            } else if (address.village) {
                                cityField.value = address.village;
                                console.log('Ville remplie (village):', address.village);
                            } else if (address.municipality) {
                                cityField.value = address.municipality;
                                console.log('Ville remplie (municipality):', address.municipality);
                            } else if (address.county) {
                                cityField.value = address.county;
                                console.log('Ville remplie (county):', address.county);
                            }
                            
                            // REMPLACER le pays
                            const countryField = document.getElementById('venue_country');
                            if (address.country) {
                                countryField.value = address.country;
                                console.log('Pays rempli:', address.country);
                            }
                            
                            // REMPLACER le nom du lieu si disponible (mais seulement si vide pour ne pas écraser un nom personnalisé)
                            const nameField = document.getElementById('venue_name');
                            if (!nameField.value || nameField.value.trim() === '') {
                                if (address.building) {
                                    nameField.value = address.building;
                                    console.log('Nom du lieu rempli (building):', address.building);
                                } else if (address.amenity) {
                                    nameField.value = address.amenity;
                                    console.log('Nom du lieu rempli (amenity):', address.amenity);
                                } else if (address.leisure) {
                                    nameField.value = address.leisure;
                                    console.log('Nom du lieu rempli (leisure):', address.leisure);
                                }
                            }
                            
                            // Afficher un message de succès
                            const successMsg = document.createElement('div');
                            successMsg.className = 'mt-2 p-2 bg-green-100 text-green-800 rounded text-sm';
                            successMsg.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Localisation détectée et informations remplies automatiquement';
                            const mapContainer = btn.parentElement.parentElement;
                            // Supprimer les anciens messages
                            const oldMsgs = mapContainer.querySelectorAll('.bg-green-100, .bg-yellow-100, .bg-red-100');
                            oldMsgs.forEach(msg => msg.remove());
                            mapContainer.appendChild(successMsg);
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
                console.error('Type d\'erreur:', typeof error);
                console.error('Code d\'erreur:', error ? error.code : 'undefined');
                console.error('Message d\'erreur:', error ? error.message : 'undefined');
                
                btn.disabled = false;
                btn.innerHTML = originalText;
                
                let errorMessage = '';
                let errorCode = null;
                
                // Extraire le code d'erreur de différentes façons
                if (error) {
                    if (typeof error.code !== 'undefined') {
                        errorCode = error.code;
                    } else if (typeof error === 'number') {
                        errorCode = error;
                    } else if (error.PERMISSION_DENIED !== undefined && error.code === error.PERMISSION_DENIED) {
                        errorCode = 1;
                    } else if (error.POSITION_UNAVAILABLE !== undefined && error.code === error.POSITION_UNAVAILABLE) {
                        errorCode = 2;
                    } else if (error.TIMEOUT !== undefined && error.code === error.TIMEOUT) {
                        errorCode = 3;
                    }
                }
                
                // Gérer les différents codes d'erreur
                if (errorCode === 1 || (error && error.PERMISSION_DENIED && error.code === error.PERMISSION_DENIED)) {
                    errorMessage = 'Permission refusée pour la géolocalisation.\n\n' +
                        'Pour autoriser :\n' +
                        '1. Cliquez sur l\'icône de cadenas (🔒) dans la barre d\'adresse\n' +
                        '2. Trouvez "Localisation" dans la liste\n' +
                        '3. Sélectionnez "Autoriser" ou "Demander"\n' +
                        '4. Rechargez la page et réessayez\n\n' +
                        'Alternative : Utilisez le bouton "Localiser" avec une adresse.';
                } else if (errorCode === 2 || (error && error.POSITION_UNAVAILABLE && error.code === error.POSITION_UNAVAILABLE)) {
                    errorMessage = 'Position indisponible.\n\n' +
                        'Vérifiez que :\n' +
                        '- Votre GPS est activé\n' +
                        '- Vous avez une connexion Internet\n' +
                        '- Vous n\'êtes pas dans un endroit sans signal\n\n' +
                        'Alternative : Utilisez le bouton "Localiser" avec une adresse.';
                } else if (errorCode === 3 || (error && error.TIMEOUT && error.code === error.TIMEOUT)) {
                    errorMessage = 'Délai d\'attente dépassé.\n\n' +
                        'La géolocalisation prend trop de temps. Veuillez réessayer ou utiliser le bouton "Localiser" avec une adresse.';
                } else {
                    // Erreur inconnue - extraire le maximum d'informations
                    let errorDetails = 'Erreur inconnue';
                    
                    if (error) {
                        if (error.message) {
                            errorDetails = error.message;
                        } else if (error.toString && error.toString() !== '[object Object]') {
                            errorDetails = error.toString();
                        } else {
                            // Essayer d'extraire des propriétés utiles
                            const props = [];
                            for (let key in error) {
                                if (error.hasOwnProperty(key)) {
                                    props.push(key + ': ' + error[key]);
                                }
                            }
                            if (props.length > 0) {
                                errorDetails = props.join(', ');
                            }
                        }
                    }
                    
                    errorMessage = 'Erreur lors de la géolocalisation.\n\n' +
                        'Détails : ' + errorDetails + '\n\n' +
                        'Causes possibles :\n' +
                        '- Extension de navigateur qui bloque la géolocalisation\n' +
                        '- Paramètres de sécurité du navigateur\n' +
                        '- Problème de connexion\n\n' +
                        'Solution : Utilisez le bouton "Localiser" avec une adresse à la place.';
                }
                
                // Afficher l'erreur dans une alerte et dans la console
                alert(errorMessage);
                
                // Afficher aussi un message visuel sur la page
                const errorMsg = document.createElement('div');
                errorMsg.className = 'mt-2 p-3 bg-red-100 text-red-800 rounded text-sm border border-red-300';
                errorMsg.innerHTML = '<i class="fas fa-exclamation-circle mr-2"></i><strong>Géolocalisation échouée :</strong> ' + 
                    errorMessage.replace(/\n/g, '<br>').substring(0, 200) + 
                    '<br><span class="text-xs mt-1 block">Vous pouvez utiliser le bouton "Localiser" avec une adresse.</span>';
                btn.parentElement.parentElement.appendChild(errorMsg);
                setTimeout(() => errorMsg.remove(), 10000);
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/edit.blade.php ENDPATH**/ ?>