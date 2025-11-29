@extends('layouts.dashboard')

@section('title', 'Dashboard Organisateur')

@section('content')
<!-- Bannière de bienvenue -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-8 mb-6">
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center mr-3">
                    <i class="fas fa-ticket-alt text-white text-2xl"></i>
                </div>
                <span class="text-2xl font-bold text-white">Tikehub</span>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">Bienvenue, {{ auth()->user()->name }}</h1>
            <p class="text-indigo-100">Voici un aperçu de votre espace organisateur</p>
            <div class="flex gap-3 mt-4">
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-white">
                    {{ auth()->user()->email }}
                </span>
                <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-sm text-white flex items-center gap-2">
                    <i class="fas fa-wallet"></i>
                    {{ number_format($stats['total_revenue'], 0, ',', ' ') }} XOF disponible
                </span>
            </div>
        </div>
        <div class="hidden md:block">
            <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-4xl opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="p-6">
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Événements actifs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Événements actifs</p>
                    <p class="text-4xl font-bold text-indigo-600">{{ $stats['active_events'] }}</p>
                </div>
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-indigo-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="far fa-clock mr-2"></i>
                <span>{{ $stats['completed_events'] }} terminés</span>
            </div>
        </div>

        <!-- Concours actifs -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Concours actifs</p>
                    <p class="text-4xl font-bold text-green-600">{{ $contests->where('is_active', true)->where('end_date', '>=', now())->count() }}</p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trophy text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-bolt mr-2"></i>
                <span>{{ $contests->count() }} concours au total</span>
            </div>
        </div>

        <!-- Total dépensé / Revenus -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total revenus</p>
                    <p class="text-4xl font-bold text-purple-600">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XOF</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="far fa-clock mr-2"></i>
                <span>{{ $stats['pending_payments'] }} paiements en attente</span>
            </div>
        </div>

        <!-- Solde wallet / Billets vendus -->
        <div class="bg-white rounded-lg shadow-md p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100 rounded-full -mr-12 -mt-12 opacity-50"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Billets vendus</p>
                    <p class="text-4xl font-bold text-orange-600">{{ number_format($stats['total_tickets'], 0, ',', ' ') }}</p>
                </div>
                <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center relative z-10">
                    <i class="fas fa-ticket-alt text-orange-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500 relative z-10">
                <i class="fas fa-wallet mr-2"></i>
                <span>Crédit disponible</span>
            </div>
        </div>
    </div>

    <!-- Graphiques et tableaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenus (6 derniers mois) -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Revenus (6 derniers mois)</h2>
                <i class="fas fa-chart-line text-indigo-600"></i>
            </div>
            <canvas id="revenueChart" height="200"></canvas>
        </div>

        <!-- Répartition des revenus -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Répartition des revenus</h2>
                <i class="fas fa-chart-pie text-purple-600"></i>
            </div>
            <canvas id="distributionChart" height="200"></canvas>
        </div>
    </div>

    <!-- Derniers événements -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Mes Événements</h2>
            <a href="{{ route('events.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                <i class="fas fa-plus mr-2"></i>Nouvel événement
            </a>
        </div>
        @if($events->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Événement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Billets</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($events as $event)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $event->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->category }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $event->start_date->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">{{ $event->start_date->format('H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $event->tickets_count }} vendus</div>
                                    <div class="text-sm text-gray-500">{{ $event->ticket_types_count }} types</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($event->is_published)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Publié
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            Brouillon
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('events.edit', $event) }}" class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Aucun événement créé pour le moment</p>
                <a href="{{ route('events.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Créer mon premier événement
                </a>
            </div>
        @endif
    </div>

    <!-- Concours et Collectes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Derniers concours -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Mes Concours</h2>
                <a href="{{ route('contests.create') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouveau
                </a>
            </div>
            @if($contests->count() > 0)
                <div class="space-y-4">
                    @foreach($contests as $contest)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $contest->name }}</h3>
                                @if($contest->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminé</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span><i class="fas fa-vote-yea mr-1"></i>{{ number_format($contest->votes_count, 0, ',', ' ') }} votes</span>
                                <a href="{{ route('contests.show', $contest) }}" class="text-purple-600 hover:text-purple-800">
                                    Voir <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-trophy text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-3">Aucun concours créé</p>
                    <a href="{{ route('contests.create') }}" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">
                        Créer un concours
                    </a>
                </div>
            @endif
        </div>

        <!-- Dernières collectes -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Mes Collectes</h2>
                <a href="{{ route('fundraisings.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouvelle
                </a>
            </div>
            @if($fundraisings->count() > 0)
                <div class="space-y-4">
                    @foreach($fundraisings as $fundraising)
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900">{{ $fundraising->name }}</h3>
                                @if($fundraising->is_active)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                                @endif
                            </div>
                            <div class="mb-2">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                    <span>{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span>{{ number_format($fundraising->progress_percentage, 1) }}% atteint</span>
                                <a href="{{ route('fundraisings.show', $fundraising) }}" class="text-green-600 hover:text-green-800">
                                    Voir <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-heart text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-3">Aucune collecte créée</p>
                    <a href="{{ route('fundraisings.create') }}" class="text-green-600 hover:text-green-800 text-sm font-semibold">
                        Créer une collecte
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Graphique des revenus
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($stats['monthly_revenue'], 'month')) !!},
            datasets: [{
                label: 'Revenus (XOF)',
                data: {!! json_encode(array_column($stats['monthly_revenue'], 'revenue')) !!},
                borderColor: 'rgb(99, 102, 241)',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('fr-FR').format(value) + ' XOF';
                        }
                    }
                }
            }
        }
    });

    // Graphique de répartition
    const distributionCtx = document.getElementById('distributionChart').getContext('2d');
    new Chart(distributionCtx, {
        type: 'doughnut',
        data: {
            labels: ['Événements', 'Concours', 'Collectes'],
            datasets: [{
                data: [
                    {{ $stats['revenue_distribution']['events'] }},
                    {{ $stats['revenue_distribution']['contests'] }},
                    {{ $stats['revenue_distribution']['fundraisings'] }}
                ],
                backgroundColor: [
                    'rgb(99, 102, 241)',
                    'rgb(147, 51, 234)',
                    'rgb(34, 197, 94)'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('fr-FR').format(context.parsed) + ' XOF';
                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection

