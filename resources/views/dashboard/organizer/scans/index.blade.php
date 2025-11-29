@extends('layouts.dashboard')

@section('title', 'Scans - ' . $event->title)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Scans de Billets</h1>
            <p class="text-gray-600 mt-1">{{ $event->title }}</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total scans</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total_scans'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Billets uniques scannés</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['unique_tickets'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total billets vendus</div>
            <div class="text-3xl font-bold text-purple-600">{{ $stats['total_tickets'] }}</div>
        </div>
    </div>

    <!-- Scanner -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Scanner un billet</h2>
        <form id="scanForm" class="flex gap-4">
            @csrf
            <input type="text" id="qrCode" placeholder="Entrez ou scannez le QR code" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-qrcode mr-2"></i>Scanner
            </button>
        </form>
        <div id="scanResult" class="mt-4"></div>
    </div>

    <!-- Historique des scans -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-800">Historique des scans</h2>
        </div>
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Billet</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acheteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Scanné par</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($scans as $scan)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">#{{ $scan->ticket->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $scan->ticket->buyer->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $scan->scanner->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $scan->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($scan->is_valid)
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Valide</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Invalide</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $scans->links() }}
    </div>
</div>

@push('scripts')
<script>
document.getElementById('scanForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const qrCode = document.getElementById('qrCode').value;
    const resultDiv = document.getElementById('scanResult');
    
    resultDiv.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-indigo-600"></i></div>';
    
    try {
        const response = await fetch('{{ route('organizer.scans.scan', $event) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ qr_code: qrCode })
        });
        
        const data = await response.json();
        
        if (data.success) {
            resultDiv.innerHTML = `
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <i class="fas fa-check-circle mr-2"></i>${data.message}
                    <div class="mt-2 text-sm">
                        <strong>Billet:</strong> #${data.ticket.id} - ${data.ticket.buyer}
                    </div>
                </div>
            `;
            document.getElementById('qrCode').value = '';
            setTimeout(() => location.reload(), 2000);
        } else {
            resultDiv.innerHTML = `
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <i class="fas fa-exclamation-circle mr-2"></i>${data.message}
                </div>
            `;
        }
    } catch (error) {
        resultDiv.innerHTML = `
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <i class="fas fa-exclamation-circle mr-2"></i>Erreur lors du scan
            </div>
        `;
    }
});
</script>
@endpush
@endsection

