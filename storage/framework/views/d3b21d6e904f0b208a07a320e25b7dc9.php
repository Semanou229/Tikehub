

<?php $__env->startSection('title', 'Emails Marketing'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Emails Marketing</h1>
            <p class="text-gray-600 mt-1">Créez et envoyez des campagnes email ciblées</p>
        </div>
        <a href="<?php echo e(route('organizer.crm.campaigns.create')); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle campagne
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total campagnes</div>
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['total']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Envoyées</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['sent']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Brouillons</div>
            <div class="text-3xl font-bold text-yellow-600"><?php echo e($stats['draft']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Emails envoyés</div>
            <div class="text-3xl font-bold text-blue-600"><?php echo e(number_format($stats['total_sent'])); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Taux d'ouverture</div>
            <div class="text-3xl font-bold text-purple-600">
                <?php echo e($stats['total_sent'] > 0 ? round(($stats['total_opened'] / $stats['total_sent']) * 100, 1) : 0); ?>%
            </div>
        </div>
    </div>

    <!-- Liste des campagnes -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Campagne</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Segment</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statistiques</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900"><?php echo e($campaign->name); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e($campaign->subject); ?></div>
                            <div class="text-xs text-gray-400 mt-1"><?php echo e($campaign->created_at->format('d/m/Y H:i')); ?></div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <?php echo e($campaign->segment->name ?? 'Tous les contacts'); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                <?php echo e($campaign->status === 'sent' ? 'bg-green-100 text-green-800' : ''); ?>

                                <?php echo e($campaign->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : ''); ?>

                                <?php echo e($campaign->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : ''); ?>

                                <?php echo e($campaign->status === 'sending' ? 'bg-purple-100 text-purple-800' : ''); ?>">
                                <?php echo e(ucfirst($campaign->status)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <div>Envoyés: <strong><?php echo e($campaign->sent_count); ?></strong></div>
                            <div>Ouverts: <strong><?php echo e($campaign->opened_count); ?></strong> 
                                <?php if($campaign->sent_count > 0): ?>
                                    (<?php echo e(round(($campaign->opened_count / $campaign->sent_count) * 100, 1)); ?>%)
                                <?php endif; ?>
                            </div>
                            <div>Clics: <strong><?php echo e($campaign->clicked_count); ?></strong></div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('organizer.crm.campaigns.show', $campaign)); ?>" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <?php if($campaign->status === 'draft'): ?>
                                    <a href="<?php echo e(route('organizer.crm.campaigns.edit', $campaign)); ?>" class="text-gray-600 hover:text-gray-900" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="<?php echo e(route('organizer.crm.campaigns.send', $campaign)); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="text-green-600 hover:text-green-900" title="Envoyer" onclick="return confirm('Êtes-vous sûr de vouloir envoyer cette campagne ?')">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-envelope text-4xl mb-3 text-gray-300"></i>
                            <p>Aucune campagne trouvée</p>
                            <a href="<?php echo e(route('organizer.crm.campaigns.create')); ?>" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                                Créer votre première campagne
                            </a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($campaigns->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($campaigns->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/campaigns/index.blade.php ENDPATH**/ ?>