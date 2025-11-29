@extends('layouts.admin')

@section('title', 'Vérification KYC - ' . $user->name)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.kyc.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Vérification KYC</h1>
        <p class="text-gray-600 mt-1">{{ $user->name }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations utilisateur -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-600">Nom</p>
                        <p class="font-semibold">{{ $user->name }}</p>
                    </div>
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
                    @if($user->company_name)
                        <div>
                            <p class="text-sm text-gray-600">Entreprise</p>
                            <p class="font-semibold">{{ $user->company_name }}</p>
                        </div>
                    @endif
                    <div>
                        <p class="text-sm text-gray-600">Type de document</p>
                        <p class="font-semibold">{{ ucfirst($user->kyc_document_type ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Soumis le</p>
                        <p class="font-semibold">{{ $user->kyc_submitted_at ? $user->kyc_submitted_at->translatedFormat('d M Y à H:i') : 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <!-- Document KYC -->
            @if($user->kyc_document)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Document KYC</h2>
                    <div class="border border-gray-200 rounded-lg p-4">
                        <img src="{{ asset('storage/' . $user->kyc_document) }}" alt="Document KYC" class="max-w-full h-auto rounded-lg">
                    </div>
                    <a href="{{ asset('storage/' . $user->kyc_document) }}" target="_blank" class="mt-4 inline-block text-red-600 hover:text-red-800">
                        <i class="fas fa-external-link-alt mr-2"></i>Ouvrir dans un nouvel onglet
                    </a>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-md p-6">
                    <p class="text-gray-500">Aucun document KYC soumis</p>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>
                <div class="space-y-3">
                    <form action="{{ route('admin.kyc.approve', $user) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check mr-2"></i>Approuver
                        </button>
                    </form>
                    <form action="{{ route('admin.kyc.reject', $user) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet (optionnel)</label>
                            <textarea name="reason" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg"></textarea>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-times mr-2"></i>Rejeter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

