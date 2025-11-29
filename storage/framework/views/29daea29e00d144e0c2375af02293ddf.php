

<?php $__env->startSection('title', 'Mes Paiements'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Historique des Paiements</h1>
    </div>

    <?php if($payments->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($payment->created_at->translatedFormat('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php if($payment->event): ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                                            <div>
                                                <div class="font-medium"><?php echo e($payment->event->title); ?></div>
                                                <?php if($payment->event->is_virtual): ?>
                                                    <span class="text-xs text-blue-600">Événement virtuel</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php elseif($payment->paymentable): ?>
                                        <div class="flex items-center">
                                            <?php if($payment->paymentable_type === 'App\Models\Contest'): ?>
                                                <i class="fas fa-trophy text-purple-600 mr-2"></i>
                                            <?php elseif($payment->paymentable_type === 'App\Models\Fundraising'): ?>
                                                <i class="fas fa-heart text-red-600 mr-2"></i>
                                            <?php else: ?>
                                                <i class="fas fa-receipt text-gray-600 mr-2"></i>
                                            <?php endif; ?>
                                            <div>
                                                <div class="font-medium"><?php echo e($payment->paymentable->name ?? $payment->paymentable->title ?? 'N/A'); ?></div>
                                                <span class="text-xs text-gray-500"><?php echo e(class_basename($payment->paymentable_type)); ?></span>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500">Paiement</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php echo e(ucfirst($payment->payment_method ?? 'N/A')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    <?php echo e(number_format($payment->amount, 0, ',', ' ')); ?> XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php echo e($payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                        <?php if($payment->status === 'completed'): ?>
                                            <i class="fas fa-check-circle mr-1"></i>Complété
                                        <?php elseif($payment->status === 'pending'): ?>
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        <?php elseif($payment->status === 'failed'): ?>
                                            <i class="fas fa-times-circle mr-1"></i>Échoué
                                        <?php else: ?>
                                            <?php echo e(ucfirst($payment->status)); ?>

                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono text-xs">
                                    <?php echo e($payment->moneroo_reference ?? 'N/A'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <?php echo e($payments->links()); ?>

        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun paiement enregistré</p>
            <a href="<?php echo e(route('home')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Découvrir des événements
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.buyer-dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/buyer/payments.blade.php ENDPATH**/ ?>