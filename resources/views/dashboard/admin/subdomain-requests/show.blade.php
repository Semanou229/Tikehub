@extends('layouts.admin')

@section('title', 'Détails de la Demande')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.subdomain-requests.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la Demande</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de la demande</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Organisateur</label>
                        <p class="text-gray-900 font-medium">{{ $subdomainRequest->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $subdomainRequest->user->email }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Type de contenu</label>
                        <div class="flex items-center">
                            @if($subdomainRequest->content_type === 'event')
                                <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                                <span class="text-gray-900 font-medium">Événement</span>
                            @elseif($subdomainRequest->content_type === 'contest')
                                <i class="fas fa-trophy text-purple-600 mr-2"></i>
                                <span class="text-gray-900 font-medium">Concours</span>
                            @elseif($subdomainRequest->content_type === 'fundraising')
                                <i class="fas fa-heart text-green-600 mr-2"></i>
                                <span class="text-gray-900 font-medium">Collecte de fonds</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Contenu</label>
                        <p class="text-gray-900 font-medium">{{ $subdomainRequest->content_title ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Sous-domaine demandé</label>
                        <p class="text-gray-900 font-mono">{{ $subdomainRequest->requested_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</p>
                    </div>

                    @if($subdomainRequest->actual_subdomain)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Sous-domaine réel</label>
                            <p class="text-green-600 font-mono font-semibold">{{ $subdomainRequest->actual_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}</p>
                        </div>
                    @endif

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Statut</label>
                        @if($subdomainRequest->status === 'pending')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <i class="fas fa-clock mr-1"></i>En attente
                            </span>
                        @elseif($subdomainRequest->status === 'approved')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                <i class="fas fa-check-circle mr-1"></i>Approuvé
                            </span>
                        @elseif($subdomainRequest->status === 'completed')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                <i class="fas fa-check-double mr-1"></i>Complété
                            </span>
                        @elseif($subdomainRequest->status === 'rejected')
                            <span class="px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Rejeté
                            </span>
                        @endif
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date de demande</label>
                        <p class="text-gray-900">{{ $subdomainRequest->created_at->format('d/m/Y à H:i') }}</p>
                    </div>

                    @if($subdomainRequest->approved_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date d'approbation</label>
                            <p class="text-gray-900">{{ $subdomainRequest->approved_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif

                    @if($subdomainRequest->completed_at)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Date de complétion</label>
                            <p class="text-gray-900">{{ $subdomainRequest->completed_at->format('d/m/Y à H:i') }}</p>
                        </div>
                    @endif

                    @if($subdomainRequest->approver)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Approuvé par</label>
                            <p class="text-gray-900">{{ $subdomainRequest->approver->name }}</p>
                        </div>
                    @endif
                </div>

                @if($subdomainRequest->reason)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Raison de la demande</label>
                        <p class="text-gray-900">{{ $subdomainRequest->reason }}</p>
                    </div>
                @endif

                @if($subdomainRequest->admin_notes)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <label class="block text-sm font-medium text-gray-500 mb-2">Notes de l'administrateur</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $subdomainRequest->admin_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Actions</h2>

                @if($subdomainRequest->status === 'pending')
                    <!-- Approuver -->
                    <form action="{{ route('admin.subdomain-requests.approve', $subdomainRequest) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                            <textarea name="admin_notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ajoutez des notes pour cette approbation..."></textarea>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            <i class="fas fa-check-circle mr-2"></i>Approuver
                        </button>
                    </form>

                    <!-- Rejeter -->
                    <form action="{{ route('admin.subdomain-requests.reject', $subdomainRequest) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Raison du rejet *</label>
                            <textarea name="admin_notes" rows="3" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Expliquez pourquoi cette demande est rejetée..." required></textarea>
                        </div>
                        <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-times-circle mr-2"></i>Rejeter
                        </button>
                    </form>
                @elseif($subdomainRequest->status === 'approved')
                    <!-- Compléter (après création sur cPanel) -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-4 rounded">
                        <p class="text-blue-800 text-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Étape suivante :</strong> Créez le sous-domaine sur cPanel, puis complétez la demande ci-dessous.
                        </p>
                    </div>

                    <form action="{{ route('admin.subdomain-requests.complete', $subdomainRequest) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sous-domaine créé sur cPanel *</label>
                            <div class="flex items-center">
                                <input type="text" name="actual_subdomain" 
                                    value="{{ old('actual_subdomain', $subdomainRequest->actual_subdomain) }}"
                                    class="flex-1 rounded-l-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="mon-evenement" 
                                    pattern="[a-z0-9-]+" 
                                    minlength="3" 
                                    maxlength="50"
                                    required>
                                <span class="px-3 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-lg text-gray-600 text-sm">
                                    .{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">
                                Entrez le sous-domaine exact créé sur cPanel
                            </p>
                        </div>
                        <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            <i class="fas fa-check-double mr-2"></i>Compléter la demande
                        </button>
                    </form>
                @elseif($subdomainRequest->status === 'completed')
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <p class="text-green-800">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Demande complétée</strong>
                        </p>
                        <p class="text-sm text-green-700 mt-2">
                            Le sous-domaine est actif : 
                            <a href="http://{{ $subdomainRequest->actual_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}" 
                               target="_blank" 
                               class="underline font-semibold">
                                {{ $subdomainRequest->actual_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                            </a>
                        </p>
                    </div>
                @elseif($subdomainRequest->status === 'rejected')
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-red-800">
                            <i class="fas fa-times-circle mr-2"></i>
                            <strong>Demande rejetée</strong>
                        </p>
                        @if($subdomainRequest->admin_notes)
                            <p class="text-sm text-red-700 mt-2">{{ $subdomainRequest->admin_notes }}</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const subdomainInput = document.querySelector('input[name="actual_subdomain"]');
    if (subdomainInput) {
        subdomainInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
        });
    }
});
</script>
@endsection


