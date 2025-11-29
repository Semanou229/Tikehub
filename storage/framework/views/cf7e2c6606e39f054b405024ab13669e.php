<?php $__env->startSection('title', 'Événements - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-6">Découvrez nos événements</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('events.show', $event)); ?>" class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <?php if($event->cover_image): ?>
                    <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-48 object-cover">
                <?php endif; ?>
                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                            <?php echo e($event->category); ?>

                        </span>
                        <div class="flex gap-2">
                            <?php if($event->is_virtual): ?>
                                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    <i class="fas fa-video mr-1"></i>Virtuel
                                </span>
                            <?php endif; ?>
                            <?php if($event->is_free): ?>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                    Gratuit
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 hover:text-indigo-600 transition"><?php echo e($event->title); ?></h3>
                    <p class="text-gray-600 text-sm mb-2"><?php echo e(\Illuminate\Support\Str::limit($event->description, 100)); ?></p>
                    <?php if($event->start_date): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-calendar mr-2"></i>
                            <?php echo e($event->start_date->translatedFormat('d/m/Y H:i')); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($event->venue_city): ?>
                        <div class="flex items-center text-sm text-gray-500 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            <?php echo e($event->venue_city); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($event->organizer): ?>
                        <div class="flex items-center text-sm text-gray-600 mb-2">
                            <i class="fas fa-user-circle mr-2 text-indigo-600"></i>
                            <span>Par</span>
                            <a href="<?php echo e(route('organizer.profile.show', $event->organizer)); ?>" class="ml-1 text-indigo-600 hover:text-indigo-800 font-semibold hover:underline">
                                <?php echo e($event->organizer->name); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                    <?php
                        $minPrice = $event->ticketTypes()->where('is_active', true)->min('price') ?? 0;
                    ?>
                    <?php if($minPrice > 0): ?>
                        <div class="mb-3">
                            <span class="text-lg font-bold text-indigo-600">
                                À partir de <?php echo e(number_format($minPrice, 0, ',', ' ')); ?> XOF
                            </span>
                        </div>
                    <?php elseif($event->is_free): ?>
                        <div class="mb-3">
                            <span class="text-lg font-bold text-green-600">
                                Gratuit
                            </span>
                        </div>
                    <?php endif; ?>
                    <span class="inline-block bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Voir l'événement
                    </span>
                </div>
            </a>
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