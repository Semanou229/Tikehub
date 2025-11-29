@extends('layouts.dashboard')

@section('title', 'Détails du code promo')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('organizer.promo-codes.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-gray-800">Détails du code promo</h1>
            <div class="flex gap-2">
                <a href="{{ route('organizer.promo-codes.edit', $promoCode) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                    <i class="fas fa-edit mr-2"></i>Modifier
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Détails du code -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations du code</h2>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Code promo</label>
                        <p class="text-2xl font-bold text-indigo-600 font-mono">{{ $promoCode->code }}</p>
                    </div>
                    @if($promoCode->name)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Nom</label>
                            <p class="text-lg text-gray-800">{{ $promoCode->name }}</p>
                        </div>
                    @endif
                    @if($promoCode->description)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Description</label>
                            <p class="text-gray-700">{{ $promoCode->description }}</p>
                        </div>
                    @endif
                    <div>
                        <label class="text-sm font-medium text-gray-500">Événement</label>
                        <p class="text-gray-800">{{ $promoCode->event ? $promoCode->event->title : 'Tous les événements' }}</p>
                    </div>
                </div>
            </div>

            <!-- Paramètres de réduction -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Paramètres de réduction</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Type</label>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $promoCode->discount_type === 'percentage' ? 'Pourcentage' : 'Montant fixe' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Valeur</label>
                        <p class="text-lg font-bold text-green-600">
                            @if($promoCode->discount_type === 'percentage')
                                {{ $promoCode->discount_value }}%
                            @else
                                {{ number_format($promoCode->discount_value, 0, ',', ' ') }} XOF
                            @endif
                        </p>
                    </div>
                    @if($promoCode->minimum_amount)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Montant minimum</label>
                            <p class="text-lg text-gray-800">{{ number_format($promoCode->minimum_amount, 0, ',', ' ') }} XOF</p>
                        </div>
                    @endif
                    @if($promoCode->maximum_discount)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Réduction maximum</label>
                            <p class="text-lg text-gray-800">{{ number_format($promoCode->maximum_discount, 0, ',', ' ') }} XOF</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Limites et dates -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Limites et validité</h2>
                <div class="grid grid-cols-2 gap-4">
                    @if($promoCode->usage_limit)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Limite d'utilisation totale</label>
                            <p class="text-lg text-gray-800">{{ $promoCode->usage_limit }} utilisations</p>
                        </div>
                    @endif
                    @if($promoCode->usage_limit_per_user)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Limite par utilisateur</label>
                            <p class="text-lg text-gray-800">{{ $promoCode->usage_limit_per_user }} utilisation(s)</p>
                        </div>
                    @endif
                    @if($promoCode->start_date)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Date de début</label>
                            <p class="text-lg text-gray-800">{{ $promoCode->start_date->translatedFormat('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                    @if($promoCode->end_date)
                        <div>
                            <label class="text-sm font-medium text-gray-500">Date de fin</label>
                            <p class="text-lg text-gray-800">{{ $promoCode->end_date->translatedFormat('d/m/Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statut -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statut</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">État</label>
                        <div class="mt-1">
                            @if($promoCode->isValid())
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                            @else
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-gray-100 text-gray-800">Inactif</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Utilisations</label>
                        <p class="text-2xl font-bold text-indigo-600 mt-1">
                            {{ $promoCode->usages_count }} / {{ $promoCode->usage_limit ?? '∞' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('organizer.promo-codes.edit', $promoCode) }}" class="block w-full bg-yellow-600 text-white text-center px-4 py-2 rounded-lg hover:bg-yellow-700 transition">
                        <i class="fas fa-edit mr-2"></i>Modifier
                    </a>
                    <form action="{{ route('organizer.promo-codes.destroy', $promoCode) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce code promo ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="block w-full bg-red-600 text-white text-center px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Historique des utilisations -->
    @if($promoCode->usages->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Historique des utilisations</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant original</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Réduction</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant final</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($promoCode->usages as $usage)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $usage->user->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ number_format($usage->original_amount, 0, ',', ' ') }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">
                                    -{{ number_format($usage->discount_amount, 0, ',', ' ') }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-bold">
                                    {{ number_format($usage->final_amount, 0, ',', ' ') }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $usage->created_at->translatedFormat('d/m/Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

