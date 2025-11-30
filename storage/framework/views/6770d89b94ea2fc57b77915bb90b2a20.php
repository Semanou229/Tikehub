<?php $__env->startSection('title', 'Dashboard Organisateur'); ?>

<?php $__env->startSection('content'); ?>
<!-- Bannière de bienvenue -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 p-4 sm:p-6 lg:p-8 mb-4 sm:mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex-1">
            <div class="flex items-center mb-3 sm:mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-white/20 rounded-lg flex items-center justify-center mr-2 sm:mr-3">
                    <i class="fas fa-ticket-alt text-white text-xl sm:text-2xl"></i>
                </div>
                <span class="text-xl sm:text-2xl font-bold text-white">Tikehub</span>
            </div>
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-2">Bienvenue, <?php echo e(auth()->user()->name); ?></h1>
            <p class="text-sm sm:text-base text-indigo-100">Voici un aperçu de votre espace organisateur</p>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 mt-3 sm:mt-4">
                <span class="bg-white/20 backdrop-blur-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm text-white truncate">
                    <?php echo e(auth()->user()->email); ?>

                </span>
                <span class="bg-white/20 backdrop-blur-sm px-3 sm:px-4 py-1.5 sm:py-2 rounded-full text-xs sm:text-sm text-white flex items-center gap-2">
                    <i class="fas fa-wallet"></i>
                    <span class="whitespace-nowrap"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> XOF disponible</span>
                </span>
            </div>
        </div>
        <div class="hidden md:block flex-shrink-0">
            <div class="w-20 h-20 lg:w-24 lg:h-24 bg-white/10 rounded-full flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-3xl lg:text-4xl opacity-50"></i>
            </div>
        </div>
    </div>
</div>

<div class="p-3 sm:p-4 lg:p-6">
    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <!-- Événements actifs -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Événements actifs</p>
                    <p class="text-4xl font-bold text-indigo-600"><?php echo e($stats['active_events']); ?></p>
                </div>
                <div class="w-16 h-16 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-indigo-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="far fa-clock mr-2"></i>
                <span><?php echo e($stats['completed_events']); ?> terminés</span>
            </div>
        </div>

        <!-- Concours actifs -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Concours actifs</p>
                    <p class="text-4xl font-bold text-green-600"><?php echo e($contests->where('is_active', true)->where('end_date', '>=', now())->count()); ?></p>
                </div>
                <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-trophy text-green-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="fas fa-bolt mr-2"></i>
                <span><?php echo e($contests->count()); ?> concours au total</span>
            </div>
        </div>

        <!-- Total dépensé / Revenus -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total revenus</p>
                    <p class="text-4xl font-bold text-purple-600"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> XOF</p>
                </div>
                <div class="w-16 h-16 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-purple-600 text-2xl"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-gray-500">
                <i class="far fa-clock mr-2"></i>
                <span><?php echo e($stats['pending_payments']); ?> paiements en attente</span>
            </div>
        </div>

        <!-- Solde wallet / Billets vendus -->
        <div class="bg-white rounded-lg shadow-md p-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-orange-100 rounded-full -mr-12 -mt-12 opacity-50"></div>
            <div class="flex items-center justify-between mb-4 relative z-10">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Billets vendus</p>
                    <p class="text-4xl font-bold text-orange-600"><?php echo e(number_format($stats['total_tickets'], 0, ',', ' ')); ?></p>
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

    <!-- Statistiques événements virtuels -->
    <?php if(isset($stats['virtual_stats']) && $stats['virtual_stats']['total_virtual_events'] > 0): ?>
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-video text-blue-600 mr-2"></i>
                    Événements Virtuels
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Événements virtuels</p>
                    <p class="text-2xl font-bold text-blue-600"><?php echo e($stats['virtual_stats']['total_virtual_events']); ?></p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Participants connectés</p>
                    <p class="text-2xl font-bold text-indigo-600"><?php echo e($stats['virtual_stats']['total_virtual_participants']); ?></p>
                </div>
                <div class="bg-white rounded-lg p-4 border border-blue-200">
                    <p class="text-sm text-gray-600 mb-1">Total accès</p>
                    <p class="text-2xl font-bold text-purple-600"><?php echo e($stats['virtual_stats']['total_virtual_accesses']); ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Graphiques et tableaux -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenus (6 derniers mois) -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Revenus (6 derniers mois)</h2>
                <i class="fas fa-chart-line text-indigo-600"></i>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Répartition des revenus -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Répartition des revenus</h2>
                <i class="fas fa-chart-pie text-purple-600"></i>
            </div>
            <div style="position: relative; height: 300px;">
                <canvas id="distributionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Derniers événements -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Mes Événements</h2>
            <a href="<?php echo e(route('events.create')); ?>" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                <i class="fas fa-plus mr-2"></i>Nouvel événement
            </a>
        </div>
        <?php if($events->count() > 0): ?>
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
                        <?php $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($event->title); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($event->category); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e($event->start_date->format('d/m/Y')); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($event->start_date->format('H:i')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e($event->tickets_count); ?> vendus</div>
                                    <div class="text-sm text-gray-500"><?php echo e($event->ticket_types_count); ?> types</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col gap-1">
                                        <?php if($event->is_published): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Publié
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Brouillon
                                            </span>
                                        <?php endif; ?>
                                        <?php if($event->is_virtual): ?>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                <i class="fas fa-video mr-1"></i>Virtuel
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?php echo e(route('events.show', $event)); ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo e(route('events.edit', $event)); ?>" class="text-gray-600 hover:text-gray-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-4">Aucun événement créé pour le moment</p>
                <a href="<?php echo e(route('events.create')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Créer mon premier événement
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Concours et Collectes -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Derniers concours -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Mes Concours (<?php echo e($contests->count()); ?>)</h2>
                <a href="<?php echo e(route('contests.create')); ?>" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouveau
                </a>
            </div>
            <?php if($contests->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $contests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1"><?php echo e($contest->name); ?></h3>
                                    <?php if($contest->description): ?>
                                        <p class="text-sm text-gray-600 line-clamp-2"><?php echo e(Str::limit($contest->description, 80)); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="ml-4 flex flex-col items-end gap-2">
                                    <?php if($contest->is_published): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                    <?php endif; ?>
                                    <?php if($contest->isActive()): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Actif</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminé</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-3 text-sm">
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-vote-yea text-purple-600 mr-2"></i>
                                    <span><strong><?php echo e(number_format($contest->votes_count, 0, ',', ' ')); ?></strong> votes</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-users text-purple-600 mr-2"></i>
                                    <span><strong><?php echo e($contest->candidates()->count()); ?></strong> candidats</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-coins text-purple-600 mr-2"></i>
                                    <span><?php echo e(number_format($contest->price_per_vote, 0, ',', ' ')); ?> XOF/vote</span>
                                </div>
                                <div class="flex items-center text-gray-600">
                                    <i class="fas fa-calendar text-purple-600 mr-2"></i>
                                    <span><?php echo e($contest->end_date->format('d/m/Y')); ?></span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between pt-3 border-t border-gray-200">
                                <div class="text-xs text-gray-500">
                                    <i class="fas fa-clock mr-1"></i>
                                    Créé le <?php echo e($contest->created_at->format('d/m/Y')); ?>

                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="<?php echo e(route('contests.show', $contest)); ?>" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>Voir
                                    </a>
                                    <?php if(!$contest->is_published): ?>
                                        <form action="<?php echo e(route('contests.publish', $contest)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                <i class="fas fa-check mr-1"></i>Publier
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-trophy text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-3">Aucun concours créé</p>
                    <a href="<?php echo e(route('contests.create')); ?>" class="text-purple-600 hover:text-purple-800 text-sm font-semibold">
                        Créer un concours
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Dernières collectes -->
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Mes Collectes</h2>
                <a href="<?php echo e(route('fundraisings.create')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouvelle
                </a>
            </div>
            <?php if($fundraisings->count() > 0): ?>
                <div class="space-y-4">
                    <?php $__currentLoopData = $fundraisings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fundraising): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900"><?php echo e($fundraising->name); ?></h3>
                                <?php if($fundraising->is_active): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                                <?php endif; ?>
                            </div>
                            <div class="mb-2">
                                <div class="flex justify-between text-sm text-gray-600 mb-1">
                                    <span><?php echo e(number_format($fundraising->current_amount, 0, ',', ' ')); ?> XOF</span>
                                    <span><?php echo e(number_format($fundraising->goal_amount, 0, ',', ' ')); ?> XOF</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: <?php echo e(min(100, $fundraising->progress_percentage)); ?>%"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <span><?php echo e(number_format($fundraising->progress_percentage, 1)); ?>% atteint</span>
                                <a href="<?php echo e(route('fundraisings.show', $fundraising)); ?>" class="text-green-600 hover:text-green-800">
                                    Voir <i class="fas fa-arrow-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <i class="fas fa-heart text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500 text-sm mb-3">Aucune collecte créée</p>
                    <a href="<?php echo e(route('fundraisings.create')); ?>" class="text-green-600 hover:text-green-800 text-sm font-semibold">
                        Créer une collecte
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Vérifier que Chart.js est chargé
    if (typeof Chart === 'undefined') {
        console.error('Chart.js n\'est pas chargé');
        return;
    }

    // Données pour les graphiques
    const monthlyRevenueData = <?php echo json_encode($stats['monthly_revenue'] ?? []); ?>;
    const revenueLabels = monthlyRevenueData.map(item => item.month || '');
    const revenueValues = monthlyRevenueData.map(item => parseFloat(item.revenue) || 0);

    const distributionData = {
        events: <?php echo e($stats['revenue_distribution']['events'] ?? 0); ?>,
        contests: <?php echo e($stats['revenue_distribution']['contests'] ?? 0); ?>,
        fundraisings: <?php echo e($stats['revenue_distribution']['fundraisings'] ?? 0); ?>

    };

    // Graphique des revenus (6 derniers mois)
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueChart = new Chart(revenueCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: revenueLabels,
                datasets: [{
                    label: 'Revenus (XOF)',
                    data: revenueValues,
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
                                return 'Revenus: ' + new Intl.NumberFormat('fr-FR').format(context.parsed.y) + ' XOF';
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

    // Graphique de répartition des revenus
    const distributionCtx = document.getElementById('distributionChart');
    if (distributionCtx) {
        const totalDistribution = distributionData.events + distributionData.contests + distributionData.fundraisings;
        
        const distributionChart = new Chart(distributionCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Événements', 'Concours', 'Collectes'],
                datasets: [{
                    data: [
                        distributionData.events,
                        distributionData.contests,
                        distributionData.fundraisings
                    ],
                    backgroundColor: [
                        'rgb(99, 102, 241)',
                        'rgb(147, 51, 234)',
                        'rgb(34, 197, 94)'
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
                                const percentage = totalDistribution > 0 ? ((value / totalDistribution) * 100).toFixed(1) : 0;
                                return label + ': ' + new Intl.NumberFormat('fr-FR').format(value) + ' XOF (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer.blade.php ENDPATH**/ ?>