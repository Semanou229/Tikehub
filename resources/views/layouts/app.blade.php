<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#4f46e5">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Tikehub">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">
    
    @stack('head')
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
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
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg border-b border-gray-200" style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; z-index: 9999 !important; background: #ffffff !important; opacity: 1 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; border-bottom: 3px solid #6b7280 !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important;">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-1 sm:space-x-2 group">
                        @php
                            $headerLogo = \App\Models\Logo::getByType('header');
                        @endphp
                        @if($headerLogo)
                            <img src="{{ $headerLogo->url }}" alt="Tikehub" class="h-10 sm:h-12 object-contain">
                        @else
                            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-1.5 sm:p-2 rounded-lg group-hover:shadow-lg transition">
                                <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                            </div>
                            <span class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Tikehub
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-2">
                    <a href="{{ route('home') }}" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="{{ route('events.index') }}" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Événements
                    </a>
                    <a href="{{ route('contests.index') }}" class="px-3 py-2 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : '' }}">
                        <i class="fas fa-trophy mr-2"></i>Concours
                    </a>
                    <a href="{{ route('fundraisings.index') }}" class="px-3 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : '' }}">
                        <i class="fas fa-heart mr-2"></i>Collectes
                    </a>
                    
                    <!-- Menu Ressources -->
                    <div class="relative group" id="resources-menu-container">
                        <button id="resources-menu-button" type="button" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('blog.*') || request()->routeIs('faq') || request()->routeIs('how-it-works') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                            <i class="fas fa-book mr-2"></i>Ressources
                            <i class="fas fa-chevron-down text-xs ml-1 transform transition-transform duration-200" id="resources-chevron"></i>
                        </button>
                        <div id="resources-dropdown" class="absolute left-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="py-2">
                                <a href="{{ route('blog.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center {{ request()->routeIs('blog.*') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    <i class="fas fa-newspaper mr-2"></i>Blog
                                </a>
                                <a href="{{ route('faq') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center {{ request()->routeIs('faq') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    <i class="fas fa-question-circle mr-2"></i>FAQ
                                </a>
                                <a href="{{ route('how-it-works') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center {{ request()->routeIs('how-it-works') ? 'bg-indigo-50 text-indigo-600' : '' }}">
                                    <i class="fas fa-info-circle mr-2"></i>Comment ça marche
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <a href="{{ route('pricing') }}" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('pricing') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-tags mr-2"></i>Tarifs
                    </a>
                    <a href="{{ route('contact') }}" class="px-3 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium flex items-center {{ request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-envelope mr-2"></i>Contact
                    </a>
                </div>

                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium hidden md:block">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <div class="relative group">
                            <button class="flex items-center space-x-2 px-3 py-2 rounded-lg hover:bg-gray-100 transition">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=indigo&color=fff' }}" 
                                     alt="{{ auth()->user()->name }}" 
                                     class="w-8 h-8 rounded-full border-2 border-indigo-200">
                                <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="py-2">
                                    <div class="px-4 py-2 border-b border-gray-100">
                                        <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                        <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                        @if(auth()->user()->isOrganizer())
                                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-purple-100 text-purple-700 rounded">Organisateur</span>
                                        @elseif(auth()->user()->isAdmin())
                                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-red-100 text-red-700 rounded">Admin</span>
                                        @else
                                            <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold bg-gray-100 text-gray-700 rounded">Client</span>
                                        @endif
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                    <a href="{{ route('support.tickets.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                                        <i class="fas fa-headset mr-2"></i>Support
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                            <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-3 sm:px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md hover:shadow-lg font-medium text-sm sm:text-base flex items-center">
                            <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i><span>Connexion</span>
                        </a>
                        <a href="{{ route('register') }}" class="hidden sm:inline-flex px-3 sm:px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium text-sm sm:text-base">
                            <i class="fas fa-user-plus mr-1 sm:mr-2"></i><span class="hidden md:inline">Inscription</span>
                        </a>
                    @endauth

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
                        @php
                            $mobileLogo = \App\Models\Logo::getByType('mobile') ?? \App\Models\Logo::getByType('header');
                        @endphp
                        @if($mobileLogo)
                            <img src="{{ $mobileLogo->url }}" alt="Tikehub" class="h-8 object-contain">
                        @else
                            Tikehub
                        @endif
                    </span>
                </div>
                <button onclick="closeMobileSidebar()" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="flex-1 p-4 space-y-1">
                <a href="{{ route('home') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    <i class="fas fa-home mr-3 w-5 text-center"></i>
                    <span class="font-medium">Accueil</span>
                </a>
                <a href="{{ route('events.index') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    <i class="fas fa-calendar-alt mr-3 w-5 text-center"></i>
                    <span class="font-medium">Événements</span>
                </a>
                <a href="{{ route('contests.index') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : '' }}">
                    <i class="fas fa-trophy mr-3 w-5 text-center"></i>
                    <span class="font-medium">Concours</span>
                </a>
                <a href="{{ route('fundraisings.index') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition {{ request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : '' }}">
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
                        <a href="{{ route('blog.index') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('blog.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                            <i class="fas fa-newspaper mr-3 w-5 text-center"></i>
                            <span>Blog</span>
                        </a>
                        <a href="{{ route('faq') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('faq') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                            <i class="fas fa-question-circle mr-3 w-5 text-center"></i>
                            <span>FAQ</span>
                        </a>
                        <a href="{{ route('how-it-works') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('how-it-works') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                            <i class="fas fa-info-circle mr-3 w-5 text-center"></i>
                            <span>Comment ça marche</span>
                        </a>
                    </div>
                </div>
                
                <a href="{{ route('pricing') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('pricing') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    <i class="fas fa-tags mr-3 w-5 text-center"></i>
                    <span class="font-medium">Tarifs</span>
                </a>
                <a href="{{ route('contact') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('contact') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                    <i class="fas fa-envelope mr-3 w-5 text-center"></i>
                    <span class="font-medium">Contact</span>
                </a>
                
                @auth
                    <div class="border-t border-gray-200 mt-4 pt-4">
                        <a href="{{ route('dashboard') }}" onclick="closeMobileSidebar()" class="flex items-center px-4 py-3 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                    </div>
                @else
                    <div class="border-t border-gray-200 mt-4 pt-4 space-y-2">
                        <a href="{{ route('login') }}" onclick="closeMobileSidebar()" class="block w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-4 py-3 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md text-center font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}" onclick="closeMobileSidebar()" class="block w-full border-2 border-indigo-600 text-indigo-600 px-4 py-3 rounded-lg hover:bg-indigo-50 transition text-center font-medium">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    </div>
                @endauth
            </nav>
        </div>
    </aside>

    @push('scripts')
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
    @endpush

    <main class="py-4" style="order: 2 !important; flex: 1 !important; position: relative !important; min-height: auto !important; padding-bottom: 1rem !important;">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900 ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-700 hover:text-red-900 ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle mr-2"></i>
                        <span>{{ session('info') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-blue-700 hover:text-blue-900 ml-4">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center mb-2">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <strong>Erreurs :</strong>
                    </div>
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-0" style="order: 3 !important; flex-shrink: 0 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @php
                $footerLogo = \App\Models\Logo::getByType('footer');
            @endphp
            @if($footerLogo)
                <div class="flex justify-center mb-4">
                    <img src="{{ $footerLogo->url }}" alt="Tikehub" class="h-10 object-contain">
                </div>
            @endif
            <p class="text-center">&copy; {{ date('Y') }} Tikehub. Tous droits réservés.</p>
        </div>
    </footer>
    
    <!-- Bouton d'installation PWA -->
    @include('components.pwa-install-button')
    
    @stack('scripts')
    
    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('{{ asset('sw.js') }}')
                    .then(function(registration) {
                        console.log('Service Worker enregistré avec succès:', registration.scope);
                        
                        // Vérifier les mises à jour
                        registration.addEventListener('updatefound', () => {
                            const newWorker = registration.installing;
                            newWorker.addEventListener('statechange', () => {
                                if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                                    // Nouvelle version disponible
                                    if (confirm('Une nouvelle version de l\'application est disponible. Voulez-vous recharger la page ?')) {
                                        newWorker.postMessage({ type: 'SKIP_WAITING' });
                                        window.location.reload();
                                    }
                                }
                            });
                        });
                    })
                    .catch(function(error) {
                        console.log('Échec de l\'enregistrement du Service Worker:', error);
                    });
                
                // Écouter les messages du service worker
                navigator.serviceWorker.addEventListener('message', function(event) {
                    console.log('Message du Service Worker:', event.data);
                });
            });
        }
    </script>
</body>
</html>

