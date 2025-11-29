

<?php $__env->startSection('title', $user->name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.users.index')); ?>" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800"><?php echo e($user->name); ?></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations utilisateur -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold"><?php echo e($user->email); ?></p>
                    </div>
                    <?php if($user->phone): ?>
                        <div>
                            <p class="text-sm text-gray-600">Téléphone</p>
                            <p class="font-semibold"><?php echo e($user->phone); ?></p>
                        </div>
                    <?php endif; ?>
                    <div>
                        <p class="text-sm text-gray-600">Rôles</p>
                        <div class="flex gap-2 mt-1">
                            <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <?php echo e(ucfirst($role->name)); ?>

                                </span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Statut</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e($user->is_active ? 'Actif' : 'Inactif'); ?>

                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Inscrit le</p>
                        <p class="font-semibold"><?php echo e($user->created_at->translatedFormat('d M Y à H:i')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Événements</p>
                        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['total_events']); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Billets</p>
                        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['total_tickets']); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dépenses</p>
                        <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($stats['total_spent'], 0, ',', ' ')); ?> XOF</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
                <div class="space-y-3">
                    <!-- Changer le rôle -->
                    <form action="<?php echo e(route('admin.users.updateRole', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Changer le rôle</label>
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                            <?php $__currentLoopData = \Spatie\Permission\Models\Role::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->name); ?>" <?php echo e($user->hasRole($role->name) ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($role->name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Mettre à jour
                        </button>
                    </form>

                    <!-- Activer/Désactiver -->
                    <form action="<?php echo e(route('admin.users.toggleStatus', $user)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full bg-<?php echo e($user->is_active ? 'orange' : 'green'); ?>-600 text-white px-4 py-2 rounded-lg hover:bg-<?php echo e($user->is_active ? 'orange' : 'green'); ?>-700 transition">
                            <?php echo e($user->is_active ? 'Désactiver' : 'Activer'); ?>

                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/users/show.blade.php ENDPATH**/ ?>