

<?php $__env->startSection('title', 'Dashboard Administrateur'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Dashboard Administrateur</h1>
        <p class="text-gray-600 mt-2">Vue d'ensemble de la plateforme</p>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Événements</p>
                    <p class="text-3xl font-bold"><?php echo e($stats['total_events']); ?></p>
                    <p class="text-blue-100 text-sm mt-1"><?php echo e($stats['published_events']); ?> publiés</p>
                </div>
                <i class="fas fa-calendar-alt text-4xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-green-100 text-sm mb-1">Utilisateurs</p>
                    <p class="text-3xl font-bold"><?php echo e($stats['total_users']); ?></p>
                    <p class="text-green-100 text-sm mt-1"><?php echo e($stats['total_organizers']); ?> organisateurs</p>
                </div>
                <i class="fas fa-users text-4xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Revenus plateforme</p>
                    <p class="text-3xl font-bold"><?php echo e(number_format($stats['total_revenue'], 0, ',', ' ')); ?> XOF</p>
                    <p class="text-purple-100 text-sm mt-1"><?php echo e($stats['total_transactions']); ?> transactions</p>
                </div>
                <i class="fas fa-wallet text-4xl text-purple-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-orange-100 text-sm mb-1">KYC en attente</p>
                    <p class="text-3xl font-bold"><?php echo e($stats['pending_kyc']); ?></p>
                    <p class="text-orange-100 text-sm mt-1">À vérifier</p>
                </div>
                <i class="fas fa-id-card text-4xl text-orange-200"></i>
            </div>
        </div>
    </div>

    <!-- Signalements en attente -->
    <?php if(isset($totalPendingReports) && $totalPendingReports > 0): ?>
        <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-lg shadow-lg p-6 text-white mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm mb-1">Signalements en attente</p>
                    <p class="text-3xl font-bold"><?php echo e($totalPendingReports); ?></p>
                    <p class="text-red-100 text-sm mt-1">À examiner</p>
                </div>
                <i class="fas fa-flag text-4xl text-red-200"></i>
            </div>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Graphique des revenus -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Revenus des 6 derniers mois</h2>
            <canvas id="revenueChart" height="100"></canvas>
        </div>

        <!-- Répartition des revenus -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Répartition des revenus</h2>
            <canvas id="revenueDistributionChart" height="100"></canvas>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Événements récents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Événements récents</h2>
                <a href="<?php echo e(route('admin.events.index')); ?>" class="text-red-600 hover:text-red-800 text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php if($recentEvents->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $recentEvents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.events.show', $event)); ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo e($event->title); ?></h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-user mr-1"></i><?php echo e($event->organizer->name); ?>

                                        <span class="ml-3">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <?php echo e($event->start_date->translatedFormat('d M Y')); ?>

                                        </span>
                                    </p>
                                </div>
                                <div class="ml-4">
                                    <?php if($event->is_published): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucun événement</p>
            <?php endif; ?>
        </div>

        <!-- KYC en attente -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">KYC en attente</h2>
                <a href="<?php echo e(route('admin.kyc.index')); ?>" class="text-red-600 hover:text-red-800 text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <?php if($pendingKyc->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $pendingKyc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('admin.kyc.show', $user)); ?>" class="block p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800"><?php echo e($user->name); ?></h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        <i class="fas fa-envelope mr-1"></i><?php echo e($user->email); ?>

                                        <?php if($user->kyc_submitted_at): ?>
                                            <span class="ml-3">
                                                <i class="fas fa-clock mr-1"></i>
                                                <?php echo e($user->kyc_submitted_at->translatedFormat('d M Y')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">En attente</span>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 text-center py-8">Aucune demande KYC en attente</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Signalements en attente -->
    <?php if(isset($pendingReports) && $pendingReports->count() > 0): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Signalements en attente</h2>
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="text-red-600 hover:text-red-800 text-sm">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="space-y-3">
                <?php $__currentLoopData = $pendingReports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-2">
                                    <h3 class="font-semibold text-gray-800">
                                        <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                            <i class="fas fa-calendar-alt text-blue-600"></i> Événement
                                        <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                            <i class="fas fa-trophy text-purple-600"></i> Concours
                                        <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                            <i class="fas fa-hand-holding-heart text-green-600"></i> Collecte
                                        <?php endif; ?>
                                    </h3>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                        <?php if($report->reason === 'inappropriate_content'): ?> bg-red-100 text-red-800
                                        <?php elseif($report->reason === 'scam'): ?> bg-orange-100 text-orange-800
                                        <?php else: ?> bg-yellow-100 text-yellow-800
                                        <?php endif; ?>">
                                        <?php echo e($report->reason_label); ?>

                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">
                                    <strong>Contenu signalé:</strong> 
                                    <?php if($report->reportable_type === 'App\Models\Event'): ?>
                                        <?php echo e($report->reportable->title ?? 'N/A'); ?>

                                    <?php elseif($report->reportable_type === 'App\Models\Contest'): ?>
                                        <?php echo e($report->reportable->name ?? 'N/A'); ?>

                                    <?php elseif($report->reportable_type === 'App\Models\Fundraising'): ?>
                                        <?php echo e($report->reportable->name ?? 'N/A'); ?>

                                    <?php endif; ?>
                                </p>
                                <p class="text-sm text-gray-700 mb-2">
                                    <strong>Message:</strong> <?php echo e(Str::limit($report->message, 150)); ?>

                                </p>
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-user mr-1"></i>Signalé par <?php echo e($report->reporter->name ?? 'Utilisateur'); ?>

                                    <span class="ml-3">
                                        <i class="fas fa-clock mr-1"></i>
                                        <?php echo e($report->created_at->translatedFormat('d M Y H:i')); ?>

                                    </span>
                                </p>
                            </div>
                            <div class="ml-4 flex gap-2">
                                <a href="<?php echo e(route('admin.reports.show', $report)); ?>" 
                                   class="px-3 py-1 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                                    <i class="fas fa-eye mr-1"></i>Examiner
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Top organisateurs -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Top Organisateurs</h2>
        <?php if($topOrganizers->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Organisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événements</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Transactions</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $topOrganizers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $organizer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900"><?php echo e($organizer->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($organizer->email); ?></div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($organizer->events_count); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($organizer->events_count); ?></td>
                                <td class="px-6 py-4 text-sm">
                                    <a href="<?php echo e(route('admin.users.show', $organizer)); ?>" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-eye"></i> Voir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Aucun organisateur</p>
        <?php endif; ?>
    </div>

    <!-- Transactions récentes -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Transactions récentes</h2>
        <?php if($recentPayments->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Utilisateur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Commission</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $recentPayments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($payment->created_at->translatedFormat('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($payment->user->name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($payment->tickets->count() > 0): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Événement</span>
                                    <?php elseif($payment->votes->count() > 0): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Concours</span>
                                    <?php elseif($payment->donation): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Collecte</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                    <?php echo e(number_format($payment->amount, 0, ',', ' ')); ?> XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e(number_format($payment->platform_commission ?? 0, 0, ',', ' ')); ?> XOF
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($payment->status === 'completed'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                                    <?php elseif($payment->status === 'pending'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Échoué</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Aucune transaction</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique des revenus
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const monthlyData = <?php echo json_encode($monthlyRevenue, 15, 512) ?>;
        const labels = monthlyData.map(item => {
            const [year, month] = item.month.split('-');
            const date = new Date(year, month - 1, 1);
            return date.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
        });
        const data = monthlyData.map(item => parseFloat(item.revenue || 0));

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Revenus (XOF)',
                    data: data,
                    borderColor: 'rgb(239, 68, 68)',
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    tension: 0.4,
                    fill: true,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return new Intl.NumberFormat('fr-FR', {
                                    style: 'currency',
                                    currency: 'XOF',
                                    minimumFractionDigits: 0
                                }).format(context.parsed.y);
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
                        }
                    }
                }
            }
        });
    }

    // Graphique de répartition
    const distributionCtx = document.getElementById('revenueDistributionChart');
    if (distributionCtx) {
        const distributionData = <?php echo json_encode($revenueByType, 15, 512) ?>;
        const labels = ['Événements', 'Concours', 'Collectes'];
        const data = [
            parseFloat(distributionData.events || 0),
            parseFloat(distributionData.contests || 0),
            parseFloat(distributionData.fundraisings || 0),
        ];

        new Chart(distributionCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        'rgb(59, 130, 246)',
                        'rgb(147, 51, 234)',
                        'rgb(34, 197, 94)',
                    ],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 2,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + new Intl.NumberFormat('fr-FR', {
                                    style: 'currency',
                                    currency: 'XOF',
                                    minimumFractionDigits: 0
                                }).format(value) + ' (' + percentage + '%)';
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/admin/index.blade.php ENDPATH**/ ?>