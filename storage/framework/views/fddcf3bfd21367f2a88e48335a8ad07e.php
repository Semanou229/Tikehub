

<?php $__env->startSection('title', 'Gestion des Collectes'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Collectes</h1>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.fundraisings.index')); ?>" class="flex gap-4">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous</option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Actives</option>
                <option value="ended" <?php echo e(request('status') === 'ended' ? 'selected' : ''); ?>>Terminées</option>
            </select>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des collectes -->
    <?php if($fundraisings->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Collecte</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant collecté</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objectif</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date fin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $fundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($fundraising->name); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($fundraising->organizer->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                    <?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($fundraising->end_date->translatedFormat('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="<?php echo e(route('admin.fundraisings.show', $fundraising)); ?>" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                <?php echo e($fundraisings->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-heart text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Aucune collecte trouvée</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/fundraisings/index.blade.php ENDPATH**/ ?>