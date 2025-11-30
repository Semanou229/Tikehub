<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Dashboard - ' . config('app.name')); ?></title>
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
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-indigo-600">Tikehub</span>
                </a>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Espace Organisateur</p>
                <p class="text-sm font-semibold text-gray-800"><?php echo e(auth()->user()->email); ?></p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-th-large w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?php echo e(route('organizer.events.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.events.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-calendar-plus w-5 mr-3"></i>
                    <span>Mes Événements</span>
                </a>
                <a href="<?php echo e(route('organizer.contests.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.contests.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-trophy w-5 mr-3"></i>
                    <span>Mes Concours</span>
                </a>
                <a href="<?php echo e(route('organizer.fundraisings.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.fundraisings.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-heart w-5 mr-3"></i>
                    <span>Mes Collectes</span>
                </a>
                <a href="<?php echo e(route('organizer.wallet.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.wallet.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-wallet w-5 mr-3"></i>
                    <span>Portefeuille</span>
                </a>
                <a href="<?php echo e(route('organizer.payments.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.payments.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-credit-card w-5 mr-3"></i>
                    <span>Paiements</span>
                </a>
                <a href="<?php echo e(route('organizer.reports.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.reports.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    <span>Rapports</span>
                </a>
                <a href="<?php echo e(route('organizer.promo-codes.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.promo-codes.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-tag w-5 mr-3"></i>
                    <span>Codes Promo</span>
                </a>
                <!-- CRM Section -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="px-4 text-xs font-semibold text-gray-500 uppercase mb-2">CRM</p>
                    <a href="<?php echo e(route('organizer.crm.contacts.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.contacts.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-address-book w-5 mr-3"></i>
                        <span>Contacts</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.pipeline.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.pipeline.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-project-diagram w-5 mr-3"></i>
                        <span>Pipeline</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.campaigns.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.campaigns.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-envelope w-5 mr-3"></i>
                        <span>Emails Marketing</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.automations.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.automations.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-cogs w-5 mr-3"></i>
                        <span>Automations</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.sponsors.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.sponsors.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-handshake w-5 mr-3"></i>
                        <span>Sponsors</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.teams.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.teams.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-users-cog w-5 mr-3"></i>
                        <span>Équipe</span>
                    </a>
                    <a href="<?php echo e(route('organizer.crm.forms.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.crm.forms.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                        <i class="fas fa-file-alt w-5 mr-3"></i>
                        <span>Formulaires</span>
                    </a>
                </div>
                <a href="<?php echo e(route('organizer.notifications.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.notifications.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-bell w-5 mr-3"></i>
                    <span>Notifications</span>
                </a>
                <a href="<?php echo e(route('support.tickets.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('support.tickets.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-headset w-5 mr-3"></i>
                    <span>Support</span>
                </a>
                <a href="<?php echo e(route('organizer.profile.index')); ?>" class="flex items-center px-4 py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('organizer.profile.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?>">
                    <i class="fas fa-user w-5 mr-3"></i>
                    <span>Mon Compte</span>
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

<?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/layouts/dashboard.blade.php ENDPATH**/ ?>