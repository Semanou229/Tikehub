@extends('layouts.admin')

@section('title', 'Détails de la Demande de Retrait')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.withdrawals.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la Demande de Retrait</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations générales -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-600">Informations Générales</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Organisateur</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $withdrawal->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $withdrawal->user->email }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Montant</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ number_format($withdrawal->amount, 0, ',', ' ') }} XOF</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Statut</p>
                    @if($withdrawal->status === 'pending')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                    @elseif($withdrawal->status === 'approved')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">Approuvé</span>
                    @elseif($withdrawal->status === 'completed')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                    @elseif($withdrawal->status === 'rejected')
                        <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                    @endif
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date de demande</p>
                    <p class="text-gray-900">{{ $withdrawal->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if($withdrawal->processed_at)
                    <div>
                        <p class="text-sm text-gray-600">Traité le</p>
                        <p class="text-gray-900">{{ $withdrawal->processed_at->format('d/m/Y à H:i') }}</p>
                        @if($withdrawal->processor)
                            <p class="text-sm text-gray-500">par {{ $withdrawal->processor->name }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        <!-- Informations de paiement -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-600">Informations de Paiement</h2>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Méthode de paiement</p>
                    <p class="text-lg font-semibold text-gray-900">
                        @if($withdrawal->payment_method === 'mobile_money')
                            Mobile Money
                        @elseif($withdrawal->payment_method === 'bank_transfer')
                            Virement bancaire
                        @elseif($withdrawal->payment_method === 'crypto')
                            Crypto-monnaie
                        @endif
                    </p>
                </div>

                @if($withdrawal->payment_method === 'mobile_money')
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Réseau</p>
                            <p class="text-gray-900 font-semibold">{{ $withdrawal->mobile_network ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Indicatif du pays</p>
                            <p class="text-gray-900">{{ $withdrawal->country_code ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Numéro de téléphone</p>
                            <p class="text-gray-900 font-mono">{{ $withdrawal->phone_number ?? 'N/A' }}</p>
                        </div>
                    </div>
                @elseif($withdrawal->payment_method === 'bank_transfer')
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Nom de la banque</p>
                            <p class="text-gray-900 font-semibold">{{ $withdrawal->bank_name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Numéro de compte</p>
                            <p class="text-gray-900 font-mono">{{ $withdrawal->account_number ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Titulaire du compte</p>
                            <p class="text-gray-900">{{ $withdrawal->account_holder_name ?? 'N/A' }}</p>
                        </div>
                        @if($withdrawal->iban)
                            <div>
                                <p class="text-sm text-gray-600">IBAN</p>
                                <p class="text-gray-900 font-mono">{{ $withdrawal->iban }}</p>
                            </div>
                        @endif
                        @if($withdrawal->swift_code)
                            <div>
                                <p class="text-sm text-gray-600">Code SWIFT</p>
                                <p class="text-gray-900 font-mono">{{ $withdrawal->swift_code }}</p>
                            </div>
                        @endif
                    </div>
                @elseif($withdrawal->payment_method === 'crypto')
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Crypto-monnaie</p>
                            <p class="text-gray-900 font-semibold">{{ $withdrawal->crypto_currency ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Adresse du portefeuille</p>
                            <p class="text-gray-900 font-mono text-xs break-all">{{ $withdrawal->crypto_wallet_address ?? 'N/A' }}</p>
                        </div>
                        @if($withdrawal->crypto_network)
                            <div>
                                <p class="text-sm text-gray-600">Réseau blockchain</p>
                                <p class="text-gray-900">{{ $withdrawal->crypto_network }}</p>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($withdrawal->rejection_reason)
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mt-6 rounded-lg">
            <p class="text-sm font-semibold text-red-800 mb-2">Raison du rejet</p>
            <p class="text-red-700">{{ $withdrawal->rejection_reason }}</p>
        </div>
    @endif

    @if($withdrawal->admin_notes)
        <div class="bg-gray-50 border-l-4 border-gray-500 p-4 mt-6 rounded-lg">
            <p class="text-sm font-semibold text-gray-800 mb-2">Notes administrateur</p>
            <p class="text-gray-700">{{ $withdrawal->admin_notes }}</p>
        </div>
    @endif

    <!-- Actions -->
    @if($withdrawal->status === 'pending')
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
            <div class="flex flex-wrap gap-4">
                <form action="{{ route('admin.withdrawals.approve', $withdrawal) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        <i class="fas fa-check mr-2"></i>Approuver
                    </button>
                </form>
                
                <button onclick="showRejectModal()" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-times mr-2"></i>Rejeter
                </button>
            </div>
        </div>

        <!-- Modal de rejet -->
        <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Rejeter la demande</h3>
                    <form action="{{ route('admin.withdrawals.reject', $withdrawal) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                            <textarea name="rejection_reason" rows="4" required 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                            <textarea name="admin_notes" rows="3" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                        </div>
                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="hideRejectModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Rejeter
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @elseif($withdrawal->status === 'approved')
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
            <form action="{{ route('admin.withdrawals.complete', $withdrawal) }}" method="POST" class="inline">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                    <textarea name="admin_notes" rows="3" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">{{ $withdrawal->admin_notes }}</textarea>
                </div>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    <i class="fas fa-check-circle mr-2"></i>Marquer comme complété
                </button>
            </form>
        </div>
    @endif

    <script>
        function showRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }
        
        function hideRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    </script>
</div>
@endsection

