<?php $__env->startSection('title', 'Mon Portefeuille'); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mon Portefeuille</h1>
        <p class="text-gray-600 mt-2">Gérez vos revenus et transactions</p>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-green-100 text-sm mb-1">Revenus totaux</p>
                    <p class="text-3xl font-bold"><?php echo e(number_format($totalEarnings, 0, ',', ' ')); ?> XOF</p>
                </div>
                <i class="fas fa-wallet text-4xl text-green-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-blue-100 text-sm mb-1">Revenus nets</p>
                    <p class="text-3xl font-bold"><?php echo e(number_format($netEarnings, 0, ',', ' ')); ?> XOF</p>
                </div>
                <i class="fas fa-money-bill-wave text-4xl text-blue-200"></i>
            </div>
        </div>

        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-purple-100 text-sm mb-1">Commission plateforme</p>
                    <p class="text-3xl font-bold"><?php echo e(number_format($platformCommission, 0, ',', ' ')); ?> XOF</p>
                </div>
                <i class="fas fa-percentage text-4xl text-purple-200"></i>
            </div>
        </div>
    </div>

    <!-- Statistiques par type -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Événements</p>
                    <p class="text-2xl font-bold text-indigo-600"><?php echo e(number_format($statsByType['events']['total'], 0, ',', ' ')); ?> XOF</p>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($statsByType['events']['count']); ?> billets vendus</p>
                </div>
                <i class="fas fa-calendar-alt text-3xl text-indigo-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Concours</p>
                    <p class="text-2xl font-bold text-purple-600"><?php echo e(number_format($statsByType['contests']['total'], 0, ',', ' ')); ?> XOF</p>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($statsByType['contests']['count']); ?> votes</p>
                </div>
                <i class="fas fa-trophy text-3xl text-purple-400"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-gray-600 text-sm mb-1">Collectes</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($statsByType['fundraisings']['total'], 0, ',', ' ')); ?> XOF</p>
                    <p class="text-sm text-gray-500 mt-1"><?php echo e($statsByType['fundraisings']['count']); ?> dons</p>
                </div>
                <i class="fas fa-heart text-3xl text-green-400"></i>
            </div>
        </div>
    </div>

    <!-- Graphique des revenus -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Revenus des 6 derniers mois</h2>
        <canvas id="revenueChart" height="100"></canvas>
    </div>

    <!-- Demande de retrait -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Demander un retrait</h2>
        <?php if(auth()->user()->isKycVerified()): ?>
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <p class="text-green-800">Votre compte KYC est vérifié. Vous pouvez demander un retrait.</p>
                </div>
            </div>
            <form action="<?php echo e(route('organizer.wallet.withdraw')); ?>" method="POST" class="space-y-4" id="withdrawalForm">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant à retirer (XOF) *</label>
                    <input type="number" name="amount" id="amount" min="1000" max="<?php echo e($netEarnings); ?>" step="100" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <p class="text-sm text-gray-500 mt-1">Montant disponible: <?php echo e(number_format($netEarnings, 0, ',', ' ')); ?> XOF</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Méthode de paiement *</label>
                    <select name="payment_method" id="payment_method" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" onchange="togglePaymentFields()">
                        <option value="">Sélectionner une méthode</option>
                        <option value="mobile_money">Mobile Money</option>
                        <option value="bank_transfer">Virement bancaire</option>
                        <option value="crypto">Crypto-monnaie</option>
                    </select>
                </div>

                <!-- Mobile Money Fields -->
                <div id="mobile_money_fields" style="display: none;" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Réseau *</label>
                        <select name="mobile_network" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un réseau</option>
                            <option value="MTN">MTN</option>
                            <option value="Moov">Moov</option>
                            <option value="Orange">Orange</option>
                            <option value="Wave">Wave</option>
                            <option value="M-Pesa">M-Pesa</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Indicatif du pays *</label>
                        <input type="text" name="country_code" placeholder="+229" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de téléphone *</label>
                        <input type="text" name="phone_number" placeholder="90 00 00 00" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Bank Transfer Fields -->
                <div id="bank_transfer_fields" style="display: none;" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la banque *</label>
                        <input type="text" name="bank_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Numéro de compte *</label>
                        <input type="text" name="account_number" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nom du titulaire *</label>
                        <input type="text" name="account_holder_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">IBAN (optionnel)</label>
                        <input type="text" name="iban" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Code SWIFT (optionnel)</label>
                        <input type="text" name="swift_code" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <!-- Crypto Fields -->
                <div id="crypto_fields" style="display: none;" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Crypto-monnaie *</label>
                        <select name="crypto_currency" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner une crypto-monnaie</option>
                            <option value="BTC">Bitcoin (BTC)</option>
                            <option value="ETH">Ethereum (ETH)</option>
                            <option value="USDT">Tether (USDT)</option>
                            <option value="USDC">USD Coin (USDC)</option>
                            <option value="BNB">Binance Coin (BNB)</option>
                            <option value="XRP">Ripple (XRP)</option>
                            <option value="ADA">Cardano (ADA)</option>
                            <option value="DOGE">Dogecoin (DOGE)</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Adresse du portefeuille *</label>
                        <input type="text" name="crypto_wallet_address" placeholder="0x..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Réseau blockchain (optionnel)</label>
                        <select name="crypto_network" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un réseau</option>
                            <option value="ERC20">ERC20 (Ethereum)</option>
                            <option value="TRC20">TRC20 (Tron)</option>
                            <option value="BEP20">BEP20 (Binance Smart Chain)</option>
                            <option value="BTC">Bitcoin Network</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-money-bill-wave mr-2"></i>Demander le retrait
                </button>
            </form>
            
            <script>
                function togglePaymentFields() {
                    const method = document.getElementById('payment_method').value;
                    
                    // Masquer tous les champs
                    document.getElementById('mobile_money_fields').style.display = 'none';
                    document.getElementById('bank_transfer_fields').style.display = 'none';
                    document.getElementById('crypto_fields').style.display = 'none';
                    
                    // Afficher les champs correspondants
                    if (method === 'mobile_money') {
                        document.getElementById('mobile_money_fields').style.display = 'block';
                    } else if (method === 'bank_transfer') {
                        document.getElementById('bank_transfer_fields').style.display = 'block';
                    } else if (method === 'crypto') {
                        document.getElementById('crypto_fields').style.display = 'block';
                    }
                }
            </script>
        <?php else: ?>
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-4">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-yellow-600 mr-3 mt-1"></i>
                    <div>
                        <p class="text-yellow-800 font-semibold mb-2">Vérification KYC requise</p>
                        <p class="text-yellow-700 text-sm mb-3">Vous devez compléter la vérification KYC avant de pouvoir demander un retrait de fonds.</p>
                        <a href="<?php echo e(route('organizer.profile.kyc')); ?>" class="inline-block bg-yellow-600 text-white px-4 py-2 rounded-lg hover:bg-yellow-700 transition text-sm font-semibold">
                            <i class="fas fa-id-card mr-2"></i>Compléter la vérification KYC
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Demandes de retrait -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Mes demandes de retrait</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Méthode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $withdrawals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($withdrawal->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <?php echo e(number_format($withdrawal->amount, 0, ',', ' ')); ?> XOF
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if($withdrawal->payment_method === 'mobile_money'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <?php echo e($withdrawal->mobile_network ?? 'Mobile Money'); ?>

                                    </span>
                                <?php elseif($withdrawal->payment_method === 'bank_transfer'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <?php echo e($withdrawal->bank_name ?? 'Virement bancaire'); ?>

                                    </span>
                                <?php elseif($withdrawal->payment_method === 'crypto'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?php echo e($withdrawal->crypto_currency ?? 'Crypto'); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($withdrawal->status === 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                <?php elseif($withdrawal->status === 'approved'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Approuvé</span>
                                <?php elseif($withdrawal->status === 'completed'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                                <?php elseif($withdrawal->status === 'rejected'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rejeté</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Annulé</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <?php if($withdrawal->rejection_reason): ?>
                                    <button onclick="alert('<?php echo e(addslashes($withdrawal->rejection_reason)); ?>')" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucune demande de retrait pour le moment
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="p-4">
            <?php echo e($withdrawals->links()); ?>

        </div>
    </div>

    <!-- Transactions récentes -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Transactions récentes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Montant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($transaction->created_at->format('d/m/Y H:i')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($transaction->tickets->count() > 0): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">Événement</span>
                                <?php elseif($transaction->votes->count() > 0): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">Concours</span>
                                <?php elseif($transaction->donation): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Collecte</span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                <?php if($transaction->tickets->count() > 0): ?>
                                    Billet: <?php echo e($transaction->tickets->first()->event->title ?? 'N/A'); ?>

                                <?php elseif($transaction->votes->count() > 0): ?>
                                    Vote: <?php echo e($transaction->votes->first()->contest->name ?? 'N/A'); ?>

                                <?php elseif($transaction->donation): ?>
                                    Don: <?php echo e($transaction->donation->fundraising->name ?? 'N/A'); ?>

                                <?php else: ?>
                                    Transaction #<?php echo e($transaction->id); ?>

                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                <?php echo e(number_format($transaction->amount, 0, ',', ' ')); ?> XOF
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if($transaction->status === 'completed'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Complété</span>
                                <?php elseif($transaction->status === 'pending'): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">En attente</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Échoué</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                Aucune transaction pour le moment
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if($recentTransactions->hasPages()): ?>
            <div class="p-4 border-t border-gray-200">
                <?php echo e($recentTransactions->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart');
    if (!ctx) return;
    
    const monthlyData = <?php echo json_encode($monthlyRevenue, 15, 512) ?>;
    
    // Formater les labels en français
    const labels = monthlyData.map(item => {
        const [year, month] = item.month.split('-');
        const date = new Date(year, month - 1, 1);
        return date.toLocaleDateString('fr-FR', { month: 'short', year: 'numeric' });
    });
    
    // Extraire les données
    const data = monthlyData.map(item => parseFloat(item.total || 0));

    // Créer le graphique
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Revenus (XOF)',
                data: data,
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
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/organizer/wallet/index.blade.php ENDPATH**/ ?>