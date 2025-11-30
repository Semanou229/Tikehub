<?php $__env->startSection('title', 'Créer un Événement'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Créer un Événement</h1>
        <a href="<?php echo e(route('organizer.events.index')); ?>" class="text-indigo-600 hover:text-indigo-800 active:text-indigo-900 min-h-[44px] flex items-center justify-center sm:justify-start">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
        <form action="<?php echo e(route('events.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="<?php echo e(old('title')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Concert de Musique Live">
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
                            <textarea name="description" rows="5" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[120px]" placeholder="Décrivez votre événement..."><?php echo e(old('description')); ?></textarea>
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
                            <select name="category" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]">
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Musique" <?php echo e(old('category') == 'Musique' ? 'selected' : ''); ?>>Musique</option>
                                <option value="Sport" <?php echo e(old('category') == 'Sport' ? 'selected' : ''); ?>>Sport</option>
                                <option value="Culture" <?php echo e(old('category') == 'Culture' ? 'selected' : ''); ?>>Culture</option>
                                <option value="Art" <?php echo e(old('category') == 'Art' ? 'selected' : ''); ?>>Art</option>
                                <option value="Business" <?php echo e(old('category') == 'Business' ? 'selected' : ''); ?>>Business</option>
                                <option value="Éducation" <?php echo e(old('category') == 'Éducation' ? 'selected' : ''); ?>>Éducation</option>
                                <option value="Santé" <?php echo e(old('category') == 'Santé' ? 'selected' : ''); ?>>Santé</option>
                                <option value="Technologie" <?php echo e(old('category') == 'Technologie' ? 'selected' : ''); ?>>Technologie</option>
                                <option value="Gastronomie" <?php echo e(old('category') == 'Gastronomie' ? 'selected' : ''); ?>>Gastronomie</option>
                                <option value="Divertissement" <?php echo e(old('category') == 'Divertissement' ? 'selected' : ''); ?>>Divertissement</option>
                                <option value="Famille" <?php echo e(old('category') == 'Famille' ? 'selected' : ''); ?>>Famille</option>
                                <option value="Mode" <?php echo e(old('category') == 'Mode' ? 'selected' : ''); ?>>Mode</option>
                                <option value="Autre" <?php echo e(old('category') == 'Autre' ? 'selected' : ''); ?>>Autre</option>
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
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm min-h-[44px]">
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
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]">
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
                            <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date')); ?>" required class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]">
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

                <!-- Type d'événement -->
                <div>
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Type d'événement</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="flex items-center min-h-[44px]">
                                <input type="checkbox" name="is_virtual" id="is_virtual" value="1" <?php echo e(old('is_virtual') ? 'checked' : ''); ?> class="mr-2 w-5 h-5 sm:w-6 sm:h-6 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded min-w-[20px] min-h-[20px]">
                                <span class="text-sm font-medium text-gray-700">Événement virtuel (visioconférence)</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-7">Cochez cette case si votre événement se déroule en ligne</p>
                        </div>
                    </div>
                </div>

                <!-- Configuration virtuelle (masqué par défaut) -->
                <div id="virtual-config" class="hidden">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Configuration de la visioconférence</h2>
                    <div class="space-y-4 bg-blue-50 p-4 rounded-lg border border-blue-200">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plateforme *</label>
                            <select name="platform_type" id="platform_type" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]">
                                <option value="">Sélectionner une plateforme</option>
                                <option value="google_meet" <?php echo e(old('platform_type') == 'google_meet' ? 'selected' : ''); ?>>Google Meet</option>
                                <option value="zoom" <?php echo e(old('platform_type') == 'zoom' ? 'selected' : ''); ?>>Zoom</option>
                                <option value="teams" <?php echo e(old('platform_type') == 'teams' ? 'selected' : ''); ?>>Microsoft Teams</option>
                                <option value="webex" <?php echo e(old('platform_type') == 'webex' ? 'selected' : ''); ?>>Cisco Webex</option>
                                <option value="other" <?php echo e(old('platform_type') == 'other' ? 'selected' : ''); ?>>Autre</option>
                            </select>
                            <?php $__errorArgs = ['platform_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Lien de la visioconférence *</label>
                            <input type="url" name="meeting_link" id="meeting_link" value="<?php echo e(old('meeting_link')); ?>" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="https://meet.google.com/xxx-xxxx-xxx ou https://zoom.us/j/xxxxx">
                            <?php $__errorArgs = ['meeting_link'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <p class="text-xs text-gray-500 mt-1">Collez le lien complet de votre réunion</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ID de la réunion (optionnel)</label>
                                <input type="text" name="meeting_id" id="meeting_id" value="<?php echo e(old('meeting_id')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ex: abc-defg-hij">
                                <?php $__errorArgs = ['meeting_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe (optionnel)</label>
                                <input type="text" name="meeting_password" id="meeting_password" value="<?php echo e(old('meeting_password')); ?>" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Mot de passe de la réunion">
                                <?php $__errorArgs = ['meeting_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Instructions d'accès (optionnel)</label>
                            <textarea name="virtual_access_instructions" id="virtual_access_instructions" rows="3" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[90px]" placeholder="Instructions spéciales pour les participants (ex: Activer la caméra, utiliser un nom spécifique, etc.)"><?php echo e(old('virtual_access_instructions')); ?></textarea>
                            <?php $__errorArgs = ['virtual_access_instructions'];
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

                <!-- Lieu (masqué si virtuel) -->
                <div id="venue-section">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Lieu</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du lieu</label>
                            <input type="text" name="venue_name" id="venue_name" value="<?php echo e(old('venue_name')); ?>" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Stade de l'Amitié">
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
                            <div class="flex flex-col sm:flex-row gap-2 w-full">
                                <input type="text" name="venue_address" id="venue_address" value="<?php echo e(old('venue_address')); ?>" class="flex-1 min-w-0 w-full sm:w-auto px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Rue 123, Quartier...">
                                <button type="button" id="geocodeBtn" class="w-full sm:w-auto sm:flex-shrink-0 px-3 sm:px-4 lg:px-5 py-2 sm:py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm min-h-[44px] flex items-center justify-center whitespace-nowrap shadow-sm hover:shadow-md">
                                    <i class="fas fa-search-location text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Localiser</span><span class="sm:hidden">Loc.</span>
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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" id="venue_city" value="<?php echo e(old('venue_city')); ?>" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Cotonou">
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
                                <input type="text" name="venue_country" id="venue_country" value="<?php echo e(old('venue_country')); ?>" class="w-full px-3 sm:px-4 py-2.5 sm:py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm sm:text-base min-h-[44px]" placeholder="Ex: Bénin">
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
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-2">
                                <label class="block text-sm font-medium text-gray-700">Localisation sur la carte</label>
                                <button type="button" id="geolocateBtn" class="px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm bg-green-600 text-white rounded-lg hover:bg-green-700 active:bg-green-800 transition font-medium min-h-[40px] sm:min-h-[44px] flex items-center justify-center gap-1.5 sm:gap-2 w-full sm:w-auto shadow-sm hover:shadow-md">
                                    <i class="fas fa-crosshairs text-xs sm:text-sm"></i><span class="hidden sm:inline">Ma localisation</span><span class="sm:hidden">Ma loc.</span>
                                </button>
                            </div>
                            <div id="map" class="w-full h-48 sm:h-64 rounded-lg border border-gray-300"></div>
                            <p class="text-sm text-gray-500 mt-2">Saisissez une adresse et cliquez sur "Localiser", utilisez "Ma localisation", ou cliquez directement sur la carte</p>
                            <input type="hidden" name="venue_latitude" id="venue_latitude" value="<?php echo e(old('venue_latitude')); ?>">
                            <input type="hidden" name="venue_longitude" id="venue_longitude" value="<?php echo e(old('venue_longitude')); ?>">
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

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 sm:px-6 lg:px-8 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-semibold text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                    <i class="fas fa-save text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Créer l'événement
                </button>
                <a href="<?php echo e(route('organizer.events.index')); ?>" class="text-gray-600 hover:text-gray-800 active:text-gray-900 text-center sm:text-left py-2.5 sm:py-0 text-xs sm:text-sm min-h-[40px] sm:min-h-[44px] flex items-center justify-center sm:justify-start">
                    Annuler
                </a>
            </div>
        </form>
    </div>

    <!-- Note importante -->
    <div class="mt-4 sm:mt-6 bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Note importante :</p>
                <p>L'événement sera créé en mode "Brouillon". Après création, vous pourrez ajouter des types de billets et publier l'événement.</p>
            </div>
        </div>
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
<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isVirtualCheckbox = document.getElementById('is_virtual');
    const virtualConfig = document.getElementById('virtual-config');
    const venueSection = document.getElementById('venue-section');
    const platformType = document.getElementById('platform_type');
    const meetingLink = document.getElementById('meeting_link');

    function toggleVirtualConfig() {
        if (isVirtualCheckbox.checked) {
            virtualConfig.classList.remove('hidden');
            venueSection.classList.add('hidden');
            platformType.required = true;
            meetingLink.required = true;
        } else {
            virtualConfig.classList.add('hidden');
            venueSection.classList.remove('hidden');
            platformType.required = false;
            meetingLink.required = false;
        }
    }

    isVirtualCheckbox.addEventListener('change', toggleVirtualConfig);
    
    // Initialiser l'état au chargement
    toggleVirtualConfig();
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/create.blade.php ENDPATH**/ ?>