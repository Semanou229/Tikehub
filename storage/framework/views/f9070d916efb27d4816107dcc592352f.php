

<?php $__env->startSection('title', 'Modifier l\'Événement'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier l'Événement</h1>
        <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="text-red-600 hover:text-red-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="<?php echo e(route('admin.events.update', $event)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <div class="space-y-6">
                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur *</label>
                    <select name="organizer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <?php $__currentLoopData = $organizers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($organizer->id); ?>" <?php echo e($event->organizer_id == $organizer->id ? 'selected' : ''); ?>>
                                <?php echo e($organizer->name); ?> (<?php echo e($organizer->email); ?>)
                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['organizer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Titre de l'événement *</label>
                            <input type="text" name="title" value="<?php echo e(old('title', $event->title)); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
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
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"><?php echo e(old('description', $event->description)); ?></textarea>
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
                            <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
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
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="<?php echo e(old('start_date', $event->start_date->format('Y-m-d\TH:i'))); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
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
                            <input type="datetime-local" name="end_date" value="<?php echo e(old('end_date', $event->end_date->format('Y-m-d\TH:i'))); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
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
                            <input type="text" name="venue_name" value="<?php echo e(old('venue_name', $event->venue_name)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Adresse</label>
                            <input type="text" name="venue_address" value="<?php echo e(old('venue_address', $event->venue_address)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
                                <input type="text" name="venue_city" value="<?php echo e(old('venue_city', $event->venue_city)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pays</label>
                                <input type="text" name="venue_country" value="<?php echo e(old('venue_country', $event->venue_country)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                                <input type="number" step="any" name="venue_latitude" value="<?php echo e(old('venue_latitude', $event->venue_latitude)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                                <input type="number" step="any" name="venue_longitude" value="<?php echo e(old('venue_longitude', $event->venue_longitude)); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image et statut -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Image et statut</h2>
                    <div class="space-y-4">
                        <?php if($event->cover_image): ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image actuelle</label>
                                <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="Cover" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        <?php endif; ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nouvelle image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" <?php echo e(old('is_published', $event->is_published) ? 'checked' : ''); ?> class="mr-2">
                                <span class="text-sm text-gray-700">Publier</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
                            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                                <option value="draft" <?php echo e(old('status', $event->status) == 'draft' ? 'selected' : ''); ?>>Brouillon</option>
                                <option value="published" <?php echo e(old('status', $event->status) == 'published' ? 'selected' : ''); ?>>Publié</option>
                                <option value="cancelled" <?php echo e(old('status', $event->status) == 'cancelled' ? 'selected' : ''); ?>>Annulé</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
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
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/events/edit.blade.php ENDPATH**/ ?>