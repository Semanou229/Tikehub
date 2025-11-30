<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding-top: 0 !important;
        }
        /* Navigation fixée en haut */
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
        /* Main avec padding pour la navigation fixe */
        body > main {
            margin-top: 100px !important;
            padding-top: 3rem !important;
            padding-bottom: 0 !important;
            order: 2 !important;
            flex: 1;
            min-height: auto !important;
        }
        /* Footer */
        body > footer {
            order: 3 !important;
            flex-shrink: 0;
        }
        /* Navigation */
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
        /* Main */
        main {
            margin-top: 100px !important;
            padding-top: 3rem !important;
            padding-bottom: 0 !important;
            min-height: auto !important;
        }
        /* Masquer toute barre de navigation fixée en bas */
        nav.fixed.bottom-0,
        .bottom-nav,
        nav[class*="bottom"],
        nav[class*="fixed"][class*="bottom"] {
            display: none !important;
        }
        /* Empêcher le menu mobile de s'afficher en bas */
        #mobile-menu {
            position: relative !important;
            top: auto !important;
            bottom: auto !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-lg border-b border-gray-200" style="position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; z-index: 9999 !important; background: #ffffff !important; opacity: 1 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3) !important; border-bottom: 3px solid #6b7280 !important; backdrop-filter: blur(20px) !important; -webkit-backdrop-filter: blur(20px) !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 group">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 p-2 rounded-lg group-hover:shadow-lg transition">
                            <i class="fas fa-ticket-alt text-white text-xl"></i>
                        </div>
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                            Tikehub
                        </span>
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden lg:flex items-center space-x-1">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="{{ route('events.index') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium {{ request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Événements
                    </a>
                    <a href="{{ route('contests.index') }}" class="px-4 py-2 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition font-medium {{ request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : '' }}">
                        <i class="fas fa-trophy mr-2"></i>Concours
                    </a>
                    <a href="{{ route('fundraisings.index') }}" class="px-4 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition font-medium {{ request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : '' }}">
                        <i class="fas fa-heart mr-2"></i>Collectes
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
                        <a href="{{ route('login') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition font-medium">
                            <i class="fas fa-sign-in-alt mr-2"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-6 py-2 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md hover:shadow-lg font-medium">
                            <i class="fas fa-user-plus mr-2"></i>Inscription
                        </a>
                    @endauth

                    <!-- Menu Mobile -->
                    <button id="mobile-menu-button" class="lg:hidden p-2 text-gray-700 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Menu Mobile Dropdown -->
            <div id="mobile-menu" class="hidden lg:hidden pb-4 border-t border-gray-200">
                <div class="flex flex-col space-y-1 mt-2">
                    <a href="{{ route('home') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('home') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-home mr-2"></i>Accueil
                    </a>
                    <a href="{{ route('events.index') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition {{ request()->routeIs('events.*') ? 'text-indigo-600 bg-indigo-50' : '' }}">
                        <i class="fas fa-calendar-alt mr-2"></i>Événements
                    </a>
                    <a href="{{ route('contests.index') }}" class="px-4 py-2 text-gray-700 hover:text-purple-600 hover:bg-purple-50 rounded-lg transition {{ request()->routeIs('contests.*') ? 'text-purple-600 bg-purple-50' : '' }}">
                        <i class="fas fa-trophy mr-2"></i>Concours
                    </a>
                    <a href="{{ route('fundraisings.index') }}" class="px-4 py-2 text-gray-700 hover:text-green-600 hover:bg-green-50 rounded-lg transition {{ request()->routeIs('fundraisings.*') ? 'text-green-600 bg-green-50' : '' }}">
                        <i class="fas fa-heart mr-2"></i>Collectes
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 text-gray-700 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @push('scripts')
    <script>
        document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
    @endpush

    <main class="py-4" style="order: 2 !important; flex: 1 !important; position: relative !important; min-height: auto !important; padding-bottom: 1rem !important;">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white mt-4" style="order: 3 !important; flex-shrink: 0 !important;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <p class="text-center">&copy; {{ date('Y') }} Tikehub. Tous droits réservés.</p>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>

