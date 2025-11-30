

<?php $__env->startSection('title', $campaign->name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?php echo e($campaign->name); ?></h1>
            <p class="text-gray-600 mt-1"><?php echo e($campaign->subject); ?></p>
        </div>
        <div class="flex gap-3">
            <?php if($campaign->status === 'draft'): ?>
                <a href="<?php echo e(route('organizer.crm.campaigns.edit', $campaign)); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
                <form action="<?php echo e(route('organizer.crm.campaigns.send', $campaign)); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition" onclick="return confirm('Êtes-vous sûr de vouloir envoyer cette campagne ?')">
                        <i class="fas fa-paper-plane mr-2"></i>Envoyer maintenant
                    </button>
                </form>
            <?php endif; ?>
            <a href="<?php echo e(route('organizer.crm.campaigns.index')); ?>" class="text-indigo-600 hover:text-indigo-800 px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Envoyés</div>
            <div class="text-3xl font-bold text-blue-600"><?php echo e($stats['sent']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Ouverts</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['opened']); ?></div>
            <?php if($stats['sent'] > 0): ?>
                <div class="text-xs text-gray-500 mt-1"><?php echo e(round(($stats['opened'] / $stats['sent']) * 100, 1)); ?>%</div>
            <?php endif; ?>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Clics</div>
            <div class="text-3xl font-bold text-purple-600"><?php echo e($stats['clicked']); ?></div>
            <?php if($stats['sent'] > 0): ?>
                <div class="text-xs text-gray-500 mt-1"><?php echo e(round(($stats['clicked'] / $stats['sent']) * 100, 1)); ?>%</div>
            <?php endif; ?>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Rebonds</div>
            <div class="text-3xl font-bold text-red-600"><?php echo e($stats['bounced']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">En attente</div>
            <div class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></div>
        </div>
    </div>

    <!-- Détails -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Informations</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Statut:</span>
                    <?php
                        $statusLabels = [
                            'sent' => 'Envoyée',
                            'draft' => 'Brouillon',
                            'scheduled' => 'Planifiée',
                            'sending' => 'En cours'
                        ];
                        $statusLabel = $statusLabels[$campaign->status] ?? ucfirst($campaign->status);
                    ?>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                        <?php echo e($campaign->status === 'sent' ? 'bg-green-100 text-green-800' : ''); ?>

                        <?php echo e($campaign->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                        <?php echo e($campaign->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : ''); ?>

                        <?php echo e($campaign->status === 'sending' ? 'bg-purple-100 text-purple-800' : ''); ?>">
                        <?php echo e($statusLabel); ?>

                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Segment:</span>
                    <span class="ml-2 font-semibold"><?php echo e($campaign->segment->name ?? 'Tous les contacts'); ?></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Type:</span>
                    <span class="ml-2"><?php echo e(ucfirst($campaign->template_type)); ?></span>
                </div>
                <?php if($campaign->sent_at): ?>
                    <div>
                        <span class="text-sm text-gray-600">Envoyé le:</span>
                        <span class="ml-2"><?php echo e($campaign->sent_at->format('d/m/Y H:i')); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Aperçu</h3>
            <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                <div class="font-semibold mb-2"><?php echo e($campaign->subject); ?></div>
                <div class="text-sm text-gray-700 whitespace-pre-wrap"><?php echo e(Str::limit($campaign->content, 200)); ?></div>
            </div>
        </div>
    </div>

    <!-- Contenu complet -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="font-bold text-gray-800 mb-4">Contenu complet</h3>
        <div class="prose max-w-none">
            <div class="whitespace-pre-wrap text-gray-700"><?php echo e($campaign->content); ?></div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/campaigns/show.blade.php ENDPATH**/ ?>