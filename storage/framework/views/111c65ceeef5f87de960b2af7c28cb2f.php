

<?php $__env->startSection('title', 'Formulaires'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Formulaires Personnalisés</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Créez des formulaires pour collecter des informations</p>
        </div>
        <a href="<?php echo e(route('organizer.crm.forms.create')); ?>" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouveau formulaire</span><span class="sm:hidden">Nouveau</span>
        </a>
    </div>

    <!-- Liste des formulaires -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $form): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800"><?php echo e($form->name); ?></h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full <?php echo e($form->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                        <?php echo e($form->is_active ? 'Actif' : 'Inactif'); ?>

                    </span>
                </div>
                <?php if($form->description): ?>
                    <p class="text-gray-600 text-sm mb-4"><?php echo e(Str::limit($form->description, 100)); ?></p>
                <?php endif; ?>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-file-alt mr-1"></i><?php echo e($form->submissions_count); ?> soumissions
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        <?php echo e(ucfirst($form->form_type)); ?>

                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('organizer.crm.forms.show', $form)); ?>" class="flex-1 text-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                        <i class="fas fa-eye mr-1"></i>Voir
                    </a>
                    <a href="<?php echo e(route('organizer.crm.forms.edit', $form)); ?>" class="text-gray-600 hover:text-gray-900 px-4 py-2">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="md:col-span-3 bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-file-alt text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucun formulaire créé</p>
                <a href="<?php echo e(route('organizer.crm.forms.create')); ?>" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre premier formulaire
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if($forms->hasPages()): ?>
        <div class="mt-4">
            <?php echo e($forms->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/forms/index.blade.php ENDPATH**/ ?>