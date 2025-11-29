<?php $__env->startSection('title', 'Mes Événements'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Événements</h1>
        <a href="<?php echo e(route('events.create')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvel événement
        </a>
    </div>

    <?php if($events->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($event->title); ?></h3>
                                <p class="text-sm text-gray-500"><?php echo e($event->category); ?></p>
                            </div>
                            <div class="ml-4 flex flex-col gap-1">
                                <?php if($event->is_published): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                <?php endif; ?>
                                <?php if($event->is_virtual): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-video mr-1"></i>Virtuel
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2 w-4"></i>
                                <span><?php echo e($event->start_date->format('d/m/Y')); ?> à <?php echo e($event->start_date->format('H:i')); ?></span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-ticket-alt text-indigo-600 mr-2 w-4"></i>
                                <span><strong><?php echo e($event->tickets_count); ?></strong> billets vendus</span>
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-tags text-indigo-600 mr-2 w-4"></i>
                                <span><?php echo e($event->ticket_types_count); ?> types de billets</span>
                            </div>
                            <?php if($event->is_virtual): ?>
                                <?php
                                    $virtualStats = app(\App\Services\VirtualEventService::class)->getAccessStatistics($event);
                                ?>
                                <div class="flex items-center text-sm text-blue-600 bg-blue-50 p-2 rounded-lg">
                                    <i class="fas fa-users text-blue-600 mr-2 w-4"></i>
                                    <span><strong><?php echo e($virtualStats['unique_participants']); ?></strong> participant(s) connecté(s) / <?php echo e($virtualStats['total_tickets']); ?> billets</span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('organizer.events.collaborators', $event)); ?>" class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50" title="Gérer les collaborateurs">
                                    <i class="fas fa-users"></i>
                                </a>
                                <a href="<?php echo e(route('events.show', $event)); ?>" class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('events.edit', $event)); ?>" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-50" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo e(route('organizer.ticket-types.index', $event)); ?>" class="text-purple-600 hover:text-purple-900 p-2 rounded-lg hover:bg-purple-50" title="Types de billets">
                                    <i class="fas fa-ticket-alt"></i>
                                </a>
                                <a href="<?php echo e(route('organizer.scans.index', $event)); ?>" class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50" title="Scans">
                                    <i class="fas fa-qrcode"></i>
                                </a>
                            </div>
                            <form action="<?php echo e(route('organizer.events.destroy', $event)); ?>" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-4">
            <?php echo e($events->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun événement créé pour le moment</p>
            <a href="<?php echo e(route('events.create')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer mon premier événement
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/events/index.blade.php ENDPATH**/ ?>