

<?php $__env->startSection('title', 'Mes Événements Virtuels'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-video text-blue-600 mr-3"></i>
            Mes Événements Virtuels
        </h1>
        <a href="<?php echo e(route('events.index')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-search mr-2"></i>Découvrir des événements
        </a>
    </div>

    <?php if($tickets->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition border-2 border-blue-200">
                    <?php if($ticket->event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $ticket->event->cover_image)); ?>" alt="<?php echo e($ticket->event->title); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center">
                            <i class="fas fa-video text-white text-6xl opacity-50"></i>
                        </div>
                    <?php endif; ?>>
                    
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1"><?php echo e($ticket->event->title); ?></h3>
                                <p class="text-sm text-gray-600 flex items-center">
                                    <i class="fas fa-video text-blue-600 mr-1"></i>
                                    <?php echo e(ucfirst(str_replace('_', ' ', $ticket->event->platform_type ?? 'Visioconférence'))); ?>

                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-video"></i>
                            </span>
                        </div>

                        <div class="space-y-2 mb-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-600 mr-2 w-4"></i>
                                <span><?php echo e($ticket->event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-600 mr-2 w-4"></i>
                                <span>Durée: <?php echo e($ticket->event->start_date->diffForHumans($ticket->event->end_date, true)); ?></span>
                            </div>
                            <?php if($ticket->event->virtual_access_instructions): ?>
                                <div class="mt-2 p-2 bg-blue-50 rounded text-xs text-gray-700">
                                    <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                                    <?php echo e(\Illuminate\Support\Str::limit($ticket->event->virtual_access_instructions, 80)); ?>

                                </div>
                            <?php endif; ?>
                            <?php if($ticket->event->meeting_password): ?>
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-lock text-blue-600 mr-2 w-4"></i>
                                    <span>Mot de passe: <strong><?php echo e($ticket->event->meeting_password); ?></strong></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2 pt-4 border-t border-gray-200">
                            <?php if($ticket->virtual_access_token): ?>
                                <?php if($ticket->event->start_date >= now()): ?>
                                    <a href="<?php echo e($ticket->getVirtualAccessUrl()); ?>" target="_blank" class="block w-full bg-blue-600 text-white text-center px-4 py-3 rounded-lg hover:bg-blue-700 transition font-medium mb-2">
                                        <i class="fas fa-video mr-2"></i>Rejoindre l'événement
                                    </a>
                                <?php else: ?>
                                    <div class="bg-gray-100 text-gray-600 text-center px-4 py-3 rounded-lg text-sm mb-2">
                                        <i class="fas fa-clock mr-2"></i>L'événement n'a pas encore commencé
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <div class="flex items-center justify-between">
                                <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                    <i class="fas fa-eye mr-1"></i>Voir le billet
                                </a>
                                <a href="<?php echo e(route('tickets.download', $ticket)); ?>" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                    <i class="fas fa-download mr-1"></i>PDF
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="mt-6">
            <?php echo e($tickets->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-video text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun événement virtuel trouvé</p>
            <a href="<?php echo e(route('events.index')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Découvrir des événements virtuels
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.buyer-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/buyer/virtual-events.blade.php ENDPATH**/ ?>