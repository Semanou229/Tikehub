

<?php $__env->startSection('title', 'Inscription - Tikehub'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-md mx-auto mt-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-center">Inscription</h2>
        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom complet</label>
                <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Téléphone (optionnel)</label>
                <input type="text" name="phone" id="phone" value="<?php echo e(old('phone')); ?>"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Mot de passe</label>
                <input type="password" name="password" id="password" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Type de compte</label>
                <div class="flex space-x-4">
                    <label class="flex items-center">
                        <input type="radio" name="role" value="buyer" checked class="mr-2">
                        <span>Acheteur</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" name="role" value="organizer" class="mr-2">
                        <span>Organisateur</span>
                    </label>
                </div>
            </div>
            <button type="submit" class="bg-indigo-600 text-white font-bold py-2 px-4 rounded w-full hover:bg-indigo-700">
                S'inscrire
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/auth/register.blade.php ENDPATH**/ ?>