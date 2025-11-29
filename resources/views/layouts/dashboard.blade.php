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
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <a href="{{ route('home') }}" class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-ticket-alt text-white text-xl"></i>
                    </div>
                    <span class="text-2xl font-bold text-indigo-600">Tikehub</span>
                </a>
            </div>

            <!-- User Info -->
            <div class="p-4 border-b border-gray-200">
                <p class="text-sm text-gray-500 mb-1">Espace Organisateur</p>
                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->email }}</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-th-large w-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('organizer.events.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.events.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-calendar-plus w-5 mr-3"></i>
                    <span>Mes Événements</span>
                </a>
                <a href="{{ route('organizer.contests.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.contests.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-trophy w-5 mr-3"></i>
                    <span>Mes Concours</span>
                </a>
                <a href="{{ route('organizer.fundraisings.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.fundraisings.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-heart w-5 mr-3"></i>
                    <span>Mes Collectes</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-wallet w-5 mr-3"></i>
                    <span>Portefeuille</span>
                </a>
                <a href="{{ route('organizer.payments.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.payments.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-credit-card w-5 mr-3"></i>
                    <span>Paiements</span>
                </a>
                <a href="{{ route('organizer.reports.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.reports.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-chart-bar w-5 mr-3"></i>
                    <span>Rapports</span>
                </a>
                <a href="{{ route('organizer.agents.index') }}" class="flex items-center px-4 py-3 mb-2 rounded-lg {{ request()->routeIs('organizer.agents.*') ? 'bg-indigo-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-users w-5 mr-3"></i>
                    <span>Agents</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-bell w-5 mr-3"></i>
                    <span>Notifications</span>
                </a>
                <a href="#" class="flex items-center px-4 py-3 mb-2 rounded-lg text-gray-700 hover:bg-gray-100">
                    <i class="fas fa-user w-5 mr-3"></i>
                    <span>Mon Compte</span>
                </a>
            </nav>

            <!-- Logout -->
            <div class="p-4 border-t border-gray-200">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100">
                        <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
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

    @stack('scripts')
</body>
</html>

