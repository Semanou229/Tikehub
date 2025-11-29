

<?php $__env->startSection('title', 'Dashboard Collaborateur'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Collaborateur</h1>
        <p class="text-gray-600 mt-2">Bienvenue, <?php echo e(auth()->user()->name); ?></p>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Scans totaux</p>
                    <p class="text-2xl font-bold text-indigo-600"><?php echo e($stats['total_scans']); ?></p>
                </div>
                <i class="fas fa-qrcode text-3xl text-indigo-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Scans aujourd'hui</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e($stats['today_scans']); ?></p>
                </div>
                <i class="fas fa-calendar-day text-3xl text-green-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Tâches en cours</p>
                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($stats['pending_tasks']); ?></p>
                </div>
                <i class="fas fa-tasks text-3xl text-yellow-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Tâches terminées</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['completed_tasks']); ?></p>
                </div>
                <i class="fas fa-check-circle text-3xl text-blue-400"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Événements assignés -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Événements assignés</h2>
                <a href="<?php echo e(route('collaborator.events.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php if($assignedEvents->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $assignedEvents->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('collaborator.events.show', $event)); ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo e($event->title); ?></h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-calendar mr-1"></i>
                                        <?php echo e($event->start_date->translatedFormat('d M Y à H:i')); ?>

                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucun événement assigné pour le moment</p>
            <?php endif; ?>
        </div>

        <!-- Mes tâches -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Mes tâches</h2>
                <a href="<?php echo e(route('collaborator.tasks.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php if($myTasks->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $myTasks->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('collaborator.tasks.show', $task)); ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo e($task->title); ?></h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            <?php if($task->status === 'completed'): ?> bg-green-100 text-green-800
                                            <?php elseif($task->status === 'in_progress'): ?> bg-blue-100 text-blue-800
                                            <?php else: ?> bg-yellow-100 text-yellow-800
                                            <?php endif; ?>">
                                            <?php echo e(ucfirst($task->status)); ?>

                                        </span>
                                        <?php if($task->due_date): ?>
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-clock mr-1"></i>
                                                <?php echo e($task->due_date->translatedFormat('d M Y')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400"></i>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucune tâche assignée</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Scans récents -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Scans récents</h2>
        <?php if($recentScans->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Billet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acheteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $recentScans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($scan->created_at->translatedFormat('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($scan->event->title ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($scan->ticket->code ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($scan->ticket->buyer->name ?? $scan->ticket->buyer_name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($scan->is_valid): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Valide</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Invalide</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Aucun scan effectué pour le moment</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.collaborator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/collaborator/index.blade.php ENDPATH**/ ?>