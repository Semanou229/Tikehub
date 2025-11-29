@extends('layouts.dashboard')

@section('title', 'Détails du Paiement')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Détails du Paiement</h1>
        <a href="{{ route('organizer.payments.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">ID du paiement</h3>
                <p class="text-lg font-semibold text-gray-900">#{{ $payment->id }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Statut</h3>
                @if($payment->status === 'completed')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                @elseif($payment->status === 'pending')
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">En attente</span>
                @else
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">{{ $payment->status }}</span>
                @endif
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Montant total</h3>
                <p class="text-lg font-semibold text-gray-900">{{ number_format($payment->amount, 0, ',', ' ') }} XOF</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Montant organisateur</h3>
                <p class="text-lg font-semibold text-green-600">{{ number_format($payment->organizer_amount ?? $payment->amount, 0, ',', ' ') }} XOF</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Type</h3>
                <p class="text-lg text-gray-900">
                    @if($payment->event)
                        Événement: {{ $payment->event->title }}
                    @elseif($payment->paymentable)
                        {{ class_basename($payment->paymentable_type) }}
                    @else
                        N/A
                    @endif
                </p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Date</h3>
                <p class="text-lg text-gray-900">{{ $payment->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection


