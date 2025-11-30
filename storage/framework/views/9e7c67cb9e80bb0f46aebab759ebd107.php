

<?php $__env->startSection('title', 'Codes Promo'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Codes Promo</h1>
        <a href="<?php echo e(route('organizer.promo-codes.create')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Créer un code promo
        </a>
    </div>

    <?php if($promoCodes->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réduction</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisations</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $promoCodes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promoCode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="font-mono font-bold text-indigo-600"><?php echo e($promoCode->code); ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <?php echo e($promoCode->event ? $promoCode->event->title : 'Tous les événements'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($promoCode->discount_type === 'percentage'): ?>
                                    <span class="font-semibold text-green-600"><?php echo e($promoCode->discount_value); ?>%</span>
                                <?php else: ?>
                                    <span class="font-semibold text-green-600"><?php echo e(number_format($promoCode->discount_value, 0, ',', ' ')); ?> XOF</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-gray-600"><?php echo e($promoCode->usages_count); ?> / <?php echo e($promoCode->usage_limit ?? '∞'); ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($promoCode->isValid()): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactif</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="<?php echo e(route('organizer.promo-codes.show', $promoCode)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('organizer.promo-codes.edit', $promoCode)); ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="<?php echo e(route('organizer.promo-codes.destroy', $promoCode)); ?>" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($promoCodes->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-tag text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun code promo créé</p>
            <a href="<?php echo e(route('organizer.promo-codes.create')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer votre premier code promo
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/promo-codes/index.blade.php ENDPATH**/ ?>