

<?php $__env->startSection('title', 'Tâches de l\'Équipe'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tâches</h1>
            <p class="text-gray-600 mt-1">Équipe: <?php echo e($team->name); ?></p>
        </div>
        <div class="flex gap-2">
            <a href="<?php echo e(route('organizer.crm.teams.tasks.create', $team)); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle tâche
            </a>
            <a href="<?php echo e(route('organizer.crm.teams.show', $team)); ?>" class="text-gray-600 hover:text-gray-800 px-4 py-2">
                <i class="fas fa-arrow-left mr-2"></i>Retour à l'équipe
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <a href="<?php echo e(route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'todo'])); ?>" class="px-4 py-2 rounded-lg <?php echo e(request('status') == 'todo' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                À faire
            </a>
            <a href="<?php echo e(route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'in_progress'])); ?>" class="px-4 py-2 rounded-lg <?php echo e(request('status') == 'in_progress' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                En cours
            </a>
            <a href="<?php echo e(route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'done'])); ?>" class="px-4 py-2 rounded-lg <?php echo e(request('status') == 'done' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>">
                Terminé
            </a>
            <a href="<?php echo e(route('organizer.crm.teams.tasks.index', $team)); ?>" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                Toutes
            </a>
        </div>
    </div>

    <!-- Liste des tâches -->
    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-800"><?php echo e($task->title); ?></h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                <?php echo e($task->status === 'done' ? 'bg-green-100 text-green-800' : 
                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                <?php echo e($task->status === 'done' ? 'Terminé' : ($task->status === 'in_progress' ? 'En cours' : 'À faire')); ?>

                            </span>
                        </div>
                        
                        <?php if($task->description): ?>
                            <p class="text-gray-600 mb-4"><?php echo e($task->description); ?></p>
                        <?php endif; ?>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            <?php if($task->assignedUser): ?>
                                <span><i class="fas fa-user mr-1"></i>Assigné à: <?php echo e($task->assignedUser->name); ?></span>
                            <?php else: ?>
                                <span><i class="fas fa-user mr-1"></i>Non assigné</span>
                            <?php endif; ?>
                            
                            <?php if($task->due_date): ?>
                                <span><i class="fas fa-calendar mr-1"></i>Échéance: <?php echo e($task->due_date->format('d/m/Y')); ?></span>
                                <?php if($task->due_date->isPast() && $task->status !== 'done'): ?>
                                    <span class="text-red-600 font-semibold">En retard</span>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <span><i class="fas fa-clock mr-1"></i><?php echo e($task->created_at->format('d/m/Y H:i')); ?></span>
                        </div>
                    </div>

                    <div class="flex gap-2 ml-4">
                        <a href="<?php echo e(route('organizer.crm.teams.tasks.edit', [$team, $task])); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('organizer.crm.teams.tasks.destroy', [$team, $task])); ?>" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-tasks text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucune tâche trouvée</p>
                <a href="<?php echo e(route('organizer.crm.teams.tasks.create', $team)); ?>" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre première tâche
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($tasks->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($tasks->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/teams/tasks/index.blade.php ENDPATH**/ ?>