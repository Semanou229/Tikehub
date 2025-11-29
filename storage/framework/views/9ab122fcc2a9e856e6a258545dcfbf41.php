<?php $__env->startSection('title', 'Mes Collectes de Fonds'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Collectes de Fonds</h1>
        <a href="<?php echo e(route('fundraisings.create')); ?>" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle collecte
        </a>
    </div>

    <?php if($fundraisings->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $fundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($fundraising->name); ?></h3>
                                <?php if($fundraising->description): ?>
                                    <p class="text-sm text-gray-600 line-clamp-2"><?php echo e(Str::limit($fundraising->description, 80)); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="ml-4 flex flex-col gap-1">
                                <?php if($fundraising->is_published): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publiée</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                <?php endif; ?>
                                <?php if($fundraising->isActive()): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-green-600 mr-2 w-4"></i>
                                <span><?php echo e($fundraising->start_date->format('d/m/Y')); ?> au <?php echo e($fundraising->end_date->format('d/m/Y')); ?></span>
                            </div>
                            
                            <!-- Barre de progression -->
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600"><?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF</span>
                                    <span class="text-gray-600"><?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: <?php echo e(min(100, $fundraising->progress_percentage)); ?>%"></div>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-green-600 font-semibold"><?php echo e(number_format($fundraising->progress_percentage, 1)); ?>% atteint</span>
                                    <span class="text-gray-500"><?php echo e($fundraising->donations_count); ?> dons</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>" class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('fundraisings.edit', $fundraising)); ?>" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-50" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <?php if(!$fundraising->is_published): ?>
                                    <form action="<?php echo e(route('fundraisings.publish', $fundraising)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50" title="Publier">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <form action="<?php echo e(route('organizer.fundraisings.destroy', $fundraising)); ?>" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4">
            <?php echo e($fundraisings->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucune collecte de fonds créée pour le moment</p>
            <a href="<?php echo e(route('fundraisings.create')); ?>" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer ma première collecte
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/fundraisings/index.blade.php ENDPATH**/ ?>