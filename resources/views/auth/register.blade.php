@extends('layouts.app')

@section('title', 'Inscription - Tikehub')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 py-4 sm:py-8 px-3 sm:px-4 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Tabs Navigation -->
        <div class="flex justify-center mb-4 sm:mb-6">
            <div class="bg-white rounded-lg p-1 inline-flex gap-1 sm:gap-2 shadow-md w-full sm:w-auto">
                <button id="login-tab" class="tab-button px-3 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base transition-all duration-300 text-gray-600 hover:text-indigo-600 flex-1 sm:flex-none items-center justify-center" data-tab="login">
                    <i class="fas fa-sign-in-alt mr-1 sm:mr-2"></i><span>Connexion</span>
                </button>
                <button id="register-tab" class="tab-button active px-3 sm:px-6 py-2.5 sm:py-3 rounded-lg font-semibold text-sm sm:text-base transition-all duration-300 bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-md flex-1 sm:flex-none items-center justify-center" data-tab="register">
                    <i class="fas fa-user-plus mr-1 sm:mr-2"></i><span>Inscription</span>
                </button>
            </div>
        </div>

        <!-- Login Form -->
        <div id="login-content" class="tab-content hidden">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8">
                <div class="text-center mb-4 sm:mb-6">
                    <div class="inline-block bg-gradient-to-br from-indigo-600 to-purple-600 p-2 sm:p-3 rounded-lg mb-3 sm:mb-4">
                        <i class="fas fa-ticket-alt text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1 sm:mb-2">Bienvenue</h2>
                    <p class="text-sm sm:text-base text-gray-600">Connectez-vous à votre compte Tikehub</p>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
                    @csrf
                    
                    <div>
                        <label for="login-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email
                        </label>
                        <input type="email" name="email" id="login-email" value="{{ old('email') }}" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base"
                            placeholder="votre@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="login-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="login-password" required
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base pr-10"
                                placeholder="Votre mot de passe">
                            <button type="button" onclick="togglePassword('login-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600 min-w-[44px] min-h-[44px] flex items-center justify-center">
                                <i class="fas fa-eye" id="login-password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 sm:gap-0">
                        <label class="flex items-center min-h-[44px]">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 w-4 h-4">
                            <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                        </label>
                        <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium min-h-[44px] flex items-center">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 sm:py-3.5 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-base min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i><span>Se connecter</span>
                    </button>
                </form>

                <div class="mt-4 sm:mt-6 text-center">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Pas encore de compte ? 
                        <button onclick="switchToRegister()" class="text-indigo-600 hover:text-indigo-800 font-semibold min-h-[44px] inline-flex items-center">
                            Créer un compte
                        </button>
                    </p>
                </div>
            </div>
        </div>

        <!-- Register Form -->
        <div id="register-content" class="tab-content">
            <div class="bg-white rounded-xl sm:rounded-2xl shadow-xl p-4 sm:p-6 lg:p-8">
                <div class="text-center mb-4 sm:mb-6">
                    <div class="inline-block bg-gradient-to-br from-indigo-600 to-purple-600 p-2 sm:p-3 rounded-lg mb-3 sm:mb-4">
                        <i class="fas fa-user-plus text-white text-xl sm:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-1 sm:mb-2">Créer un compte</h2>
                    <p class="text-sm sm:text-base text-gray-600">Rejoignez Tikehub et commencez dès aujourd'hui</p>
                </div>

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5">
                    @csrf
                    
                    <div>
                        <label for="register-name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-indigo-600"></i>Nom complet
                        </label>
                        <input type="text" name="name" id="register-name" value="{{ old('name') }}" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base"
                            placeholder="Votre nom complet">
                        @error('name')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-indigo-600"></i>Email
                        </label>
                        <input type="email" name="email" id="register-email" value="{{ old('email') }}" required
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base"
                            placeholder="votre@email.com">
                        @error('email')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-indigo-600"></i>Téléphone <span class="text-gray-400 text-xs">(optionnel)</span>
                        </label>
                        <input type="tel" name="phone" id="register-phone" value="{{ old('phone') }}"
                            class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base"
                            placeholder="+229 XX XX XX XX">
                        @error('phone')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>Mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="register-password" required
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base pr-10"
                                placeholder="Minimum 8 caractères">
                            <button type="button" onclick="togglePassword('register-password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600 min-w-[44px] min-h-[44px] flex items-center justify-center">
                                <i class="fas fa-eye" id="register-password-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="register-password-confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-indigo-600"></i>Confirmer le mot de passe
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="register-password-confirmation" required
                                class="w-full px-3 sm:px-4 py-2.5 sm:py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none transition text-base pr-10"
                                placeholder="Répétez le mot de passe">
                            <button type="button" onclick="togglePassword('register-password-confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600 min-w-[44px] min-h-[44px] flex items-center justify-center">
                                <i class="fas fa-eye" id="register-password-confirmation-icon"></i>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2 sm:mb-3">
                            <i class="fas fa-user-tag mr-2 text-indigo-600"></i>Type de compte
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-3">
                            <label class="flex items-start sm:items-center p-3 sm:p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition {{ old('role', 'buyer') === 'buyer' ? 'border-indigo-500 bg-indigo-50' : '' }}">
                                <input type="radio" name="role" value="buyer" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }} class="mt-1 sm:mt-0 mr-2 sm:mr-3 text-indigo-600 focus:ring-indigo-500 flex-shrink-0">
                                <div>
                                    <div class="font-semibold text-sm sm:text-base text-gray-800">Acheteur</div>
                                    <div class="text-xs text-gray-500">Acheter des billets</div>
                                </div>
                            </label>
                            <label class="flex items-start sm:items-center p-3 sm:p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 transition {{ old('role') === 'organizer' ? 'border-indigo-500 bg-indigo-50' : '' }}">
                                <input type="radio" name="role" value="organizer" {{ old('role') === 'organizer' ? 'checked' : '' }} class="mt-1 sm:mt-0 mr-2 sm:mr-3 text-indigo-600 focus:ring-indigo-500 flex-shrink-0">
                                <div>
                                    <div class="font-semibold text-sm sm:text-base text-gray-800">Organisateur</div>
                                    <div class="text-xs text-gray-500">Créer des événements</div>
                                </div>
                            </label>
                        </div>
                        @error('role')
                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold py-3 sm:py-3.5 px-4 rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-base min-h-[48px] flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i><span>Créer mon compte</span>
                    </button>
                </form>

                <div class="mt-4 sm:mt-6 text-center">
                    <p class="text-xs sm:text-sm text-gray-600">
                        Déjà un compte ? 
                        <button onclick="switchToLogin()" class="text-indigo-600 hover:text-indigo-800 font-semibold min-h-[44px] inline-flex items-center">
                            Se connecter
                        </button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function switchToRegister() {
        document.getElementById('login-tab').classList.remove('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-md');
        document.getElementById('login-tab').classList.add('text-gray-600');
        document.getElementById('register-tab').classList.add('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-md');
        document.getElementById('register-tab').classList.remove('text-gray-600');
        
        document.getElementById('login-content').classList.add('hidden');
        document.getElementById('register-content').classList.remove('hidden');
    }

    function switchToLogin() {
        document.getElementById('register-tab').classList.remove('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-md');
        document.getElementById('register-tab').classList.add('text-gray-600');
        document.getElementById('login-tab').classList.add('active', 'bg-gradient-to-r', 'from-indigo-600', 'to-purple-600', 'text-white', 'shadow-md');
        document.getElementById('login-tab').classList.remove('text-gray-600');
        
        document.getElementById('register-content').classList.add('hidden');
        document.getElementById('login-content').classList.remove('hidden');
    }

    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Gestion des tabs
    document.addEventListener('DOMContentLoaded', function() {
        const loginTab = document.getElementById('login-tab');
        const registerTab = document.getElementById('register-tab');

        loginTab.addEventListener('click', function() {
            switchToLogin();
        });

        registerTab.addEventListener('click', function() {
            switchToRegister();
        });
    });
</script>
@endpush

@endsection
