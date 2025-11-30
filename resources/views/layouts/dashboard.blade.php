<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - ' . config('app.name'))</title>
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
            /* Tableaux responsive - transformation en cartes sur mobile */
            .responsive-table {
                display: block;
            }
            .responsive-table thead {
                display: none;
            }
            .responsive-table tbody,
            .responsive-table tr,
            .responsive-table td {
                display: block;
                width: 100%;
            }
            .responsive-table tr {
                border: 1px solid #e5e7eb;
                border-radius: 0.5rem;
                margin-bottom: 1rem;
                padding: 1rem;
                background: white;
            }
            .responsive-table td {
                border: none;
                padding: 0.5rem 0;
                text-align: left;
            }
        }
        
        /* Pagination responsive */
        .pagination {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            justify-content: center;
            align-items: center;
            padding: 1rem 0;
        }
        
        .pagination > * {
            flex-shrink: 0;
        }
        
        .pagination a,
        .pagination span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            min-height: 36px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            text-decoration: none;
            white-space: nowrap;
        }
        
        @media (max-width: 640px) {
            .pagination {
                gap: 0.25rem;
            }
            .pagination a,
            .pagination span {
                min-width: 32px;
                min-height: 32px;
                padding: 0.375rem 0.5rem;
                font-size: 0.75rem;
            }
            .pagination .page-link:not(.disabled) {
                display: none;
            }
            .pagination .page-link:first-child,
            .pagination .page-link:last-child,
            .pagination .page-link.active {
                display: inline-flex;
            }
        }
            .responsive-table td:before {
                content: attr(data-label);
                font-weight: 600;
                display: inline-block;
                width: 40%;
                color: #6b7280;
                margin-right: 0.5rem;
            }
        }
        /* Padding responsive pour le contenu */
        @media (max-width: 768px) {
            main .max-w-7xl {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
        }
    </style>
    @stack('styles')
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
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                        <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold text-indigo-600">Tikehub</span>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-3 sm:p-4 border-b border-gray-200">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">Espace Organisateur</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->email }}</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-2 sm:p-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-th-large w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Dashboard</span>
                </a>
                <a href="{{ route('organizer.events.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.events.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-calendar-plus w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Événements</span>
                </a>
                <a href="{{ route('organizer.contests.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.contests.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-trophy w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Concours</span>
                </a>
                <a href="{{ route('organizer.fundraisings.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.fundraisings.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-heart w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Collectes</span>
                </a>
                <a href="{{ route('organizer.wallet.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.wallet.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-wallet w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Portefeuille</span>
                </a>
                <a href="{{ route('organizer.payments.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.payments.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-credit-card w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Paiements</span>
                </a>
                <a href="{{ route('organizer.reports.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.reports.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-chart-bar w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Rapports</span>
                </a>
                <a href="{{ route('organizer.promo-codes.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.promo-codes.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-tag w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Codes Promo</span>
                </a>
                <!-- CRM Section -->
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="px-3 sm:px-4 text-xs font-semibold text-gray-500 uppercase mb-2">CRM</p>
                    <a href="{{ route('organizer.crm.contacts.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.contacts.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-address-book w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Contacts</span>
                    </a>
                    <a href="{{ route('organizer.crm.pipeline.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.pipeline.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-project-diagram w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Pipeline</span>
                    </a>
                    <a href="{{ route('organizer.crm.campaigns.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.campaigns.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-envelope w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Emails Marketing</span>
                    </a>
                    <a href="{{ route('organizer.crm.automations.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.automations.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-cogs w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Automations</span>
                    </a>
                    <a href="{{ route('organizer.crm.sponsors.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.sponsors.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-handshake w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Sponsors</span>
                    </a>
                    <a href="{{ route('organizer.crm.teams.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.teams.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-users-cog w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Équipe</span>
                    </a>
                    <a href="{{ route('organizer.crm.forms.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.crm.forms.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                        <i class="fas fa-file-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Formulaires</span>
                    </a>
                </div>
                <a href="{{ route('organizer.notifications.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.notifications.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-bell w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Notifications</span>
                </a>
                <a href="{{ route('support.tickets.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('support.tickets.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-headset w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Support</span>
                </a>
                <a href="{{ route('organizer.profile.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.profile.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-user w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mon Compte</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-3 sm:p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg text-gray-700 hover:bg-gray-100 active:bg-gray-200 min-h-[44px]">
                        <i class="fas fa-sign-out-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto pt-16 lg:pt-0">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 m-4 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($errors) && $errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 m-4 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
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
    @stack('scripts')
</body>
</html>

