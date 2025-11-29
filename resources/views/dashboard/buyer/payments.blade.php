@extends('layouts.buyer-dashboard')

@section('title', 'Mes Paiements')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Historique des Paiements</h1>
    </div>

    @if($payments->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Méthode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->created_at->translatedFormat('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if($payment->event)
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                                            <div>
                                                <div class="font-medium">{{ $payment->event->title }}</div>
                                                @if($payment->event->is_virtual)
                                                    <span class="text-xs text-blue-600">Événement virtuel</span>
                                                @endif
                                            </div>
                                        </div>
                                    @elseif($payment->paymentable)
                                        <div class="flex items-center">
                                            @if($payment->paymentable_type === 'App\Models\Contest')
                                                <i class="fas fa-trophy text-purple-600 mr-2"></i>
                                            @elseif($payment->paymentable_type === 'App\Models\Fundraising')
                                                <i class="fas fa-heart text-red-600 mr-2"></i>
                                            @else
                                                <i class="fas fa-receipt text-gray-600 mr-2"></i>
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $payment->paymentable->name ?? $payment->paymentable->title ?? 'N/A' }}</div>
                                                <span class="text-xs text-gray-500">{{ class_basename($payment->paymentable_type) }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">Paiement</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ ucfirst($payment->payment_method ?? 'N/A') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ number_format($payment->amount, 0, ',', ' ') }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                           ($payment->status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                                        @if($payment->status === 'completed')
                                            <i class="fas fa-check-circle mr-1"></i>Complété
                                        @elseif($payment->status === 'pending')
                                            <i class="fas fa-clock mr-1"></i>En attente
                                        @elseif($payment->status === 'failed')
                                            <i class="fas fa-times-circle mr-1"></i>Échoué
                                        @else
                                            {{ ucfirst($payment->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-mono text-xs">
                                    {{ $payment->moneroo_reference ?? 'N/A' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-receipt text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun paiement enregistré</p>
            <a href="{{ route('events.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-search mr-2"></i>Découvrir des événements
            </a>
        </div>
    @endif
</div>
@endsection

