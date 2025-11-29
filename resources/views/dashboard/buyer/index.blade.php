@extends('layouts.buyer-dashboard')

@section('title', 'Mon Tableau de Bord')

@section('content')
<!-- Bannière de bienvenue -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <span class="text-2xl font-bold text-white">Tikehub</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Bienvenue, {{ auth()->user()->name }}</h1>
            <p class="text-indigo-100">Gérez vos billets et événements en un seul endroit</p>
        </div>
        <div class="hidden md:block">
            <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-ticket-alt text-white text-4xl opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="p-6">
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total billets -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total billets</p>
                    <p class="text-4xl font-bold text-indigo-600">{{ $stats['total_tickets'] }}</p>
                </div>
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ticket-alt text-indigo-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-calendar-check mr-2"></i>
                <span>{{ $stats['upcoming_tickets'] }} à venir</span>
            </div>
        </div>

        <!-- Billets à venir -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Événements à venir</p>
                    <p class="text-4xl font-bold text-green-600">{{ $stats['upcoming_tickets'] }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-clock mr-2"></i>
                <span>{{ $stats['past_tickets'] }} passés</span>
            </div>
        </div>

        <!-- Événements virtuels -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Événements virtuels</p>
                    <p class="text-4xl font-bold text-blue-600">{{ $stats['virtual_tickets'] }}</p>
                </div>
                <div class="w-16 h-16 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-video text-blue-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-link mr-2"></i>
                <span>Accès en ligne</span>
            </div>
        </div>

        <!-- Total dépensé -->
        <div class="bg-white rounded-lg shadow-md p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-purple-100 rounded-full -mr-12 -mt-12 opacity-50"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total dépensé</p>
                    <p class="text-4xl font-bold text-purple-600">{{ number_format($stats['total_spent'], 0, ',', ' ') }} XOF</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center relative z-10">
                    <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500 relative z-10">
                <i class="fas fa-chart-line mr-2"></i>
                <span>Dépenses totales</span>
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Dépenses (6 derniers mois) -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Dépenses (6 derniers mois)</h2>
                <i class="fas fa-chart-line text-indigo-600"></i>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="spendingChart"></canvas>
            </div>
        </div>

        <!-- Répartition par catégorie -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Répartition par catégorie</h2>
                <i class="fas fa-chart-pie text-purple-600"></i>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tickets à venir -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Mes Prochains Événements</h2>
            <a href="{{ route('buyer.tickets', ['status' => 'upcoming']) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                Voir tout <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        @if($upcomingTicketsList->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($upcomingTicketsList as $ticket)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-lg transition">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $ticket->event->title }}</h3>
                                <p class="text-sm text-gray-600">{{ $ticket->ticketType->name }}</p>
                            </div>
                            @if($ticket->event->is_virtual)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-video"></i> Virtuel
                                </span>
                            @endif
                        </div>
                        <div class="space-y-2 mb-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2 w-4"></i>
                                <span>{{ $ticket->event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                            </div>
                            @if(!$ticket->event->is_virtual && $ticket->event->venue_city)
                                <div class="flex items-center">
                                    <i class="fas fa-map-marker-alt text-indigo-600 mr-2 w-4"></i>
                                    <span>{{ $ticket->event->venue_city }}</span>
                                </div>
                            @endif
                            <div class="flex items-center">
                                <i class="fas fa-barcode text-indigo-600 mr-2 w-4"></i>
                                <span class="font-mono text-xs">{{ $ticket->code }}</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                            <a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                <i class="fas fa-eye mr-1"></i>Voir le billet
                            </a>
                            @if($ticket->event->is_virtual && $ticket->virtual_access_token)
                                <a href="{{ $ticket->getVirtualAccessUrl() }}" target="_blank" class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 text-sm">
                                    <i class="fas fa-video mr-1"></i>Rejoindre
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Aucun événement à venir</p>
                <a href="{{ route('home') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-search mr-2"></i>Découvrir des événements
                </a>
            </div>
        @endif
    </div>

    <!-- Événements virtuels -->
    @if($virtualEventsTickets->count() > 0)
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-video text-blue-600 mr-2"></i>
                    Mes Événements Virtuels
                </h2>
                <a href="{{ route('buyer.virtual-events') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($virtualEventsTickets->take(4) as $ticket)
                    <div class="bg-white rounded-lg p-4 border border-blue-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $ticket->event->title }}</h3>
                                <p class="text-xs text-gray-600">{{ ucfirst(str_replace('_', ' ', $ticket->event->platform_type ?? 'Visioconférence')) }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-video"></i>
                            </span>
                        </div>
                        <div class="space-y-2 mb-3 text-sm text-gray-600">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-alt text-blue-600 mr-2 w-4"></i>
                                <span>{{ $ticket->event->start_date->translatedFormat('d/m/Y H:i') }}</span>
                            </div>
                            @if($ticket->event->virtual_access_instructions)
                                <p class="text-xs text-gray-500 italic">{{ \Illuminate\Support\Str::limit($ticket->event->virtual_access_instructions, 60) }}</p>
                            @endif
                        </div>
                        @if($ticket->virtual_access_token)
                            <a href="{{ $ticket->getVirtualAccessUrl() }}" target="_blank" class="block w-full bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                <i class="fas fa-video mr-2"></i>Rejoindre l'événement
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Derniers paiements -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Derniers Paiements</h2>
            <a href="{{ route('buyer.payments') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                Voir tout <i class="fas fa-arrow-right ml-1"></i>
            </a>
        </div>
        @if($recentPayments->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentPayments->take(5) as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $payment->created_at->translatedFormat('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($payment->event)
                                        {{ $payment->event->title }}
                                    @elseif($payment->paymentable)
                                        {{ class_basename($payment->paymentable_type) }}: {{ $payment->paymentable->name ?? $payment->paymentable->title ?? 'N/A' }}
                                    @else
                                        Paiement
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    {{ number_format($payment->amount, 0, ',', ' ') }} XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        {{ $payment->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-8">
                <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Aucun paiement enregistré</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que Chart.js est chargé
    if (typeof Chart === 'undefined') {
        console.error('Chart.js n\'est pas chargé');
        return;
    }

    // Données pour les graphiques
    const monthlySpendingData = {!! json_encode($stats['monthly_spending'] ?? []) !!};
    const spendingLabels = monthlySpendingData.map(item => item.month || '');
    const spendingValues = monthlySpendingData.map(item => parseFloat(item.amount) || 0);

    const categoryData = {!! json_encode($stats['category_spending'] ?? []) !!};
    const categoryLabels = Object.keys(categoryData);
    const categoryValues = Object.values(categoryData).map(v => parseFloat(v) || 0);

    // Graphique des dépenses (6 derniers mois)
    const spendingCtx = document.getElementById('spendingChart');
    if (spendingCtx) {
        const spendingChart = new Chart(spendingCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: spendingLabels,
                datasets: [{
                    label: 'Dépenses (XOF)',
                    data: spendingValues,
                    borderColor: 'rgb(99, 102, 241)',
                    backgroundColor: 'rgba(99, 102, 241, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    pointBackgroundColor: 'rgb(99, 102, 241)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Dépenses: ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' XOF';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('fr-FR').format(value) + ' XOF';
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }

    // Graphique de répartition par catégorie
    const categoryCtx = document.getElementById('categoryChart');
    if (categoryCtx && categoryLabels.length > 0) {
        const categoryChart = new Chart(categoryCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: [
                        'rgb(99, 102, 241)',
                        'rgb(147, 51, 234)',
                        'rgb(34, 197, 94)',
                        'rgb(251, 146, 60)',
                        'rgb(239, 68, 68)',
                        'rgb(59, 130, 246)',
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = categoryValues.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + new Intl.NumberFormat('fr-FR').format(value) + ' XOF (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    } else if (categoryCtx) {
        categoryCtx.parentElement.innerHTML = '<div class="flex items-center justify-center h-full text-gray-500">Aucune donnée disponible</div>';
    }
});
</script>
@endpush
@endsection

