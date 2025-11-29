@extends('layouts.dashboard')

@section('title', 'Scans - ' . $event->title)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Scans de Billets</h1>
            <p class="text-gray-600 mt-1">{{ $event->title }}</p>
        </div>
        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Scans valides</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['total_scans'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Tentatives invalides</div>
            <div class="text-3xl font-bold text-red-600">{{ $stats['invalid_scans'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Billets scannés</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['unique_tickets'] }} / {{ $stats['total_tickets'] }}</div>
            <div class="text-xs text-gray-500 mt-1">{{ $stats['unscanned_tickets'] }} non scannés</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Taux de scan</div>
            <div class="text-3xl font-bold text-purple-600">
                {{ $stats['total_tickets'] > 0 ? number_format(($stats['unique_tickets'] / $stats['total_tickets']) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Scanner -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Scanner un billet</h2>
        
        <!-- Options de scan -->
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
            <div class="mt-4 flex gap-4">
                <button id="stopCameraBtn" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition hidden">
                    <i class="fas fa-stop mr-2"></i>Arrêter la caméra
                </button>
            </div>
        </div>

        <!-- Saisie manuelle -->
        <div id="manualSection" class="mb-4">
            <form id="scanForm" class="flex gap-4">
                @csrf
                <input type="text" id="qrToken" placeholder="Collez le token QR code ici" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 font-mono text-sm">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-qrcode mr-2"></i>Valider
                </button>
            </form>
        </div>

        <!-- Résultat du scan -->
        <div id="scanResult" class="mt-4"></div>
    </div>

    <!-- Historique des scans -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-800">Historique des scans</h2>
            <div class="flex gap-2">
                <button onclick="filterScans('all')" class="px-3 py-1 text-sm rounded-lg bg-indigo-100 text-indigo-700 hover:bg-indigo-200">Tous</button>
                <button onclick="filterScans('valid')" class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Valides</button>
                <button onclick="filterScans('invalid')" class="px-3 py-1 text-sm rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">Invalides</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Billet</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acheteur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scanné par</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="scansTableBody">
                    @foreach($scans as $scan)
                        <tr class="hover:bg-gray-50 scan-row" data-status="{{ $scan->is_valid ? 'valid' : 'invalid' }}">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-900">
                                #{{ $scan->ticket->code ?? $scan->ticket->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $scan->ticket->buyer->name ?? $scan->ticket->buyer_name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $scan->ticket->ticketType->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $scan->scanner->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $scan->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono text-xs">
                                {{ $scan->ip_address ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($scan->is_valid)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-circle mr-1"></i>Valide
                                    </span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Invalide
                                    </span>
                                    @if($scan->notes)
                                        <div class="text-xs text-red-600 mt-1">{{ Str::limit($scan->notes, 30) }}</div>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($scans->hasPages())
            <div class="p-4 border-t border-gray-200">
                {{ $scans->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrcodeScanner = null;
let currentFilter = 'all';

// Toggle entre caméra et saisie manuelle
document.getElementById('cameraBtn').addEventListener('click', function() {
    document.getElementById('cameraSection').classList.remove('hidden');
    document.getElementById('manualSection').classList.add('hidden');
    document.getElementById('cameraBtn').classList.add('bg-indigo-600', 'text-white');
    document.getElementById('cameraBtn').classList.remove('bg-gray-200', 'text-gray-700');
    document.getElementById('manualBtn').classList.remove('bg-indigo-600', 'text-white');
    document.getElementById('manualBtn').classList.add('bg-gray-200', 'text-gray-700');
    startCamera();
});

document.getElementById('manualBtn').addEventListener('click', function() {
    document.getElementById('cameraSection').classList.add('hidden');
    document.getElementById('manualSection').classList.remove('hidden');
    document.getElementById('manualBtn').classList.add('bg-indigo-600', 'text-white');
    document.getElementById('manualBtn').classList.remove('bg-gray-200', 'text-gray-700');
    document.getElementById('cameraBtn').classList.remove('bg-indigo-600', 'text-white');
    document.getElementById('cameraBtn').classList.add('bg-gray-200', 'text-gray-700');
    stopCamera();
});

// Démarrer la caméra
function startCamera() {
    const video = document.getElementById('video');
    const placeholder = document.getElementById('cameraPlaceholder');
    const stopBtn = document.getElementById('stopCameraBtn');
    
    if (html5QrcodeScanner) {
        return;
    }

    html5QrcodeScanner = new Html5Qrcode("video");
    
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
            // Erreur ignorée silencieusement
        }
    ).then(() => {
        placeholder.style.display = 'none';
        video.style.display = 'block';
        stopBtn.classList.remove('hidden');
    }).catch((err) => {
        console.error("Erreur caméra:", err);
        showResult('error', 'Impossible d\'accéder à la caméra. Utilisez la saisie manuelle.');
    });
}

// Arrêter la caméra
document.getElementById('stopCameraBtn').addEventListener('click', stopCamera);

function stopCamera() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.stop().then(() => {
            html5QrcodeScanner = null;
            document.getElementById('video').style.display = 'none';
            document.getElementById('cameraPlaceholder').style.display = 'flex';
            document.getElementById('stopCameraBtn').classList.add('hidden');
        }).catch((err) => {
            console.error("Erreur arrêt caméra:", err);
        });
    }
}

// Gestion du scan
async function handleScan(qrToken) {
    if (!qrToken) return;
    
    stopCamera();
    
    const resultDiv = document.getElementById('scanResult');
    resultDiv.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-indigo-600"></i><p class="mt-2">Validation en cours...</p></div>';
    
    try {
        const response = await fetch('{{ route('organizer.scans.scan', $event) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_token: qrToken })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showResult('success', data.message, data.ticket, data.scan);
            setTimeout(() => location.reload(), 2000);
        } else {
            showResult('error', data.message, data.ticket, null, data.fraud_detected);
        }
    } catch (error) {
        showResult('error', 'Erreur lors du scan. Veuillez réessayer.');
    }
}

// Afficher le résultat
function showResult(type, message, ticket = null, scan = null, fraudDetected = false) {
    const resultDiv = document.getElementById('scanResult');
    let html = '';
    
    if (type === 'success') {
        html = `
            <div class="bg-green-100 border-2 border-green-400 text-green-800 px-6 py-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-check-circle text-2xl mr-3"></i>
                    <div>
                        <h3 class="font-bold text-lg">${message}</h3>
                    </div>
                </div>
                ${ticket ? `
                    <div class="bg-white rounded p-3 mt-3">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><strong>Code:</strong> #${ticket.code}</div>
                            <div><strong>Type:</strong> ${ticket.type}</div>
                            <div><strong>Acheteur:</strong> ${ticket.buyer}</div>
                            <div><strong>Prix:</strong> ${ticket.price} XOF</div>
                        </div>
                        ${scan ? `<div class="mt-2 text-xs text-gray-600">Scanné le ${scan.scanned_at}</div>` : ''}
                    </div>
                ` : ''}
            </div>
        `;
    } else {
        html = `
            <div class="bg-red-100 border-2 border-red-400 text-red-800 px-6 py-4 rounded-lg">
                <div class="flex items-center mb-3">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3"></i>
                    <div>
                        <h3 class="font-bold text-lg">${message}</h3>
                        ${fraudDetected ? '<p class="text-sm mt-1 font-semibold">⚠️ Tentative de fraude détectée</p>' : ''}
                    </div>
                </div>
                ${ticket ? `
                    <div class="bg-white rounded p-3 mt-3">
                        <div class="text-sm">
                            <div><strong>Billet:</strong> #${ticket.code || ticket.id}</div>
                            ${ticket.scanned_at ? `<div class="mt-1 text-xs text-gray-600">Déjà scanné le ${ticket.scanned_at} par ${ticket.scanned_by || 'N/A'}</div>` : ''}
                        </div>
                    </div>
                ` : ''}
            </div>
        `;
    }
    
    resultDiv.innerHTML = html;
}

// Formulaire de saisie manuelle
document.getElementById('scanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const qrToken = document.getElementById('qrToken').value.trim();
    if (!qrToken) {
        showResult('error', 'Veuillez entrer un token QR code.');
        return;
    }
    await handleScan(qrToken);
    document.getElementById('qrToken').value = '';
});

// Filtrage des scans
function filterScans(status) {
    currentFilter = status;
    const rows = document.querySelectorAll('.scan-row');
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Mettre à jour les boutons
    document.querySelectorAll('[onclick^="filterScans"]').forEach(btn => {
        btn.classList.remove('bg-indigo-100', 'text-indigo-700');
        btn.classList.add('bg-gray-100', 'text-gray-700');
    });
    event.target.classList.remove('bg-gray-100', 'text-gray-700');
    event.target.classList.add('bg-indigo-100', 'text-indigo-700');
}
</script>
@endpush
@endsection

