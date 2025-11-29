<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Collaborateur - ' . config('app.name')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-blue-600">Tikehub</span>
                </a>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Espace Collaborateur</p>
                <p class="text-sm font-semibold text-gray-800"><?php echo e(auth()->user()->name); ?></p>
                <?php if(auth()->user()->team): ?>
                    <p class="text-xs text-gray-500 mt-1"><?php echo e(auth()->user()->team->name); ?></p>
                <?php endif; ?>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="<?php echo e(route('collaborator.dashboard')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('collaborator.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-th-large w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('collaborator.events.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('collaborator.events.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i>
                    <span>Mes Événements</span>
                </a>
                <a href="<?php echo e(route('collaborator.tasks.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('collaborator.tasks.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-tasks w-5 mr-3"></i>
                    <span>Mes Tâches</span>
                </a>
                <a href="<?php echo e(route('collaborator.profile.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('collaborator.profile.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-user w-5 mr-3"></i>
                    <span>Mon Profil</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php if(isset($errors) && $errors->any()): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/layouts/collaborator.blade.php ENDPATH**/ ?>