

<?php $__env->startSection('title', 'Rapports'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Rapports</h1>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total événements</div>
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['total_events']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Billets vendus</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['total_tickets_sold']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Revenus totaux</div>
            <div class="text-3xl font-bold text-purple-600"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Paiements en attente</div>
            <div class="text-3xl font-bold text-orange-600"><?php echo e($stats['pending_payments']); ?></div>
        </div>
    </div>

    <!-- Liste des événements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Rapports par événement</h2>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Billets vendus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($event->title); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($event->start_date->format('d/m/Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($event->tickets_sold ?? 0); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                            <?php echo e(number_format($event->revenue ?? 0, 0, ',', ' ')); ?> XOF
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="<?php echo e(route('organizer.reports.event', $event)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                <i class="fas fa-eye mr-1"></i>Voir
                            </a>
                            <a href="<?php echo e(route('organizer.reports.export', [$event, 'csv'])); ?>" class="text-green-600 hover:text-green-900 mr-3">
                                <i class="fas fa-download mr-1"></i>CSV
                            </a>
                            <a href="<?php echo e(route('organizer.reports.export', [$event, 'excel'])); ?>" class="text-blue-600 hover:text-blue-900">
                                <i class="fas fa-file-excel mr-1"></i>Excel
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/reports/index.blade.php ENDPATH**/ ?>