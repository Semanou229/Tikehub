

<?php $__env->startSection('title', 'Paramètres de la Plateforme'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Paramètres de la Plateforme</h1>
        <p class="text-gray-600 mt-2">Gérez les paramètres généraux de la plateforme</p>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <p class="text-green-800"><?php echo e(session('success')); ?></p>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <p class="text-red-800"><?php echo e(session('error')); ?></p>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $groupSettings): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-600 capitalize">
                    <?php echo e(str_replace('_', ' ', $group)); ?>

                </h2>
                
                <div class="space-y-4">
                    <?php $__currentLoopData = $groupSettings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $setting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <?php echo e($setting->description ?? ucfirst(str_replace('_', ' ', $setting->key))); ?>

                            </label>
                            
                            <?php if($setting->type === 'boolean'): ?>
                                <label class="flex items-center">
                                    <input type="checkbox" name="settings[<?php echo e($setting->key); ?>]" value="1" 
                                        <?php echo e($setting->value == '1' ? 'checked' : ''); ?>

                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">Activer</span>
                                </label>
                            <?php elseif($setting->type === 'json'): ?>
                                <textarea name="settings[<?php echo e($setting->key); ?>]" rows="4" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"><?php echo e(is_string($setting->value) ? $setting->value : json_encode($setting->value)); ?></textarea>
                            <?php elseif($setting->type === 'integer' || $setting->type === 'float'): ?>
                                <input type="number" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" 
                                    step="<?php echo e($setting->type === 'float' ? '0.01' : '1'); ?>"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php else: ?>
                                <input type="text" name="settings[<?php echo e($setting->key); ?>]" value="<?php echo e($setting->value); ?>" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <?php endif; ?>
                            
                            <p class="text-xs text-gray-500 mt-1">Type: <?php echo e($setting->type); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                <i class="fas fa-save mr-2"></i>Enregistrer les paramètres
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/settings/index.blade.php ENDPATH**/ ?>