<?php $__env->startSection('title', 'Événements - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Découvrez nos événements</h1>
        <p class="text-gray-600">Trouvez l'événement parfait pour vous</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <form method="GET" action="<?php echo e(route('events.index')); ?>" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Recherche -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                    <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Nom, description..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Catégorie -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                    <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Toutes les catégories</option>
                        <?php $__currentLoopData = $categories ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>><?php echo e($category); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Date de début -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de début</label>
                    <input type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Date de fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin</label>
                    <input type="date" name="date_to" value="<?php echo e(request('date_to')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Localisation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Localisation</label>
                    <input type="text" name="location" value="<?php echo e(request('location')); ?>" placeholder="Ville..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Prix minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix min (XOF)</label>
                    <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" placeholder="0" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Prix maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix max (XOF)</label>
                    <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" placeholder="∞" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les organisateurs</option>
                        <?php $__currentLoopData = $organizers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($organizer->id); ?>" <?php echo e(request('organizer') == $organizer->id ? 'selected' : ''); ?>><?php echo e($organizer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Options -->
                <div class="flex flex-col space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Options</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="free" value="true" <?php echo e(request('free') == 'true' ? 'checked' : ''); ?>

                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Gratuit uniquement</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="virtual" value="true" <?php echo e(request('virtual') == 'true' ? 'checked' : ''); ?>

                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-700">Événements virtuels</span>
                    </label>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="date_desc" <?php echo e(request('sort') == 'date_desc' ? 'selected' : ''); ?>>Date (récent)</option>
                        <option value="date_asc" <?php echo e(request('sort') == 'date_asc' ? 'selected' : ''); ?>>Date (ancien)</option>
                        <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Prix (croissant)</option>
                        <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Prix (décroissant)</option>
                        <option value="popular" <?php echo e(request('sort') == 'popular' ? 'selected' : ''); ?>>Plus populaires</option>
                    </select>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <a href="<?php echo e(route('events.index')); ?>" class="text-sm text-gray-600 hover:text-indigo-600">
                    <i class="fas fa-redo mr-1"></i>Réinitialiser
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Résultats -->
    <div class="mb-4 text-sm text-gray-600">
        <i class="fas fa-info-circle mr-2"></i>
        <?php echo e($events->total()); ?> événement(s) trouvé(s)
    </div>

    <!-- Grille d'événements -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="<?php echo e(route('events.show', $event)); ?>">
                    <?php if($event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center">
                            <i class="fas fa-calendar text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                            <?php echo e($event->category ?? 'Événement'); ?>

                        </span>
                        <div class="flex gap-2">
                            <?php if($event->is_virtual): ?>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-video mr-1"></i>Virtuel
                                </span>
                            <?php endif; ?>
                            <?php if($event->is_free): ?>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    Gratuit
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <a href="<?php echo e(route('events.show', $event)); ?>">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-indigo-600 transition"><?php echo e($event->title); ?></h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($event->description, 100)); ?></p>
                    <?php if($event->start_date): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            <?php echo e($event->start_date->translatedFormat('d/m/Y H:i')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($event->venue_city): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <?php echo e($event->venue_city); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($event->organizer): ?>
                        <div class="flex items-center text-sm text-gray-600 mb-3">
                            <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                            <span>Par</span>
                            <a href="<?php echo e(route('organizer.profile.show', $event->organizer)); ?>" class="ml-1 text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                                <?php echo e($event->organizer->name); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                    <?php
                        $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                    ?>
                    <?php if($minPrice > 0): ?>
                        <div class="mb-3">
                            <span class="text-lg font-bold text-indigo-600">
                                À partir de <?php echo e(number_format($minPrice, 0, ',', ' ')); ?> XOF
                            </span>
                        </div>
                    <?php elseif($event->is_free): ?>
                        <div class="mb-3">
                            <span class="text-lg font-bold text-green-600">
                                Gratuit
                            </span>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('events.show', $event)); ?>" class="block w-full bg-indigo-600 text-white text-center px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Voir l'événement
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun événement trouvé</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($events->hasPages()): ?>
        <div class="mt-8">
            <?php echo e($events->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/index.blade.php ENDPATH**/ ?>