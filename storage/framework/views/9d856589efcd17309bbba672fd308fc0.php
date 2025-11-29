

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
                            <input type="text" name="venue_address" id="venue_address" value="<?php echo e(old('venue_address', $event->venue_address)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: Rue 123, Quartier...">
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
                            <label class="block text-sm font-medium text-gray-700 mb-2">Localisation sur la carte *</label>
                            <div id="map" class="w-full h-64 rounded-lg border border-gray-300"></div>
                            <p class="text-sm text-gray-500 mt-2">Cliquez sur la carte pour définir ou modifier l'emplacement exact</p>
                            <input type="hidden" name="venue_latitude" id="venue_latitude" value="<?php echo e(old('venue_latitude', $event->venue_latitude)); ?>" required>
                            <input type="hidden" name="venue_longitude" id="venue_longitude" value="<?php echo e(old('venue_longitude', $event->venue_longitude)); ?>" required>
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
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/edit.blade.php ENDPATH**/ ?>