<?php $__env->startSection('title', 'Mes Événements Virtuels'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 flex items-center">
            <i class="fas fa-video text-blue-600 mr-2 sm:mr-3 text-lg sm:text-xl"></i>
            <span class="break-words">Mes Événements Virtuels</span>
        </h1>
        <a href="<?php echo e(route('home')); ?>" class="bg-indigo-600 text-white px-3 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg w-full sm:w-auto">
            <i class="fas fa-search text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Découvrir des événements</span><span class="sm:hidden">Découvrir</span>
        </a>
    </div>

    <?php if($tickets->count() > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition border-2 border-blue-200">
                    <?php if($ticket->event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $ticket->event->cover_image)); ?>" alt="<?php echo e($ticket->event->title); ?>" class="w-full h-40 sm:h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-40 sm:h-48 bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center">
                            <i class="fas fa-video text-white text-4xl sm:text-5xl lg:text-6xl opacity-50"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-4 sm:p-6">
                        <div class="flex items-start justify-between mb-2 sm:mb-3">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1 break-words"><?php echo e($ticket->event->title); ?></h3>
                                <p class="text-xs sm:text-sm text-gray-600 flex items-center truncate">
                                    <i class="fas fa-video text-blue-600 mr-1 flex-shrink-0"></i>
                                    <span class="truncate"><?php echo e(ucfirst(str_replace('_', ' ', $ticket->event->platform_type ?? 'Visioconférence'))); ?></span>
                                </p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 flex-shrink-0 ml-2">
                                <i class="fas fa-video"></i>
                            </span>
                        </div>

                        <div class="space-y-1.5 sm:space-y-2 mb-3 sm:mb-4 text-xs sm:text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs flex-shrink-0"></i>
                                <span class="truncate"><?php echo e($ticket->event->start_date->translatedFormat('d/m/Y H:i')); ?></span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock text-blue-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs flex-shrink-0"></i>
                                <span class="truncate">Durée: <?php echo e($ticket->event->start_date->diffForHumans($ticket->event->end_date, true)); ?></span>
                            </div>
                            <?php if($ticket->event->virtual_access_instructions): ?>
                                <div class="mt-2 p-2 sm:p-3 bg-blue-50 rounded text-xs text-gray-700">
                                    <i class="fas fa-info-circle text-blue-600 mr-1"></i>
                                    <?php echo e(\Illuminate\Support\Str::limit($ticket->event->virtual_access_instructions, 80)); ?>

                                </div>
                            <?php endif; ?>
                            <?php if($ticket->event->meeting_password): ?>
                                <div class="flex items-center text-xs">
                                    <i class="fas fa-lock text-blue-600 mr-1.5 sm:mr-2 w-3 sm:w-4 text-xs flex-shrink-0"></i>
                                    <span class="truncate">Mot de passe: <strong><?php echo e($ticket->event->meeting_password); ?></strong></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="space-y-2 pt-3 sm:pt-4 border-t border-gray-200">
                            <?php if($ticket->virtual_access_token): ?>
                                <?php if($ticket->event->start_date >= now()): ?>
                                    <a href="<?php echo e($ticket->getVirtualAccessUrl()); ?>" target="_blank" class="block w-full bg-blue-600 text-white text-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-blue-700 active:bg-blue-800 transition font-medium text-xs sm:text-sm mb-2 min-h-[44px] flex items-center justify-center shadow-sm hover:shadow-md">
                                        <i class="fas fa-video mr-1.5 sm:mr-2 text-xs sm:text-sm"></i><span>Rejoindre l'événement</span>
                                    </a>
                                <?php else: ?>
                                    <div class="bg-gray-100 text-gray-600 text-center px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg text-xs sm:text-sm mb-2 min-h-[44px] flex items-center justify-center">
                                        <i class="fas fa-clock mr-1.5 sm:mr-2 text-xs sm:text-sm"></i><span>L'événement n'a pas encore commencé</span>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                            <div class="flex items-center justify-between gap-2">
                                <a href="<?php echo e(route('tickets.show', $ticket)); ?>" class="text-indigo-600 hover:text-indigo-800 active:text-indigo-700 text-xs sm:text-sm font-medium min-h-[36px] flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg hover:bg-indigo-50 transition">
                                    <i class="fas fa-eye mr-1 text-xs sm:text-sm"></i><span class="hidden sm:inline">Voir le billet</span><span class="sm:hidden">Voir</span>
                                </a>
                                <a href="<?php echo e(route('tickets.download', $ticket)); ?>" class="text-green-600 hover:text-green-800 active:text-green-700 text-xs sm:text-sm font-medium min-h-[36px] flex items-center justify-center px-2 sm:px-3 py-1.5 sm:py-2 rounded-lg hover:bg-green-50 transition">
                                    <i class="fas fa-download mr-1 text-xs sm:text-sm"></i><span>PDF</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <?php if($tickets->hasPages()): ?>
            <div class="mt-4 sm:mt-6 overflow-x-auto">
                <div class="min-w-fit">
                    <?php echo e($tickets->links()); ?>

                </div>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-6 sm:p-8 lg:p-12 text-center">
            <i class="fas fa-video text-4xl sm:text-5xl lg:text-6xl text-gray-300 mb-3 sm:mb-4"></i>
            <p class="text-sm sm:text-base text-gray-500 mb-3 sm:mb-4">Aucun événement virtuel trouvé</p>
            <a href="<?php echo e(route('home')); ?>" class="inline-block bg-indigo-600 text-white px-4 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg mx-auto">
                <i class="fas fa-search text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Découvrir des événements virtuels</span><span class="sm:hidden">Découvrir</span>
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.buyer-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/buyer/virtual-events.blade.php ENDPATH**/ ?>