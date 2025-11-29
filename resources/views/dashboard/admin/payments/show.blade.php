@extends('layouts.admin')

@section('title', 'Détails du Paiement #' . $payment->id)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.payments.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Paiement #{{ $payment->id }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
            <div class="space-y-3">
                <div>
                    <p class="text-sm text-gray-600">Utilisateur</p>
                    <p class="font-semibold">{{ $payment->user->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Montant</p>
                    <p class="font-semibold text-lg">{{ number_format($payment->amount, 0, ',', ' ') }} XOF</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Commission plateforme</p>
                    <p class="font-semibold">{{ number_format($payment->platform_commission ?? 0, 0, ',', ' ') }} XOF</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Statut</p>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Date</p>
                    <p class="font-semibold">{{ $payment->created_at->translatedFormat('d M Y à H:i') }}</p>
                </div>
                @if($payment->moneroo_reference)
                    <div>
                        <p class="text-sm text-gray-600">Référence Moneroo</p>
                        <p class="font-mono text-sm">{{ $payment->moneroo_reference }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Détails</h2>
            <div class="space-y-3">
                @if($payment->tickets->count() > 0)
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Événement</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Événement</p>
                        <p class="font-semibold">{{ $payment->tickets->first()->event->title ?? 'N/A' }}</p>
                    </div>
                @elseif($payment->votes->count() > 0)
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Concours</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Concours</p>
                        <p class="font-semibold">{{ $payment->votes->first()->contest->name ?? 'N/A' }}</p>
                    </div>
                @elseif($payment->donation)
                    <div>
                        <p class="text-sm text-gray-600">Type</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Collecte</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Collecte</p>
                        <p class="font-semibold">{{ $payment->donation->fundraising->name ?? 'N/A' }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection


