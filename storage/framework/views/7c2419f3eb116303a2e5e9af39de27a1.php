<?php $__env->startSection('title', 'Concours & Votes - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h1 class="text-4xl font-bold text-gray-800 mb-2">Concours & Votes payants</h1>
                <p class="text-gray-600">Participez aux concours et votez pour vos favoris</p>
            </div>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->isOrganizer()): ?>
                    <a href="<?php echo e(route('contests.create')); ?>" class="bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-lg hover:from-purple-700 hover:to-pink-700 transition shadow-md hover:shadow-lg">
                        <i class="fas fa-plus mr-2"></i>Créer un concours
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
                    <i class="fas fa-filter mr-2 text-purple-600"></i>Filtres
                </h2>
                <form method="GET" action="<?php echo e(route('contests.index')); ?>" class="space-y-4">
                    <div class="space-y-4">
                <!-- Prix minimum par vote -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix min/vote (XOF)</label>
                    <input type="number" name="price_min" value="<?php echo e(request('price_min')); ?>" placeholder="0" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Prix maximum par vote -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prix max/vote (XOF)</label>
                    <input type="number" name="price_max" value="<?php echo e(request('price_max')); ?>" placeholder="∞" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Date de fin (début) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin après le</label>
                    <input type="date" name="end_date_from" value="<?php echo e(request('end_date_from')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Date de fin (fin) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Fin avant le</label>
                    <input type="date" name="end_date_to" value="<?php echo e(request('end_date_to')); ?>" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Nombre minimum de votes -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min votes</label>
                    <input type="number" name="min_votes" value="<?php echo e(request('min_votes')); ?>" placeholder="0" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>

                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur</label>
                    <select name="organizer" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Tous les organisateurs</option>
                        <?php $__currentLoopData = $organizers ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($organizer->id); ?>" <?php echo e(request('organizer') == $organizer->id ? 'selected' : ''); ?>><?php echo e($organizer->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <!-- Tri -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
                    <select name="sort" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <option value="popular" <?php echo e(request('sort') == 'popular' ? 'selected' : ''); ?>>Plus populaires</option>
                        <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Prix (croissant)</option>
                        <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Prix (décroissant)</option>
                        <option value="end_date" <?php echo e(request('sort') == 'end_date' ? 'selected' : ''); ?>>Fin proche</option>
                    </select>
                </div>
                    </div>

                    <div class="flex flex-col gap-2 pt-4 border-t border-gray-200">
                        <button type="submit" class="w-full bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            <i class="fas fa-filter mr-2"></i>Appliquer les filtres
                        </button>
                        <a href="<?php echo e(route('contests.index')); ?>" class="w-full text-center text-sm text-gray-600 hover:text-purple-600 py-2">
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
                <?php echo e($contests->total()); ?> concours trouvé(s)
            </div>

            <!-- Grille de concours -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300 border border-gray-200">
                <a href="<?php echo e(route('contests.show', $contest)); ?>">
                    <?php if($contest->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $contest->cover_image)); ?>" alt="<?php echo e($contest->name); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-trophy text-6xl text-white opacity-50"></i>
                        </div>
                    <?php endif; ?>
                </a>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-purple-100 text-purple-800 text-xs font-semibold px-3 py-1 rounded-full">
                            Concours
                        </span>
                        <span class="text-sm font-bold text-purple-600">
                            <?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF/vote
                        </span>
                    </div>
                    <a href="<?php echo e(route('contests.show', $contest)); ?>">
                        <h3 class="text-xl font-semibold mb-2 text-gray-800 hover:text-purple-600 transition"><?php echo e($contest->name); ?></h3>
                    </a>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(\Illuminate\Support\Str::limit($contest->description, 100)); ?></p>
                    <div class="flex items-center text-sm text-gray-500 mb-4">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>Jusqu'au <?php echo e($contest->end_date->translatedFormat('d/m/Y')); ?></span>
                        <span class="mx-2">•</span>
                        <i class="fas fa-users mr-2"></i>
                        <span><?php echo e($contest->votes_count ?? 0); ?> vote(s)</span>
                    </div>
                    <?php if($contest->organizer): ?>
                        <div class="flex items-center text-sm text-gray-600 mb-4">
                            <i class="fas fa-user-circle mr-2 text-purple-600"></i>
                            <span>Par</span>
                            <a href="<?php echo e(route('organizer.profile.show', $contest->organizer)); ?>" class="ml-1 text-purple-600 hover:text-purple-800 font-semibold hover:underline">
                                <?php echo e($contest->organizer->name); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('contests.show', $contest)); ?>" class="block w-full bg-purple-600 text-white text-center px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                        Voir le concours
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 text-lg mb-2">Aucun concours trouvé</p>
                <p class="text-gray-400 text-sm">Essayez de modifier vos critères de recherche</p>
            </div>
        <?php endif; ?>
    </div>

            <!-- Pagination -->
            <?php if($contests->hasPages()): ?>
                <div class="mt-8">
                    <?php echo e($contests->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/contests/index.blade.php ENDPATH**/ ?>