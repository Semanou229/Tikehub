<?php $__env->startSection('title', $form->name); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800"><?php echo e($form->name); ?></h1>
            <?php if($form->description): ?>
                <p class="text-gray-600 mt-1"><?php echo e($form->description); ?></p>
            <?php endif; ?>
        </div>
        <div class="flex gap-3">
            <a href="<?php echo e(route('organizer.crm.forms.edit', $form)); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="<?php echo e(route('organizer.crm.forms.submissions', $form)); ?>" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-list mr-2"></i>Voir les soumissions
            </a>
            <a href="<?php echo e(route('organizer.crm.forms.index')); ?>" class="text-indigo-600 hover:text-indigo-800 px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total soumissions</div>
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['total_submissions']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">En attente</div>
            <div class="text-3xl font-bold text-yellow-600"><?php echo e($stats['pending']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Approuvées</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['approved']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Rejetées</div>
            <div class="text-3xl font-bold text-red-600"><?php echo e($stats['rejected']); ?></div>
        </div>
    </div>

    <!-- Informations -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Informations</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Type:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        <?php echo e(ucfirst($form->form_type)); ?>

                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Statut:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full <?php echo e($form->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                        <?php echo e($form->is_active ? 'Actif' : 'Inactif'); ?>

                    </span>
                </div>
                <?php if($form->event): ?>
                    <div>
                        <span class="text-sm text-gray-600">Événement:</span>
                        <span class="ml-2"><?php echo e($form->event->title); ?></span>
                    </div>
                <?php endif; ?>
                <div>
                    <span class="text-sm text-gray-600">Approbation requise:</span>
                    <span class="ml-2"><?php echo e($form->requires_approval ? 'Oui' : 'Non'); ?></span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Lien public:</span>
                    <div class="mt-1 flex items-center gap-2">
                        <input type="text" readonly value="<?php echo e(url('/form/' . $form->slug)); ?>" id="formLink" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-sm">
                        <button onclick="copyLink()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="font-bold text-gray-800 mb-4">Aperçu du formulaire</h3>
            <div class="space-y-4">
                <?php $__currentLoopData = $form->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-800"><?php echo e($field['label'] ?? 'Champ'); ?></span>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                <?php echo e(ucfirst($field['type'] ?? 'text')); ?>

                            </span>
                        </div>
                        <?php if(isset($field['required']) && $field['required']): ?>
                            <span class="text-xs text-red-600 mt-1">* Obligatoire</span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function copyLink() {
    const input = document.getElementById('formLink');
    input.select();
    input.setSelectionRange(0, 99999); // Pour mobile
    document.execCommand('copy');
    alert('Lien copié dans le presse-papiers !');
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/crm/forms/show.blade.php ENDPATH**/ ?>