@extends('layouts.buyer-dashboard')

@section('title', 'Mon Profil')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mon Profil</h1>
    </div>

    <!-- Statistiques rapides -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total billets</p>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_tickets'] }}</p>
                </div>
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-indigo-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total dépensé</p>
                    <p class="text-3xl font-bold text-purple-600">{{ number_format($stats['total_spent'], 0, ',', ' ') }} XOF</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Événements à venir</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['upcoming_events'] }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-green-600 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations du profil -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Informations personnelles</h2>

                <form action="{{ route('buyer.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Avatar -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Photo de profil</label>
                        <div class="flex items-center space-x-4">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar" class="w-20 h-20 rounded-full object-cover">
                            @else
                                <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <i class="fas fa-user text-indigo-600 text-2xl"></i>
                                </div>
                            @endif
                            <div>
                                <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewImage(this)">
                                <label for="avatar" class="cursor-pointer bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition inline-block">
                                    <i class="fas fa-upload mr-2"></i>Changer la photo
                                </label>
                                <p class="text-xs text-gray-500 mt-1">JPG, PNG (max 2MB)</p>
                            </div>
                        </div>
                        <div id="avatarPreview" class="mt-2 hidden">
                            <img id="previewImg" src="" alt="Preview" class="w-20 h-20 rounded-full object-cover">
                        </div>
                    </div>

                    <!-- Nom -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="+229 90 00 00 00">
                        @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Mot de passe -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Laisser vide pour ne pas changer">
                        @error('password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <!-- Confirmation mot de passe -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Confirmer le nouveau mot de passe</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <!-- Mot de passe actuel (requis si changement) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Mot de passe actuel</label>
                        <input type="password" name="current_password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Requis si vous changez le mot de passe">
                        @error('current_password')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                            <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations complémentaires -->
        <div class="space-y-6">
            <!-- Informations du compte -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Informations du compte</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Membre depuis</span>
                        <span class="font-semibold text-gray-900">{{ $user->created_at->translatedFormat('d/m/Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Statut</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Email vérifié</span>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                            {{ $user->email_verified_at ? 'Oui' : 'Non' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Actions rapides</h3>
                <div class="space-y-2">
                    <a href="{{ route('buyer.tickets') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-ticket-alt w-5 mr-3 text-indigo-600"></i>
                        <span>Mes billets</span>
                    </a>
                    <a href="{{ route('buyer.payments') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-credit-card w-5 mr-3 text-indigo-600"></i>
                        <span>Mes paiements</span>
                    </a>
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <i class="fas fa-search w-5 mr-3 text-indigo-600"></i>
                        <span>Découvrir des événements</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const previewImg = document.getElementById('previewImg');
            previewImg.src = e.target.result;
            preview.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection

