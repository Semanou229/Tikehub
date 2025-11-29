

<?php $__env->startSection('title', 'Gestion des Utilisateurs'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Utilisateurs</h1>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex gap-4">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous les rôles</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->name); ?>" <?php echo e(request('role') === $role->name ? 'selected' : ''); ?>>
                        <?php echo e(ucfirst($role->name)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="kyc_status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous les statuts KYC</option>
                <option value="pending" <?php echo e(request('kyc_status') === 'pending' ? 'selected' : ''); ?>>En attente</option>
                <option value="verified" <?php echo e(request('kyc_status') === 'verified' ? 'selected' : ''); ?>>Vérifié</option>
                <option value="rejected" <?php echo e(request('kyc_status') === 'rejected' ? 'selected' : ''); ?>>Rejeté</option>
            </select>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des utilisateurs -->
    <?php if($users->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rôle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">KYC</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($user->kyc_status === 'verified'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Vérifié</span>
                                    <?php elseif($user->kyc_status === 'pending'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                    <?php elseif($user->kyc_status === 'rejected'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Non soumis</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($user->is_active): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Inactif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                <?php echo e($users->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-users text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Aucun utilisateur trouvé</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/users/index.blade.php ENDPATH**/ ?>