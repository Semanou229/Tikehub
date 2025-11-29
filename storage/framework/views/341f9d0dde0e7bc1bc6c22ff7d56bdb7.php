

<?php $__env->startSection('title', $event->title); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.events.index')); ?>" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800"><?php echo e($event->title); ?></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <?php if($event->cover_image): ?>
                <img src="<?php echo e(asset('storage/' . $event->cover_image)); ?>" alt="<?php echo e($event->title); ?>" class="w-full h-64 object-cover rounded-lg shadow-md">
            <?php endif; ?>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                <p class="text-gray-700"><?php echo e($event->description); ?></p>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <i class="fas fa-user text-red-600 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Organisateur</p>
                            <p class="font-semibold"><?php echo e($event->organizer->name ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-red-600 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Date de début</p>
                            <p class="font-semibold"><?php echo e($event->start_date->translatedFormat('d M Y à H:i')); ?></p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar-check text-red-600 w-5 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-600">Date de fin</p>
                            <p class="font-semibold"><?php echo e($event->end_date->translatedFormat('d M Y à H:i')); ?></p>
                        </div>
                    </div>
                    <?php if($event->venue_name): ?>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-600 w-5 mr-3"></i>
                            <div>
                                <p class="text-sm text-gray-600">Lieu</p>
                                <p class="font-semibold"><?php echo e($event->venue_name); ?>, <?php echo e($event->venue_city); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Total billets</p>
                        <p class="text-2xl font-bold text-red-600"><?php echo e($stats['total_tickets']); ?></p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Revenus</p>
                        <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> XOF</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Billets scannés</p>
                        <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['scanned_tickets']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
                <div class="space-y-3">
                    <?php if(!$event->is_published): ?>
                        <form action="<?php echo e(route('admin.events.approve', $event)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-check mr-2"></i>Approuver et publier
                            </button>
                        </form>
                    <?php endif; ?>
                    <?php if($event->is_published): ?>
                        <form action="<?php echo e(route('admin.events.suspend', $event)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="w-full bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition" onclick="return confirm('Suspendre cet événement ?')">
                                <i class="fas fa-ban mr-2"></i>Suspendre
                            </button>
                        </form>
                    <?php endif; ?>
                    <form action="<?php echo e(route('admin.events.reject', $event)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Rejeter cet événement ?')">
                            <i class="fas fa-times mr-2"></i>Rejeter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/events/show.blade.php ENDPATH**/ ?>