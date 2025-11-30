

<?php $__env->startSection('title', 'Nouveau Sponsor'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Nouveau Sponsor</h1>
        <a href="<?php echo e(route('organizer.crm.sponsors.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm sm:text-base min-h-[44px] flex items-center">
            <i class="fas fa-arrow-left text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
        <form action="<?php echo e(route('organizer.crm.sponsors.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Nom *</label>
                    <input type="text" name="name" value="<?php echo e(old('name')); ?>" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs sm:text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Entreprise</label>
                    <input type="text" name="company" value="<?php echo e(old('company')); ?>" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs sm:text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Téléphone</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Type de sponsor *</label>
                    <select name="sponsor_type" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        <option value="gold" <?php echo e(old('sponsor_type') == 'gold' ? 'selected' : ''); ?>>Gold</option>
                        <option value="silver" <?php echo e(old('sponsor_type') == 'silver' ? 'selected' : ''); ?>>Silver</option>
                        <option value="bronze" <?php echo e(old('sponsor_type') == 'bronze' ? 'selected' : ''); ?>>Bronze</option>
                        <option value="partner" <?php echo e(old('sponsor_type') == 'partner' ? 'selected' : ''); ?>>Partenaire</option>
                        <option value="media" <?php echo e(old('sponsor_type') == 'media' ? 'selected' : ''); ?>>Média</option>
                        <option value="other" <?php echo e(old('sponsor_type') == 'other' ? 'selected' : ''); ?>>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Statut *</label>
                    <select name="status" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        <option value="prospect" <?php echo e(old('status') == 'prospect' ? 'selected' : ''); ?>>Prospect</option>
                        <option value="negotiating" <?php echo e(old('status') == 'negotiating' ? 'selected' : ''); ?>>En négociation</option>
                        <option value="confirmed" <?php echo e(old('status') == 'confirmed' ? 'selected' : ''); ?>>Confirmé</option>
                        <option value="delivered" <?php echo e(old('status') == 'delivered' ? 'selected' : ''); ?>>Livré</option>
                        <option value="closed" <?php echo e(old('status') == 'closed' ? 'selected' : ''); ?>>Clôturé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Montant de contribution *</label>
                    <input type="number" name="contribution_amount" value="<?php echo e(old('contribution_amount', 0)); ?>" step="0.01" min="0" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <?php $__errorArgs = ['contribution_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs sm:text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Devise *</label>
                    <select name="currency" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        <option value="XOF" <?php echo e(old('currency', 'XOF') == 'XOF' ? 'selected' : ''); ?>>XOF</option>
                        <option value="EUR" <?php echo e(old('currency') == 'EUR' ? 'selected' : ''); ?>>EUR</option>
                        <option value="USD" <?php echo e(old('currency') == 'USD' ? 'selected' : ''); ?>>USD</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Événement</label>
                    <select name="event_id" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        <option value="">Aucun événement spécifique</option>
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($event->id); ?>" <?php echo e(old('event_id') == $event->id ? 'selected' : ''); ?>><?php echo e($event->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Contact existant</label>
                    <select name="contact_id" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        <option value="">Créer un nouveau contact</option>
                        <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($contact->id); ?>" <?php echo e(old('contact_id') == $contact->id ? 'selected' : ''); ?>><?php echo e($contact->full_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Date début contrat</label>
                    <input type="date" name="contract_start_date" value="<?php echo e(old('contract_start_date')); ?>" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Date fin contrat</label>
                    <input type="date" name="contract_end_date" value="<?php echo e(old('contract_end_date')); ?>" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Avantages accordés</label>
                    <textarea name="benefits" rows="4" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"><?php echo e(old('benefits')); ?></textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Notes</label>
                    <textarea name="notes" rows="3" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"><?php echo e(old('notes')); ?></textarea>
                </div>
            </div>

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 sm:px-6 lg:px-8 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-semibold text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                    <i class="fas fa-save text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Créer le sponsor
                </button>
                <a href="<?php echo e(route('organizer.crm.sponsors.index')); ?>" class="text-gray-600 hover:text-gray-800 active:text-gray-900 text-center sm:text-left py-2.5 sm:py-0 text-xs sm:text-sm min-h-[40px] sm:min-h-[44px] flex items-center justify-center sm:justify-start">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/sponsors/create.blade.php ENDPATH**/ ?>