

<?php $__env->startSection('title', 'Équipes'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Équipes</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Gérez vos équipes et collaborateurs</p>
        </div>
        <a href="<?php echo e(route('organizer.crm.teams.create')); ?>" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouvelle équipe</span><span class="sm:hidden">Nouvelle</span>
        </a>
    </div>

    <!-- Liste des équipes -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $teams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $team): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800"><?php echo e($team->name); ?></h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                        <?php echo e($team->members()->count()); ?> membres
                    </span>
                </div>
                <?php if($team->description): ?>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e(Str::limit($team->description, 100)); ?></p>
                <?php endif; ?>
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-tasks mr-1"></i><?php echo e($team->tasks()->count()); ?> tâches
                    </div>
                    <a href="<?php echo e(route('organizer.crm.teams.show', $team)); ?>" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="md:col-span-3 bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucune équipe créée</p>
                <a href="<?php echo e(route('organizer.crm.teams.create')); ?>" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre première équipe
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Section Agents (ancien système) -->
    <?php if($agents->count() > 0): ?>
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Agents existants</h2>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4"><?php echo e($agent->name); ?></td>
                                <td class="px-6 py-4"><?php echo e($agent->email); ?></td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">Assignez à une équipe depuis la page de l'équipe</span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/teams/index.blade.php ENDPATH**/ ?>