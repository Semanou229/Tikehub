@extends('layouts.admin')

@section('title', $user->name)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">{{ $user->name }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations utilisateur -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>
                    @if($user->phone)
                        <div>
                            <p class="text-sm text-gray-600">Téléphone</p>
                            <p class="font-semibold">{{ $user->phone }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Rôles</p>
                        <div class="flex gap-2 mt-1">
                            @foreach($user->roles as $role)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($role->name) }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Statut</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Inscrit le</p>
                        <p class="font-semibold">{{ $user->created_at->translatedFormat('d M Y à H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Statistiques</h2>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Événements</p>
                        <p class="text-2xl font-bold text-red-600">{{ $stats['total_events'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Billets</p>
                        <p class="text-2xl font-bold text-blue-600">{{ $stats['total_tickets'] }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Dépenses</p>
                        <p class="text-2xl font-bold text-green-600">{{ number_format($stats['total_spent'], 0, ',', ' ') }} XOF</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
                <div class="space-y-3">
                    <!-- Changer le rôle -->
                    <form action="{{ route('admin.users.updateRole', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <label class="block text-sm font-medium text-gray-700 mb-2">Changer le rôle</label>
                        <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg mb-2">
                            @foreach(\Spatie\Permission\Models\Role::all() as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            Mettre à jour
                        </button>
                    </form>

                    <!-- Activer/Désactiver -->
                    <form action="{{ route('admin.users.toggleStatus', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-{{ $user->is_active ? 'orange' : 'green' }}-600 text-white px-4 py-2 rounded-lg hover:bg-{{ $user->is_active ? 'orange' : 'green' }}-700 transition">
                            {{ $user->is_active ? 'Désactiver' : 'Activer' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


