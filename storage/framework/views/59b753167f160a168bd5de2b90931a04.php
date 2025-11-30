<?php $__env->startSection('title', 'Collectes de fonds - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Collectes de fonds</h1>
                <p class="text-gray-600">Soutenez les causes qui vous tiennent à cœur</p>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isOrganizer()): ?>
                    <a href="<?php echo e(route('fundraisings.create')); ?>" class="bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-3 rounded-lg hover:from-green-700 hover:to-teal-700 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Créer une collecte
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Layout avec sidebar de filtres -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar des filtres (sticky) -->
        <aside class="lg:w-80 flex-shrink-0">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-filter mr-2 text-green-600"></i>Filtres
                </h2>
                <form method="GET" action="<?php echo e(route('fundraisings.index')); ?>" class="space-y-4">
                    <div class="space-y-4">
                <!-- Montant objectif minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Objectif min (XOF)</label>
                    <input type="number" name="goal_min" value="<?php echo e(request('goal_min')); ?>" placeholder="0" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Montant objectif maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Objectif max (XOF)</label>
                    <input type="number" name="goal_max" value="<?php echo e(request('goal_max')); ?>" placeholder="∞" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Progression minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progression min (%)</label>
                    <input type="number" name="progress_min" value="<?php echo e(request('progress_min')); ?>" placeholder="0" min="0" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Progression maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Progression max (%)</label>
                    <input type="number" name="progress_max" value="<?php echo e(request('progress_max')); ?>" placeholder="100" min="0" max="100"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Date de fin (début) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin après le</label>
                    <input type="date" name="end_date_from" value="<?php echo e(request('end_date_from')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Date de fin (fin) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin avant le</label>
                    <input type="date" name="end_date_to" value="<?php echo e(request('end_date_to')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tous les organisateurs</option>
                        <?php $__currentLoopData = $organizers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($organizer->id); ?>" <?php echo e(request('organizer') == $organizer->id ? 'selected' : ''); ?>><?php echo e($organizer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="progress" <?php echo e(request('sort') == 'progress' ? 'selected' : ''); ?>>Progression</option>
                        <option value="goal_asc" <?php echo e(request('sort') == 'goal_asc' ? 'selected' : ''); ?>>Objectif (croissant)</option>
                        <option value="goal_desc" <?php echo e(request('sort') == 'goal_desc' ? 'selected' : ''); ?>>Objectif (décroissant)</option>
                        <option value="amount_asc" <?php echo e(request('sort') == 'amount_asc' ? 'selected' : ''); ?>>Montant (croissant)</option>
                        <option value="amount_desc" <?php echo e(request('sort') == 'amount_desc' ? 'selected' : ''); ?>>Montant (décroissant)</option>
                        <option value="end_date" <?php echo e(request('sort') == 'end_date' ? 'selected' : ''); ?>>Fin proche</option>
                    </select>
                </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-filter mr-2"></i>Appliquer les filtres
                        </button>
                        <a href="<?php echo e(route('fundraisings.index')); ?>" class="w-full text-center text-sm text-gray-600 hover:text-green-600 py-2">
                            <i class="fas fa-redo mr-1"></i>Réinitialiser
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="flex-1 min-w-0">
            <!-- Résultats -->
            <div class="mb-4 text-sm text-gray-600">
                <i class="fas fa-info-circle mr-2"></i>
                <?php echo e($fundraisings->total()); ?> collecte(s) trouvée(s)
            </div>

            <!-- Grille de collectes -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $fundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>">
                    <?php if($fundraising->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $fundraising->cover_image)); ?>" alt="<?php echo e($fundraising->name); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-green-400 to-teal-500 flex items-center justify-center">
                            <i class="fas fa-heart text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Collecte
                        </span>
                        <span class="text-sm font-bold text-green-600">
                            <?php echo e(number_format($fundraising->progress_percentage, 0)); ?>%
                        </span>
                    </div>
                    <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-green-600 transition"><?php echo e($fundraising->name); ?></h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($fundraising->description, 100)); ?></p>
                    
                    <!-- Barre de progression -->
                    <div class="mb-4">
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span><?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF</span>
                            <span><?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full transition-all" style="width: <?php echo e(min(100, $fundraising->progress_percentage)); ?>%"></div>
                        </div>
                    </div>

                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au <?php echo e($fundraising->end_date->translatedFormat('d/m/Y')); ?></span>
                    </div>
                    <?php if($fundraising->organizer): ?>
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-user-circle mr-2 text-green-600"></i>
                            <span>Par</span>
                            <a href="<?php echo e(route('organizer.profile.show', $fundraising->organizer)); ?>" class="ml-1 text-green-600 hover:text-green-800 font-semibold hover:underline">
                                <?php echo e($fundraising->organizer->name); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>" class="block w-full bg-green-600 text-white text-center px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Contribuer
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucune collecte trouvée</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        <?php endif; ?>
    </div>

            <!-- Pagination -->
            <?php if($fundraisings->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($fundraisings->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/fundraisings/index.blade.php ENDPATH**/ ?>