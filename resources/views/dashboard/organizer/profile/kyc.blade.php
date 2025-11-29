@extends('layouts.dashboard')

@section('title', 'Vérification KYC')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Vérification KYC</h1>
        <p class="text-gray-600 mt-2">Soumettez vos documents pour vérification</p>
    </div>

    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-6">
            @if($user->isKycVerified())
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 text-2xl mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-green-800">Votre compte est vérifié</h3>
                            <p class="text-sm text-green-700">Vérifié le {{ $user->kyc_verified_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
            @elseif($user->kyc_status === 'pending')
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-yellow-600 text-2xl mr-3"></i>
                        <div>
                            <h3 class="font-semibold text-yellow-800">Vérification en cours</h3>
                            <p class="text-sm text-yellow-700">Votre document est en cours de vérification par notre équipe.</p>
                            @if($user->kyc_submitted_at)
                                <p class="text-xs text-yellow-600 mt-1">Soumis le {{ $user->kyc_submitted_at->format('d/m/Y à H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            @if(!$user->isKycVerified())
                <form action="{{ route('organizer.profile.kyc.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de document *</label>
                            <select name="kyc_document_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Sélectionner un type</option>
                                <option value="id_card" {{ old('kyc_document_type', $user->kyc_document_type) == 'id_card' ? 'selected' : '' }}>Carte d'identité</option>
                                <option value="passport" {{ old('kyc_document_type', $user->kyc_document_type) == 'passport' ? 'selected' : '' }}>Passeport</option>
                                <option value="business_license" {{ old('kyc_document_type', $user->kyc_document_type) == 'business_license' ? 'selected' : '' }}>Licence commerciale</option>
                            </select>
                            @error('kyc_document_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Document *</label>
                            <input type="file" name="kyc_document" accept=".pdf,.jpg,.jpeg,.png" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @error('kyc_document')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG (max 5MB)</p>
                        </div>

                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-blue-800 mb-2">Instructions :</h4>
                            <ul class="text-sm text-blue-700 space-y-1 list-disc list-inside">
                                <li>Assurez-vous que le document est clair et lisible</li>
                                <li>Le document doit être valide et non expiré</li>
                                <li>Toutes les informations doivent être visibles</li>
                                <li>La vérification peut prendre 24-48 heures</li>
                            </ul>
                        </div>

                        <div class="flex items-center gap-4">
                            <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                                <i class="fas fa-upload mr-2"></i>Soumettre le document
                            </button>
                            <a href="{{ route('organizer.profile.index') }}" class="text-gray-600 hover:text-gray-800">
                                Retour
                            </a>
                        </div>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <a href="{{ route('organizer.profile.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                        <i class="fas fa-arrow-left mr-2"></i>Retour au profil
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

