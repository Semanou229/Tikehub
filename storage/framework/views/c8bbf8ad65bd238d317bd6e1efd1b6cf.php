

<?php $__env->startSection('title', 'Sponsors'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Sponsors & Partenaires</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Gérez vos sponsors et partenaires</p>
        </div>
        <a href="<?php echo e(route('organizer.crm.sponsors.create')); ?>" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouveau sponsor</span><span class="sm:hidden">Nouveau</span>
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total sponsors</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600"><?php echo e($stats['total']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Contribution totale</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600 whitespace-nowrap"><?php echo e(number_format($stats['total_contribution'], 0, ',', ' ')); ?> XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Confirmés</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-purple-600"><?php echo e($stats['by_status']['confirmed'] ?? 0); ?></div>
        </div>
    </div>

    <!-- Liste des sponsors -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sponsor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contribution</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $sponsors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sponsor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900"><?php echo e($sponsor->name); ?></div>
                            <?php if($sponsor->company): ?>
                                <div class="text-sm text-gray-500"><?php echo e($sponsor->company); ?></div>
                            <?php endif; ?>
                            <?php if($sponsor->event): ?>
                                <div class="text-xs text-gray-400 mt-1"><?php echo e($sponsor->event->title); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <?php echo e(ucfirst($sponsor->sponsor_type)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            <?php echo e(number_format($sponsor->contribution_amount, 0, ',', ' ')); ?> <?php echo e($sponsor->currency); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($sponsor->status === 'confirmed' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($sponsor->status === 'prospect' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($sponsor->status === 'negotiating' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                <?php echo e($sponsor->status === 'delivered' ? 'bg-purple-100 text-purple-800' : ''); ?>

                                <?php echo e($sponsor->status === 'closed' ? 'bg-gray-100 text-gray-800' : ''); ?>">
                                <?php echo e(ucfirst($sponsor->status)); ?>

                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('organizer.crm.sponsors.show', $sponsor)); ?>" class="text-indigo-600 hover:text-indigo-900 active:text-indigo-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('organizer.crm.sponsors.edit', $sponsor)); ?>" class="text-gray-600 hover:text-gray-900 active:text-gray-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-handshake text-4xl mb-3 text-gray-300"></i>
                            <p>Aucun sponsor trouvé</p>
                            <a href="<?php echo e(route('organizer.crm.sponsors.create')); ?>" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                                Ajouter votre premier sponsor
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </div>
    </div>

    <?php if($sponsors->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($sponsors->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/sponsors/index.blade.php ENDPATH**/ ?>