<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    <?php echo $__env->yieldPushContent('head'); ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <?php echo $__env->yieldPushContent('styles'); ?>
    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            -webkit-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 0 !important;
        }
        /* Navigation fixée en haut - Responsive */
        body > nav:first-of-type {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 9999 !important;
            background: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
            border-bottom: 3px solid #6b7280 !important;
            order: 1 !important;
            opacity: 1 !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }
        /* Main avec padding pour la navigation fixe - Responsive */
        body > main {
            margin-top: 80px !important;
            padding-top: 1rem !important;
            padding-bottom: 0 !important;
            order: 2 !important;
            flex: 1;
            min-height: auto !important;
        }
        @media (max-width: 640px) {
            body > main {
                margin-top: 70px !important;
                padding-top: 0.75rem !important;
            }
        }
        /* Footer */
        body > footer {
            order: 3 !important;
            flex-shrink: 0;
        }
        /* Navigation - Responsive */
        nav {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 9999 !important;
            background: #ffffff !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important;
            border-bottom: 3px solid #6b7280 !important;
            opacity: 1 !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
        }
        /* Main - Responsive */
        main {
            margin-top: 80px !important;
            padding-top: 1rem !important;
            padding-bottom: 0 !important;
            min-height: auto !important;
        }
        @media (max-width: 640px) {
            main {
                margin-top: 70px !important;
                padding-top: 0.75rem !important;
            }
        }
        /* Empêcher le menu mobile de s'afficher en bas */
        #mobile-menu {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
        }
        /* Améliorations mobile */
        @media (max-width: 640px) {
            /* Touch targets minimum 44x44px */
            button, a, input, select, textarea {
                min-height: 44px;
                min-width: 44px;
            }
            /* Typographie responsive */
            h1 { font-size: 1.75rem !important; }
            h2 { font-size: 1.5rem !important; }
            h3 { font-size: 1.25rem !important; }
            /* Espacement réduit sur mobile */
            .space-y-6 > * + * { margin-top: 1rem !important; }
            .space-y-4 > * + * { margin-top: 0.75rem !important; }
            /* Padding réduit sur mobile */
            .p-6 { padding: 1rem !important; }
            .px-6 { padding-left: 1rem !important; padding-right: 1rem !important; }
            .py-6 { padding-top: 1rem !important; padding-bottom: 1rem !important; }
        }
        /* Amélioration des formulaires sur mobile */
        @media (max-width: 640px) {
            input[type="text"],
            input[type="email"],
            input[type="password"],
            input[type="number"],
            input[type="tel"],
            input[type="date"],
            input[type="time"],
            select,
            textarea {
                font-size: 16px !important; /* Évite le zoom automatique sur iOS */
                padding: 0.75rem !important;
            }
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg border-b border-gray-200" style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; z-index: 9999 !important; background: #ffffff !important; opacity: 1 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; border-bottom: 3px solid #6b7280 !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important;">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center space-x-1 sm:space-x-2 group">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-1.5 sm:p-2 rounded-lg group-hover:shadow-lg transition">
                            <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                        </div>
                        <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Tikehub
                        </span>
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-2">
                    <a href="<?php echo e(route('home')); ?>" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="<?php echo e(route('events.index')); ?>" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                        <i class="fas fa-calendar-alt mr-2"></i>Événements
                    </a>
                    <a href="<?php echo e(route('contests.index')); ?>" class="px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : ''); ?>">
                        <i class="fas fa-trophy mr-2"></i>Concours
                    </a>
                    <a href="<?php echo e(route('fundraisings.index')); ?>" class="px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : ''); ?>">
                        <i class="fas fa-heart mr-2"></i>Collectes
                    </a>
                    
                    <!-- Menu Ressources -->
                    <div class="relative group" id="resources-menu-container">
                        <button id="resources-menu-button" type="button" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('faq') || request()->routeIs('how-it-works') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                            <i class="fas fa-book mr-2"></i>Ressources
                            <i class="fas fa-chevron-down text-xs ml-1 transform transition-transform duration-200" id="resources-chevron"></i>
                        </button>
                        <div id="resources-dropdown" class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="<?php echo e(route('faq')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center <?php echo e(request()->routeIs('faq') ? 'bg-indigo-50 text-indigo-600' : ''); ?>">
                                    <i class="fas fa-question-circle mr-2"></i>FAQ
                                </a>
                                <a href="<?php echo e(route('how-it-works')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center <?php echo e(request()->routeIs('how-it-works') ? 'bg-indigo-50 text-indigo-600' : ''); ?>">
                                    <i class="fas fa-info-circle mr-2"></i>Comment ça marche
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="<?php echo e(route('contact')); ?>" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center <?php echo e(request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                        <i class="fas fa-envelope mr-2"></i>Contact
                    </a>
                </div>

                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-3">
                    <?php if(auth()->guard()->check()): ?>
                        <a href="<?php echo e(route('dashboard')); ?>" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium hidden md:block">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <div class="relative group">
                            <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                <img src="<?php echo e(auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=indigo&color=fff'); ?>" 
                                     alt="<?php echo e(auth()->user()->name); ?>" 
                                     class="w-8 h-8 rounded-full border-2 border-indigo-200">
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800"><?php echo e(auth()->user()->name); ?></p>
                                        <p class="text-xs text-gray-500"><?php echo e(auth()->user()->email); ?></p>
                                    </div>
                                    <a href="<?php echo e(route('dashboard')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                    <a href="<?php echo e(route('support.tickets.index')); ?>" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                        <i class="fas fa-headset mr-2"></i>Support
                                    </a>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo e(route('login')); ?>" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 sm:px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md hover:shadow-lg font-medium text-sm sm:text-base flex items-center">
                            <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i><span>Connexion</span>
                        </a>
                        <a href="<?php echo e(route('register')); ?>" class="hidden sm:inline-flex px-3 sm:px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium text-sm sm:text-base">
                            <i class="fas fa-user-plus mr-1 sm:mr-2"></i><span class="hidden md:inline">Inscription</span>
                        </a>
                    <?php endif; ?>

                    <!-- Menu Mobile Button -->
                    <button id="mobile-menu-button" class="lg:hidden p-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Menu mobile">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar Mobile -->
    <div id="mobile-sidebar-overlay" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 hidden transition-opacity duration-300" style="z-index: 99999 !important;" onclick="closeMobileSidebar()"></div>
    <aside id="mobile-sidebar" class="lg:hidden fixed top-0 left-0 h-full w-80 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 overflow-y-auto" style="z-index: 100000 !important;">
        <div class="flex flex-col h-full">
            <!-- Header Sidebar -->
            <div class="flex items-center justify-between p-4 border-b border-gray-200">
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-2 rounded-lg">
                        <i class="fas fa-ticket-alt text-white text-lg"></i>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Tikehub
                    </span>
                </div>
                <button onclick="closeMobileSidebar()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="<?php echo e(route('home')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition <?php echo e(request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                    <i class="fas fa-home mr-3 w-5 text-center"></i>
                    <span class="font-medium">Accueil</span>
                </a>
                <a href="<?php echo e(route('events.index')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition <?php echo e(request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                    <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i>
                    <span class="font-medium">Événements</span>
                </a>
                <a href="<?php echo e(route('contests.index')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition <?php echo e(request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : ''); ?>">
                    <i class="fas fa-trophy mr-3 w-5 text-center"></i>
                    <span class="font-medium">Concours</span>
                </a>
                <a href="<?php echo e(route('fundraisings.index')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition <?php echo e(request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : ''); ?>">
                    <i class="fas fa-heart mr-3 w-5 text-center"></i>
                    <span class="font-medium">Collectes</span>
                </a>
                
                <!-- Menu Ressources -->
                <div class="px-4 py-2">
                    <div class="text-sm font-semibold text-gray-500 mb-2 flex items-center">
                        <i class="fas fa-book mr-3 w-5 text-center"></i>
                        <span>Ressources</span>
                    </div>
                    <div class="ml-8 space-y-1">
                        <a href="<?php echo e(route('faq')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition <?php echo e(request()->routeIs('faq') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                            <i class="fas fa-question-circle mr-3 w-5 text-center"></i>
                            <span>FAQ</span>
                        </a>
                        <a href="<?php echo e(route('how-it-works')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition <?php echo e(request()->routeIs('how-it-works') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                            <i class="fas fa-info-circle mr-3 w-5 text-center"></i>
                            <span>Comment ça marche</span>
                        </a>
                    </div>
                </div>
                
                <a href="<?php echo e(route('contact')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition <?php echo e(request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : ''); ?>">
                    <i class="fas fa-envelope mr-3 w-5 text-center"></i>
                    <span class="font-medium">Contact</span>
                </a>
                
                <?php if(auth()->guard()->check()): ?>
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <a href="<?php echo e(route('dashboard')); ?>" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                        <a href="<?php echo e(route('login')); ?>" onclick="closeMobileSidebar()" class="block w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md text-center font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="<?php echo e(route('register')); ?>" onclick="closeMobileSidebar()" class="block w-full border-2 border-indigo-600 text-indigo-600 px-4 py-3 rounded-lg hover:bg-indigo-50 transition text-center font-medium">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </aside>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Fonction pour ouvrir la sidebar mobile
        function openMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        // Fonction pour fermer la sidebar mobile
        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('mobile-sidebar-overlay');
            if (sidebar && overlay) {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.style.overflow = '';
            }
        }

        // Ouvrir la sidebar au clic sur le bouton hamburger
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            openMobileSidebar();
        });

        // Fermer la sidebar avec la touche Escape
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileSidebar();
            }
        });

        // Gestion du menu Ressources (clic + survol)
        const resourcesButton = document.getElementById('resources-menu-button');
        const resourcesDropdown = document.getElementById('resources-dropdown');
        const resourcesChevron = document.getElementById('resources-chevron');
        const resourcesContainer = document.getElementById('resources-menu-container');
        let isOpenByClick = false;

        if (resourcesButton && resourcesDropdown && resourcesContainer) {
            // Toggle au clic
            resourcesButton.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = resourcesDropdown.classList.contains('opacity-100');
                
                if (isOpen) {
                    resourcesDropdown.classList.add('opacity-0', 'invisible');
                    resourcesDropdown.classList.remove('opacity-100', 'visible');
                    resourcesChevron?.classList.remove('rotate-180');
                    isOpenByClick = false;
                } else {
                    resourcesDropdown.classList.remove('opacity-0', 'invisible');
                    resourcesDropdown.classList.add('opacity-100', 'visible');
                    resourcesChevron?.classList.add('rotate-180');
                    isOpenByClick = true;
                }
            });

            // Fermer le menu si on clique ailleurs
            document.addEventListener('click', function(e) {
                if (resourcesContainer && !resourcesContainer.contains(e.target)) {
                    resourcesDropdown.classList.add('opacity-0', 'invisible');
                    resourcesDropdown.classList.remove('opacity-100', 'visible');
                    resourcesChevron?.classList.remove('rotate-180');
                    isOpenByClick = false;
                }
            });

            // Comportement au survol (ouvre toujours, mais ne ferme que si pas ouvert par clic)
            resourcesContainer.addEventListener('mouseenter', function() {
                resourcesDropdown.classList.remove('opacity-0', 'invisible');
                resourcesDropdown.classList.add('opacity-100', 'visible');
                resourcesChevron?.classList.add('rotate-180');
            });

            resourcesContainer.addEventListener('mouseleave', function() {
                if (!isOpenByClick) {
                    resourcesDropdown.classList.add('opacity-0', 'invisible');
                    resourcesDropdown.classList.remove('opacity-100', 'visible');
                    resourcesChevron?.classList.remove('rotate-180');
                }
            });
        }
    </script>
    <?php $__env->stopPush(); ?>

    <main class="py-4" style="order: 2 !important; flex: 1 !important; position: relative !important; min-height: auto !important; padding-bottom: 1rem !important;">
        <?php if(session('success')): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(isset($errors) && $errors->any()): ?>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="bg-gray-800 text-white mt-0" style="order: 3 !important; flex-shrink: 0 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <p class="text-center">&copy; <?php echo e(date('Y')); ?> Tikehub. Tous droits réservés.</p>
        </div>
    </footer>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>

<?php /**PATH C:\Users\adoun\Videos\Mon Tikehub\resources\views/layouts/app.blade.php ENDPATH**/ ?>