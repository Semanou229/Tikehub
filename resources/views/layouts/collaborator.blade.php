<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Collaborateur - ' . config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @media (max-width: 1023px) {
            #mobile-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
            }
            #mobile-sidebar.open {
                transform: translateX(0);
            }
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside id="mobile-sidebar" class="fixed lg:static inset-y-0 left-0 w-64 bg-white shadow-lg flex flex-col z-50 lg:z-auto transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out">
            <!-- Logo -->
            <div class="p-3 sm:p-4 lg:p-6 border-b border-gray-200 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-2 sm:mr-3 flex-shrink-0">
                        <i class="fas fa-ticket-alt text-white text-lg sm:text-xl"></i>
                    </div>
                    <span class="text-xl sm:text-2xl font-bold text-blue-600">Tikehub</span>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden p-2 text-gray-500 hover:text-gray-700 min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- User Info -->
            <div class="p-3 sm:p-4 border-b border-gray-200">
                <p class="text-xs sm:text-sm text-gray-500 mb-1">Espace Collaborateur</p>
                <p class="text-xs sm:text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->name }}</p>
                @if(auth()->user()->team)
                    <p class="text-xs text-gray-500 mt-1 truncate">{{ auth()->user()->team->name }}</p>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-2 sm:p-4 overflow-y-auto">
                <a href="{{ route('collaborator.dashboard') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('collaborator.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-th-large w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Dashboard</span>
                </a>
                <a href="{{ route('collaborator.events.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('collaborator.events.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-calendar-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Événements</span>
                </a>
                <a href="{{ route('collaborator.tasks.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('collaborator.tasks.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-tasks w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Tâches</span>
                </a>
                <a href="{{ route('collaborator.tickets.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('collaborator.tickets.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-ticket-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mes Billets</span>
                </a>
                <a href="{{ route('collaborator.profile.index') }}" onclick="closeSidebarOnMobile()" class="flex items-center px-3 sm:px-4 py-2.5 sm:py-3 mb-2 rounded-lg {{ request()->routeIs('collaborator.profile.*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} min-h-[44px]">
                    <i class="fas fa-user w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                    <span class="text-sm sm:text-base">Mon Profil</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-3 sm:p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg text-gray-700 hover:bg-gray-100 min-h-[44px]">
                        <i class="fas fa-sign-out-alt w-5 mr-2 sm:mr-3 flex-shrink-0"></i>
                        <span class="text-sm sm:text-base">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Mobile Header for Hamburger -->
        <div class="lg:hidden fixed top-0 left-0 right-0 bg-white shadow-md p-3 sm:p-4 flex items-center justify-between z-40">
            <button onclick="toggleSidebar()" class="p-2 text-gray-600 hover:text-gray-800 min-w-[44px] min-h-[44px] flex items-center justify-center">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <span class="text-base sm:text-lg font-semibold text-gray-800">Dashboard Collaborateur</span>
            <div class="w-10 h-10"></div> <!-- Placeholder for alignment -->
        </div>

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
            sidebar.classList.toggle('open');
            // Add/remove overlay
            if (!sidebar.classList.contains('open')) {
                const overlay = document.getElementById('sidebar-overlay');
                if (overlay) overlay.remove();
            } else {
                const overlay = document.createElement('div');
                overlay.id = 'sidebar-overlay';
                overlay.className = 'fixed inset-0 bg-black opacity-50 z-40 lg:hidden';
                overlay.onclick = toggleSidebar;
                document.body.appendChild(overlay);
            }
        }

        function closeSidebarOnMobile() {
            const sidebar = document.getElementById('mobile-sidebar');
            if (sidebar.classList.contains('open') && window.innerWidth < 1024) {
                toggleSidebar();
            }
        }

        // Close sidebar if resized to desktop
        window.addEventListener('resize', () => {
            const sidebar = document.getElementById('mobile-sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            if (window.innerWidth >= 1024 && sidebar && sidebar.classList.contains('open')) {
                sidebar.classList.remove('open');
                if (overlay) overlay.remove();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>


