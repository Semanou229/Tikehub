

<?php $__env->startSection('title', 'Gestion des Événements'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Événements</h1>
        <a href="<?php echo e(route('admin.events.create')); ?>" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvel événement
        </a>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.events.index')); ?>" class="flex gap-4">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Rechercher..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous les statuts</option>
                <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>Publié</option>
                <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>Brouillon</option>
                <option value="cancelled" <?php echo e(request('status') === 'cancelled' ? 'selected' : ''); ?>>Annulé</option>
            </select>
            <select name="published" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous</option>
                <option value="1" <?php echo e(request('published') === '1' ? 'selected' : ''); ?>>Publiés</option>
                <option value="0" <?php echo e(request('published') === '0' ? 'selected' : ''); ?>>Non publiés</option>
            </select>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des événements -->
    <?php if($events->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($event->title); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($event->category); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($event->organizer->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($event->start_date->translatedFormat('d M Y à H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($event->is_published): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                    <?php endif; ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800 ml-2">
                                        <?php echo e(ucfirst($event->status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <div class="flex gap-2">
                                        <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="text-red-600 hover:text-red-900" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.events.edit', $event)); ?>" class="text-blue-600 hover:text-blue-900" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if(!$event->is_published): ?>
                                            <form action="<?php echo e(route('admin.events.approve', $event)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-green-600 hover:text-green-900" onclick="return confirm('Approuver cet événement ?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                        <?php if($event->is_published): ?>
                                            <form action="<?php echo e(route('admin.events.suspend', $event)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="text-orange-600 hover:text-orange-900" onclick="return confirm('Suspendre cet événement ?')">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                <?php echo e($events->links()); ?>

            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-400 mb-4"></i>
            <p class="text-gray-500">Aucun événement trouvé</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/events/index.blade.php ENDPATH**/ ?>