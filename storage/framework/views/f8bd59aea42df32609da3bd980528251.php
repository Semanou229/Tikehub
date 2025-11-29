

<?php $__env->startSection('title', 'Mes Événements'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Événements</h1>
        <p class="text-gray-600 mt-2">Événements qui vous sont assignés</p>
    </div>

    <?php if($assignedEvents->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $assignedEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <?php if($event->cover_image): ?>
                        <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-white text-6xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($event->title); ?></h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2"><?php echo e(Str::limit($event->description, 100)); ?></p>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar mr-2 text-indigo-600"></i>
                                <span><?php echo e($event->start_date->translatedFormat('d M Y à H:i')); ?></span>
                            </div>
                            <?php if($event->venue_name): ?>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                                    <span><?php echo e($event->venue_name); ?>, <?php echo e($event->venue_city); ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-user mr-2 text-indigo-600"></i>
                                <span><?php echo e($event->organizer->name); ?></span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="<?php echo e(route('collaborator.events.show', $event)); ?>" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-center">
                                <i class="fas fa-eye mr-2"></i>Voir détails
                            </a>
                            <a href="<?php echo e(route('collaborator.scans.index', $event)); ?>" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-center">
                                <i class="fas fa-qrcode mr-2"></i>Scanner
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucun événement assigné</h3>
            <p class="text-gray-600">Vous n'avez pas encore d'événements assignés. Contactez votre organisateur pour être ajouté à un événement.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.collaborator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/collaborator/events/index.blade.php ENDPATH**/ ?>