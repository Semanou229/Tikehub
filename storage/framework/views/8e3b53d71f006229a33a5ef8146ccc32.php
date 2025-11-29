

<?php $__env->startSection('title', 'Détails du signalement - Administration'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.reports.index')); ?>" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Détails du signalement</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations du signalement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations du signalement</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type de contenu</label>
                        <div class="flex items-center gap-2">
                            <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-calendar-alt mr-1"></i>Événement
                                </span>
                            <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                                    <i class="fas fa-trophy mr-1"></i>Concours
                                </span>
                            <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-hand-holding-heart mr-1"></i>Collecte
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenu signalé</label>
                        <p class="text-gray-900 font-semibold">
                            <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                <?php echo e($report->reportable->title ?? 'N/A'); ?>

                            <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                <?php echo e($report->reportable->name ?? 'N/A'); ?>

                            <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                <?php echo e($report->reportable->name ?? 'N/A'); ?>

                            <?php endif; ?>
                        </p>
                        <a href="<?php if($report->reportable_type === 'App\Models\Event'): ?><?php echo e(route('events.show', $report->reportable)); ?><?php elseif($report->reportable_type === 'App\Models\Contest'): ?><?php echo e(route('contests.show', $report->reportable)); ?><?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?><?php echo e(route('fundraisings.show', $report->reportable)); ?><?php endif; ?>" 
                           target="_blank" 
                           class="text-red-600 hover:text-red-800 text-sm mt-1 inline-block">
                            <i class="fas fa-external-link-alt mr-1"></i>Voir le contenu
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Raison du signalement</label>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            <?php if($report->reason === 'inappropriate_content'): ?> bg-red-100 text-red-800
                            <?php elseif($report->reason === 'scam'): ?> bg-orange-100 text-orange-800
                            <?php else: ?> bg-yellow-100 text-yellow-800
                            <?php endif; ?>">
                            <?php echo e($report->reason_label); ?>

                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message du signalant</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap"><?php echo e($report->message); ?></p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Signalé par</label>
                            <p class="text-gray-900"><?php echo e($report->reporter->name ?? 'Utilisateur'); ?></p>
                            <p class="text-sm text-gray-500"><?php echo e($report->reporter->email ?? 'N/A'); ?></p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date du signalement</label>
                            <p class="text-gray-900"><?php echo e($report->created_at->translatedFormat('d/m/Y à H:i')); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes admin -->
            <?php if($report->admin_notes): ?>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Notes de l'administrateur</h3>
                    <p class="text-blue-900 whitespace-pre-wrap"><?php echo e($report->admin_notes); ?></p>
                    <?php if($report->reviewer): ?>
                        <p class="text-sm text-blue-700 mt-2">
                            Par <?php echo e($report->reviewer->name); ?> le <?php echo e($report->reviewed_at->translatedFormat('d/m/Y à H:i')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Actions -->
        <div class="space-y-6">
            <!-- Statut actuel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statut actuel</h3>
                <span class="px-4 py-2 text-sm font-semibold rounded-full 
                    <?php if($report->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                    <?php elseif($report->status === 'reviewed'): ?> bg-blue-100 text-blue-800
                    <?php elseif($report->status === 'resolved'): ?> bg-green-100 text-green-800
                    <?php else: ?> bg-gray-100 text-gray-800
                    <?php endif; ?>">
                    <?php echo e($report->status_label); ?>

                </span>
            </div>

            <!-- Formulaire de traitement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Traiter le signalement</h3>
                <form method="POST" action="<?php echo e(route('admin.reports.update', $report)); ?>">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="pending" <?php echo e($report->status === 'pending' ? 'selected' : ''); ?>>En attente</option>
                            <option value="reviewed" <?php echo e($report->status === 'reviewed' ? 'selected' : ''); ?>>Examiné</option>
                            <option value="resolved" <?php echo e($report->status === 'resolved' ? 'selected' : ''); ?>>Résolu</option>
                            <option value="dismissed" <?php echo e($report->status === 'dismissed' ? 'selected' : ''); ?>>Rejeté</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                        <textarea name="admin_notes" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Ajoutez des notes sur le traitement de ce signalement..."><?php echo e($report->admin_notes); ?></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/reports/show.blade.php ENDPATH**/ ?>