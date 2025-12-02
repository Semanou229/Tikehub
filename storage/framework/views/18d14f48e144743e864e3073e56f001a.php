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
    <style>
        @media (max-width: 768px) {
            #mobile-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            #mobile-sidebar.open {
                transform: translateX(0);
            }
            #sidebar-overlay {
                display: none;
            }
            #sidebar-overlay.open {
                display: block;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">
    <!-- Overlay pour mobile -->
    <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" onclick="toggleSidebar()"></div>
    
    <div class="flex flex-col lg:flex-row h-screen overflow-hidden">
        <!-- Bouton hamburger mobile -->
        <button id="mobile-menu-button" onclick="toggleSidebar()" class="lg:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded-lg shadow-lg hover:bg-gray-100 transition min-w-[44px] min-h-[44px] flex items-center justify-center">
            <i class="fas fa-bars text-xl text-gray-700"></i>
        </button>

        <!-- Sidebar -->
        <aside id="mobile-sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-white shadow-lg flex flex-col z-50 lg:z-auto transform lg:transform-none">
            <!-- Logo -->
            <div class="p-4 sm:p-6 border-b border-gray-200 flex items-center justify-between">
                <a href="<?php echo e(route('home')); ?>" class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-red-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                        <i class="fas fa-shield-alt text-white text-lg sm:text-xl"></i>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold text-red-600">Tikehub</span>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-3 sm:p-4 border-b border-gray-200">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">Espace Administrateur</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-800 truncate"><?php echo e(auth()->user()->name); ?></p>
                <p class="text-xs text-gray-500 truncate mt-1"><?php echo e(auth()->user()->email); ?></p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-2 sm:p-4 overflow-y-auto">
                <a href="<?php echo e(route('admin.dashboard')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-th-large w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Dashboard</span>
                </a>
                <a href="<?php echo e(route('admin.events.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.events.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-calendar-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Événements</span>
                </a>
                <a href="<?php echo e(route('admin.users.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.users.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-users w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Utilisateurs</span>
                </a>
                <a href="<?php echo e(route('admin.kyc.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.kyc.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-id-card w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">KYC</span>
                    <?php if(\App\Models\User::where('kyc_status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full flex-shrink-0">
                            <?php echo e(\App\Models\User::where('kyc_status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.reports.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.reports.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-flag w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Signalements</span>
                    <?php if(\App\Models\Report::where('status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full flex-shrink-0">
                            <?php echo e(\App\Models\Report::where('status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.support.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.support.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-headset w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Support Client</span>
                    <?php if(\App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full flex-shrink-0">
                            <?php echo e(\App\Models\SupportTicket::whereIn('status', ['open', 'in_progress'])->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.payments.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.payments.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-money-bill-wave w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Paiements</span>
                </a>
                <a href="<?php echo e(route('admin.withdrawals.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.withdrawals.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-hand-holding-usd w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Retraits</span>
                    <?php if(\App\Models\Withdrawal::where('status', 'pending')->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full flex-shrink-0">
                            <?php echo e(\App\Models\Withdrawal::where('status', 'pending')->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                <a href="<?php echo e(route('admin.contests.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.contests.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-trophy w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Concours</span>
                </a>
                <a href="<?php echo e(route('admin.fundraisings.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.fundraisings.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-heart w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Collectes</span>
                </a>
                
                <!-- Section Contenu -->
                <div class="mt-4 mb-2 px-3 sm:px-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Contenu</p>
                </div>
                
                <a href="<?php echo e(route('admin.blogs.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.blogs.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-newspaper w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Blog</span>
                </a>
                <a href="<?php echo e(route('admin.blog-categories.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.blog-categories.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-tags w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Catégories Blog</span>
                </a>
                <a href="<?php echo e(route('admin.faqs.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.faqs.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-question-circle w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">FAQs</span>
                </a>
                <a href="<?php echo e(route('admin.contact-info.edit')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.contact-info.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-address-card w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Infos Contact</span>
                </a>
                <a href="<?php echo e(route('admin.contact-messages.index')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.contact-messages.*') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-inbox w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base flex-1">Messages Contact</span>
                    <?php if(\App\Models\ContactMessage::where('is_read', false)->count() > 0): ?>
                        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full flex-shrink-0">
                            <?php echo e(\App\Models\ContactMessage::where('is_read', false)->count()); ?>

                        </span>
                    <?php endif; ?>
                </a>
                
                <a href="<?php echo e(route('admin.settings')); ?>" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg <?php echo e(request()->routeIs('admin.settings') ? 'bg-red-600 text-white' : 'text-gray-700 hover:bg-gray-100'); ?> min-h-[44px]">
                    <i class="fas fa-cog w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Paramètres</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-3 sm:p-4 border-t border-gray-200">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg text-gray-700 hover:bg-gray-100 active:bg-gray-200 min-h-[44px]">
                        <i class="fas fa-sign-out-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto pt-16 lg:pt-0">
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
        }

        function closeSidebarOnMobile() {
            if (window.innerWidth < 1024) {
                toggleSidebar();
            }
        }

        // Fermer la sidebar si on redimensionne vers desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                const sidebar = document.getElementById('mobile-sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.remove('open');
                overlay.classList.remove('open');
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\Users\adoun\Videos\Mon Tikehub\resources\views/layouts/admin.blade.php ENDPATH**/ ?>