

<?php $__env->startSection('title', 'Gestion KYC'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion KYC</h1>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">En attente</div>
            <div class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Vérifiés</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['verified']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Rejetés</div>
            <div class="text-3xl font-bold text-red-600"><?php echo e($stats['rejected']); ?></div>
        </div>
    </div>

    <!-- Liste des demandes -->
    <?php if($kycRequests->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date de soumission</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $kycRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($user->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            <?php echo e(ucfirst($role->name)); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($user->kyc_submitted_at ? $user->kyc_submitted_at->translatedFormat('d M Y à H:i') : 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($user->kyc_status === 'pending'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                    <?php elseif($user->kyc_status === 'rejected'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <a href="<?php echo e(route('admin.kyc.show', $user)); ?>" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-eye mr-1"></i>Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                <?php echo e($kycRequests->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-id-card text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Aucune demande KYC en attente</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/kyc/index.blade.php ENDPATH**/ ?>