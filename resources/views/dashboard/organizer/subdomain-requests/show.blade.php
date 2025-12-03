@extends('layouts.dashboard')

@section('title', 'Détails de la Demande')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('organizer.subdomain-requests.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-4">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Détails de la Demande</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

        @if($subdomainRequest->isCompleted() && $subdomainRequest->actual_subdomain)
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-green-800">
                        <i class="fas fa-check-circle mr-2"></i>
                        <strong>Votre sous-domaine est actif !</strong> Vous pouvez y accéder à l'adresse : 
                        <a href="http://{{ $subdomainRequest->actual_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}" 
                           target="_blank" 
                           class="text-green-600 underline font-semibold">
                            {{ $subdomainRequest->actual_subdomain }}.{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                        </a>
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection


