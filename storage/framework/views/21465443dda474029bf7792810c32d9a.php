

<?php $__env->startSection('title', 'Signalements - Administration'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des signalements</h1>
        <p class="text-gray-600 mt-2">Examiner et traiter les signalements de contenu</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-600 text-sm font-medium">En attente</p>
                    <p class="text-2xl font-bold text-red-800"><?php echo e($stats['pending']); ?></p>
                </div>
                <i class="fas fa-clock text-red-400 text-2xl"></i>
            </div>
        </div>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-600 text-sm font-medium">Examinés</p>
                    <p class="text-2xl font-bold text-blue-800"><?php echo e($stats['reviewed']); ?></p>
                </div>
                <i class="fas fa-eye text-blue-400 text-2xl"></i>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium">Résolus</p>
                    <p class="text-2xl font-bold text-green-800"><?php echo e($stats['resolved']); ?></p>
                </div>
                <i class="fas fa-check-circle text-green-400 text-2xl"></i>
            </div>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Rejetés</p>
                    <p class="text-2xl font-bold text-gray-800"><?php echo e($stats['dismissed']); ?></p>
                </div>
                <i class="fas fa-times-circle text-gray-400 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="<?php echo e(route('admin.reports.index')); ?>" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Tous</option>
                    <option value="pending" <?php echo e(request('status') === 'pending' ? 'selected' : ''); ?>>En attente</option>
                    <option value="reviewed" <?php echo e(request('status') === 'reviewed' ? 'selected' : ''); ?>>Examinés</option>
                    <option value="resolved" <?php echo e(request('status') === 'resolved' ? 'selected' : ''); ?>>Résolus</option>
                    <option value="dismissed" <?php echo e(request('status') === 'dismissed' ? 'selected' : ''); ?>>Rejetés</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Raison</label>
                <select name="reason" class="px-4 py-2 border border-gray-300 rounded-lg">
                    <option value="">Toutes</option>
                    <option value="inappropriate_content" <?php echo e(request('reason') === 'inappropriate_content' ? 'selected' : ''); ?>>Contenu inapproprié</option>
                    <option value="false_information" <?php echo e(request('reason') === 'false_information' ? 'selected' : ''); ?>>Informations erronées</option>
                    <option value="spam" <?php echo e(request('reason') === 'spam' ? 'selected' : ''); ?>>Spam</option>
                    <option value="scam" <?php echo e(request('reason') === 'scam' ? 'selected' : ''); ?>>Arnaque</option>
                    <option value="copyright" <?php echo e(request('reason') === 'copyright' ? 'selected' : ''); ?>>Violation de droits d'auteur</option>
                    <option value="other" <?php echo e(request('reason') === 'other' ? 'selected' : ''); ?>>Autre</option>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                    <i class="fas fa-filter mr-2"></i>Filtrer
                </button>
            </div>
        </form>
    </div>

    <!-- Liste des signalements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contenu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Raison</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Signalé par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-calendar-alt mr-1"></i>Événement
                                    </span>
                                <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                        <i class="fas fa-trophy mr-1"></i>Concours
                                    </span>
                                <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-hand-holding-heart mr-1"></i>Collecte
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                        <?php echo e($report->reportable->title ?? 'N/A'); ?>

                                    <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                        <?php echo e($report->reportable->name ?? 'N/A'); ?>

                                    <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                        <?php echo e($report->reportable->name ?? 'N/A'); ?>

                                    <?php endif; ?>
                                </div>
                                <div class="text-xs text-gray-500">
                                    <?php echo e(Str::limit($report->message, 50)); ?>

                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php if($report->reason === 'inappropriate_content'): ?> bg-red-100 text-red-800
                                    <?php elseif($report->reason === 'scam'): ?> bg-orange-100 text-orange-800
                                    <?php else: ?> bg-yellow-100 text-yellow-800
                                    <?php endif; ?>">
                                    <?php echo e($report->reason_label); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($report->reporter->name ?? 'Utilisateur'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($report->created_at->translatedFormat('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    <?php if($report->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($report->status === 'reviewed'): ?> bg-blue-100 text-blue-800
                                    <?php elseif($report->status === 'resolved'): ?> bg-green-100 text-green-800
                                    <?php else: ?> bg-gray-100 text-gray-800
                                    <?php endif; ?>">
                                    <?php echo e($report->status_label); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="<?php echo e(route('admin.reports.show', $report)); ?>" 
                                   class="text-red-600 hover:text-red-900">
                                    <i class="fas fa-eye mr-1"></i>Examiner
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Aucun signalement trouvé
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if($reports->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($reports->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/reports/index.blade.php ENDPATH**/ ?>