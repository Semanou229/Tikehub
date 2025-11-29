<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard Admin - ' . config('app.name')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-shield-alt text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-red-600">Tikehub</span>
                </a>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Espace Administrateur</p>
                <p class="text-sm font-semibold text-gray-800"><?php echo e(auth()->user()->name); ?></p>
                <p class="text-xs text-gray-500 mt-1"><?php echo e(auth()->user()->email); ?></p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-th-large w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.events.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.events.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-calendar-alt w-5 mr-3"></i>
                    <span>Événements</span>
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.users.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>Utilisateurs</span>
                </a>
                <a href="<?php echo e(route('admin.kyc.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.kyc.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-id-card w-5 mr-3"></i>
                    <span>KYC</span>
                    <?php if(\App\Models\User::where('kyc_status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            <?php echo e(\App\Models\User::where('kyc_status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.reports.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-flag w-5 mr-3"></i>
                    <span>Signalements</span>
                    <?php if(\App\Models\Report::where('status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            <?php echo e(\App\Models\Report::where('status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.payments.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.payments.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-money-bill-wave w-5 mr-3"></i>
                    <span>Paiements</span>
                </a>
                <a href="<?php echo e(route('admin.withdrawals.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.withdrawals.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-hand-holding-usd w-5 mr-3"></i>
                    <span>Retraits</span>
                    <?php if(\App\Models\Withdrawal::where('status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            <?php echo e(\App\Models\Withdrawal::where('status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.contests.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.contests.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-trophy w-5 mr-3"></i>
                    <span>Concours</span>
                </a>
                <a href="<?php echo e(route('admin.fundraisings.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.fundraisings.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-heart w-5 mr-3"></i>
                    <span>Collectes</span>
                </a>
                <a href="<?php echo e(route('admin.settings')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.settings') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-cog w-5 mr-3"></i>
                    <span>Paramètres</span>
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

            <?php if(session('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded">
                    <?php echo e(session('error')); ?>

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

<?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/layouts/admin.blade.php ENDPATH**/ ?>