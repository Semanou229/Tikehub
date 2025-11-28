

<?php $__env->startSection('title', 'Événements - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Découvrez nos événements</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <?php if($event->cover_image): ?>
                    <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-4">
                    <h3 class="text-xl font-semibold mb-2"><?php echo e($event->title); ?></h3>
                    <p class="text-gray-600 text-sm mb-2"><?php echo e(\Illuminate\Support\Str::limit($event->description, 100)); ?></p>
                    <?php if($event->start_date): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            <?php echo e($event->start_date->format('d/m/Y H:i')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($event->venue_city): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <?php echo e($event->venue_city); ?>

                        </div>
                    <?php endif; ?>
                    <a href="<?php echo e(route('events.show', $event)); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 inline-block">
                        Voir l'événement
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">Aucun événement disponible pour le moment.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if(isset($events) && method_exists($events, 'hasPages') && $events->hasPages()): ?>
        <div class="mt-6">
            <?php echo e($events->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/events/index.blade.php ENDPATH**/ ?>