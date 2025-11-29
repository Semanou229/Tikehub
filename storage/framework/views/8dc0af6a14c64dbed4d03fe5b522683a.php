

<?php $__env->startSection('title', 'Détails du Paiement #' . $payment->id); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Paiement #<?php echo e($payment->id); ?></h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Utilisateur</p>
                    <p class="font-semibold"><?php echo e($payment->user->name ?? 'N/A'); ?></p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Montant</p>
                    <p class="font-semibold text-lg"><?php echo e(number_format($payment->amount, 0, ',', ' ')); ?> XOF</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Commission plateforme</p>
                    <p class="font-semibold"><?php echo e(number_format($payment->platform_commission ?? 0, 0, ',', ' ')); ?> XOF</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Statut</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($payment->status === 'completed' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')); ?>">
                        <?php echo e(ucfirst($payment->status)); ?>

                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date</p>
                    <p class="font-semibold"><?php echo e($payment->created_at->translatedFormat('d M Y à H:i')); ?></p>
                </div>
                <?php if($payment->moneroo_reference): ?>
                    <div>
                        <p class="text-sm text-gray-600">Référence Moneroo</p>
                        <p class="font-mono text-sm"><?php echo e($payment->moneroo_reference); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Détails</h2>
            <div class="space-y-3">
                <?php if($payment->tickets->count() > 0): ?>
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Événement</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Événement</p>
                        <p class="font-semibold"><?php echo e($payment->tickets->first()->event->title ?? 'N/A'); ?></p>
                    </div>
                <?php elseif($payment->votes->count() > 0): ?>
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Concours</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Concours</p>
                        <p class="font-semibold"><?php echo e($payment->votes->first()->contest->name ?? 'N/A'); ?></p>
                    </div>
                <?php elseif($payment->donation): ?>
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Collecte</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Collecte</p>
                        <p class="font-semibold"><?php echo e($payment->donation->fundraising->name ?? 'N/A'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/payments/show.blade.php ENDPATH**/ ?>