

<?php $__env->startSection('title', 'Scans - ' . $event->title); ?>

<?php $__env->startSection('content'); ?>
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Scans de Billets</h1>
            <p class="text-gray-600 mt-1"><?php echo e($event->title); ?></p>
        </div>
        <a href="<?php echo e(route('collaborator.events.show', $event)); ?>" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Mes scans valides</div>
            <div class="text-3xl font-bold text-green-600"><?php echo e($stats['my_valid_scans']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Tentatives invalides</div>
            <div class="text-3xl font-bold text-red-600"><?php echo e($stats['my_invalid_scans']); ?></div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total billets</div>
            <div class="text-3xl font-bold text-indigo-600"><?php echo e($stats['total_tickets']); ?></div>
        </div>
    </div>

    <!-- Scanner -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Scanner un billet</h2>
        
        <div class="mb-4 flex gap-4">
            <button id="cameraBtn" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-camera mr-2"></i>Utiliser la caméra
            </button>
            <button id="manualBtn" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                <i class="fas fa-keyboard mr-2"></i>Saisie manuelle
            </button>
        </div>

        <!-- Zone caméra -->
        <div id="cameraSection" class="hidden mb-4">
            <div class="relative">
                <video id="video" width="100%" height="400" class="rounded-lg bg-gray-900" style="display: none;"></video>
                <canvas id="canvas" class="hidden"></canvas>
                <div id="cameraPlaceholder" class="w-full h-96 bg-gray-900 rounded-lg flex items-center justify-center text-white">
                    <div class="text-center">
                        <i class="fas fa-camera text-4xl mb-4"></i>
                        <p>Cliquez sur "Utiliser la caméra" pour démarrer</p>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <button id="stopCameraBtn" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition hidden">
                    <i class="fas fa-stop mr-2"></i>Arrêter la caméra
                </button>
            </div>
        </div>

        <!-- Saisie manuelle -->
        <div id="manualSection" class="mb-4">
            <form id="scanForm" class="flex gap-4">
                <?php echo csrf_field(); ?>
                <input type="text" id="codeInput" placeholder="Entrez le code du billet (ex: ABC123XYZ456)" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm uppercase" style="text-transform: uppercase;">
                <input type="text" id="qrTokenInput" placeholder="Collez le token QR code ici" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm hidden">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-check mr-2"></i>Valider
                </button>
            </form>
            <p class="text-xs text-gray-500 mt-2">
                <i class="fas fa-info-circle mr-1"></i>
                Entrez le code unique du billet (12 caractères alphanumériques)
            </p>
        </div>

        <!-- Résultat du scan -->
        <div id="scanResult" class="mt-4"></div>
    </div>

    <!-- Historique des scans -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Historique de mes scans</h2>
        <?php if($scans->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code billet</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acheteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $scans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $scan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo e($scan->created_at->translatedFormat('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                    <?php echo e($scan->ticket->code ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    <?php echo e($scan->ticket->buyer->name ?? $scan->ticket->buyer_name ?? 'N/A'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($scan->is_valid): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Valide</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Invalide</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <?php echo e($scans->links()); ?>

            </div>
        <?php else: ?>
            <p class="text-gray-500 text-center py-8">Aucun scan effectué pour le moment</p>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let html5QrcodeScanner = null;
let currentInputMode = 'code';

document.getElementById('cameraBtn').addEventListener('click', function() {
    document.getElementById('cameraSection').classList.remove('hidden');
    document.getElementById('manualSection').classList.add('hidden');
    startCamera();
});

document.getElementById('manualBtn').addEventListener('click', function() {
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('manualSection').classList.remove('hidden');
    stopCamera();
});

function startCamera() {
    const video = document.getElementById('video');
    const placeholder = document.getElementById('cameraPlaceholder');
    const stopBtn = document.getElementById('stopCameraBtn');
    
    html5QrcodeScanner = new Html5Qrcode("cameraPlaceholder");
    
    html5QrcodeScanner.start(
        { facingMode: "environment" },
        {
            fps: 10,
            qrbox: { width: 250, height: 250 }
        },
        (decodedText, decodedResult) => {
            handleScan(decodedText);
        },
        (errorMessage) => {
            // Ignore les erreurs de scan continu
        }
    ).catch((err) => {
        console.error("Erreur caméra:", err);
        alert("Impossible d'accéder à la caméra. Veuillez vérifier les permissions.");
    });
    
    stopBtn.classList.remove('hidden');
}

function stopCamera() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
            html5QrcodeScanner.clear();
        }).catch((err) => {
            console.error("Erreur arrêt caméra:", err);
        });
    }
    document.getElementById('stopCameraBtn').classList.add('hidden');
}

document.getElementById('stopCameraBtn').addEventListener('click', stopCamera);

document.getElementById('scanForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const code = document.getElementById('codeInput').value.trim();
    const token = document.getElementById('qrTokenInput').value.trim();
    
    if (code) {
        handleScan(null, code);
    } else if (token) {
        handleScan(token);
    }
});

function handleScan(qrToken, code = null) {
    const formData = new FormData();
    if (qrToken) {
        formData.append('qr_token', qrToken);
    }
    if (code) {
        formData.append('code', code);
    }
    formData.append('_token', '<?php echo e(csrf_token()); ?>');

    fetch('<?php echo e(route("collaborator.scans.scan", $event)); ?>', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        showScanResult(data);
        if (data.success) {
            document.getElementById('codeInput').value = '';
            document.getElementById('qrTokenInput').value = '';
            setTimeout(() => location.reload(), 2000);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showScanResult({ success: false, message: 'Une erreur est survenue.' });
    });
}

function showScanResult(data) {
    const resultDiv = document.getElementById('scanResult');
    const bgColor = data.success ? 'bg-green-100 border-green-400 text-green-700' : 'bg-red-100 border-red-400 text-red-700';
    
    resultDiv.innerHTML = `
        <div class="${bgColor} border px-4 py-3 rounded">
            <p class="font-semibold">${data.message}</p>
            ${data.ticket ? `
                <div class="mt-2 text-sm">
                    <p><strong>Code:</strong> ${data.ticket.code}</p>
                    <p><strong>Acheteur:</strong> ${data.ticket.buyer || 'N/A'}</p>
                </div>
            ` : ''}
        </div>
    `;
    
    setTimeout(() => {
        resultDiv.innerHTML = '';
    }, 5000);
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.collaborator', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\adoun\Music\Tikehub\resources\views/dashboard/collaborator/scans/index.blade.php ENDPATH**/ ?>