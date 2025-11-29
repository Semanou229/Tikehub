

<?php $__env->startSection('title', $form->name); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2"><?php echo e($form->name); ?></h1>
                <?php if($form->description): ?>
                    <p class="text-gray-600"><?php echo e($form->description); ?></p>
                <?php endif; ?>
            </div>

            <?php if(session('success')): ?>
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('forms.submit', $form->slug)); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>

                <!-- Informations du soumissionnaire -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Vos informations</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                            <input type="text" name="submitter_name" value="<?php echo e(old('submitter_name')); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <?php $__errorArgs = ['submitter_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="submitter_email" value="<?php echo e(old('submitter_email')); ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <?php $__errorArgs = ['submitter_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" name="submitter_phone" value="<?php echo e(old('submitter_phone')); ?>" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            <?php $__errorArgs = ['submitter_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Champs du formulaire -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Formulaire</h3>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $form->fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <?php echo e($field['label'] ?? 'Champ'); ?>

                                    <?php if(isset($field['required']) && $field['required']): ?>
                                        <span class="text-red-500">*</span>
                                    <?php endif; ?>
                                </label>
                                
                                <?php if($field['type'] === 'textarea'): ?>
                                    <textarea name="field_<?php echo e($index); ?>" <?php echo e((isset($field['required']) && $field['required']) ? 'required' : ''); ?> rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"><?php echo e(old('field_' . $index)); ?></textarea>
                                <?php elseif($field['type'] === 'select'): ?>
                                    <select name="field_<?php echo e($index); ?>" <?php echo e((isset($field['required']) && $field['required']) ? 'required' : ''); ?> class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Sélectionnez...</option>
                                        <!-- Options à ajouter dynamiquement si nécessaire -->
                                    </select>
                                <?php elseif($field['type'] === 'checkbox'): ?>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="field_<?php echo e($index); ?>" value="1" <?php echo e((isset($field['required']) && $field['required']) ? 'required' : ''); ?> class="mr-2">
                                        <span class="text-sm text-gray-700">Oui</span>
                                    </label>
                                <?php elseif($field['type'] === 'file'): ?>
                                    <input type="file" name="field_<?php echo e($index); ?>" <?php echo e((isset($field['required']) && $field['required']) ? 'required' : ''); ?> class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <?php else: ?>
                                    <input type="<?php echo e($field['type'] === 'email' ? 'email' : ($field['type'] === 'phone' ? 'tel' : 'text')); ?>" 
                                           name="field_<?php echo e($index); ?>" 
                                           value="<?php echo e(old('field_' . $index)); ?>"
                                           <?php echo e((isset($field['required']) && $field['required']) ? 'required' : ''); ?>

                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                <?php endif; ?>
                                
                                <?php $__errorArgs = ['field_' . $index];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Soumettre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/forms/public/show.blade.php ENDPATH**/ ?>