

<?php $__env->startSection('title', 'Demandes de Retrait'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Demandes de Retrait</h1>
        <p class="text-gray-600 mt-2">Gérez les demandes de retrait des organisateurs</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Total</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($stats['total']); ?></p>
                </div>
                <i class="fas fa-list text-3xl text-gray-400"></i>
            </div>
        </div>
        <div class="bg-yellow-50 rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-700 text-sm mb-1">En attente</p>
                    <p class="text-2xl font-bold text-yellow-800"><?php echo e($stats['pending']); ?></p>
                    <p class="text-xs text-yellow-600 mt-1"><?php echo e(number_format($stats['pending_amount'], 0, ',', ' ')); ?> XOF</p>
                </div>
                <i class="fas fa-clock text-3xl text-yellow-400"></i>
            </div>
        </div>
        <div class="bg-green-50 rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-700 text-sm mb-1">Complétées</p>
                    <p class="text-2xl font-bold text-green-800"><?php echo e($stats['completed']); ?></p>
                </div>
                <i class="fas fa-check-circle text-3xl text-green-400"></i>
            </div>
        </div>
        <div class="bg-red-50 rounded-lg shadow-md p-6 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-700 text-sm mb-1">Rejetées</p>
                    <p class="text-2xl font-bold text-red-800"><?php echo e($stats['rejected']); ?></p>
                </div>
                <i class="fas fa-times-circle text-3xl text-red-400"></i>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="<?php echo e(route('admin.withdrawals.index')); ?>" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher par nom ou email..." 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Tous les statuts</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>En attente</option>
                    <option value="approved" <?php echo e(request('status') === 'approved' ? 'selected' : ''); ?>>Approuvé</option>
                    <option value="completed" <?php echo e(request('status') === 'completed' ? 'selected' : ''); ?>>Complété</option>
                    <option value="rejected" <?php echo e(request('status') === 'rejected' ? 'selected' : ''); ?>>Rejeté</option>
                </select>
            </div>
            <div>
                <select name="payment_method" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">Toutes les méthodes</option>
                    <option value="mobile_money" <?php echo e(request('payment_method') === 'mobile_money' ? 'selected' : ''); ?>>Mobile Money</option>
                    <option value="bank_transfer" <?php echo e(request('payment_method') === 'bank_transfer' ? 'selected' : ''); ?>>Virement bancaire</option>
                    <option value="crypto" <?php echo e(request('payment_method') === 'crypto' ? 'selected' : ''); ?>>Crypto-monnaie</option>
                </select>
            </div>
            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Filtrer
            </button>
        </form>
    </div>

    <!-- Liste des demandes -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organisateur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Méthode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($withdrawal->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($withdrawal->user->name); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($withdrawal->user->email); ?></div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <?php echo e(number_format($withdrawal->amount, 0, ',', ' ')); ?> XOF
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if($withdrawal->payment_method === 'mobile_money'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo e($withdrawal->mobile_network ?? 'Mobile Money'); ?>

                                    </span>
                                <?php elseif($withdrawal->payment_method === 'bank_transfer'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <?php echo e($withdrawal->bank_name ?? 'Virement bancaire'); ?>

                                    </span>
                                <?php elseif($withdrawal->payment_method === 'crypto'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?php echo e($withdrawal->crypto_currency ?? 'Crypto'); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($withdrawal->status === 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                <?php elseif($withdrawal->status === 'approved'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Approuvé</span>
                                <?php elseif($withdrawal->status === 'completed'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                                <?php elseif($withdrawal->status === 'rejected'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Annulé</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo e(route('admin.withdrawals.show', $withdrawal)); ?>" class="text-indigo-600 hover:text-indigo-800 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucune demande de retrait trouvée
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4">
            <?php echo e($withdrawals->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/withdrawals/index.blade.php ENDPATH**/ ?>