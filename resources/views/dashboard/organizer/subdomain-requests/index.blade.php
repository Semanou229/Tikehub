@extends('layouts.dashboard')

@section('title', 'Demandes de Sous-domaines')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Demandes de Sous-domaines</h1>
            <p class="text-gray-600 mt-2">Gérez vos demandes de sous-domaines personnalisés pour vos événements, concours et collectes</p>
        </div>
        <a href="{{ route('organizer.subdomain-requests.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition flex items-center">
            <i class="fas fa-plus mr-2"></i>Nouvelle Demande
        </a>
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

    @if($requests->isEmpty())
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i class="fas fa-globe text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Aucune demande de sous-domaine</h3>
            <p class="text-gray-500 mb-6">Créez un sous-domaine personnalisé pour votre événement, concours ou collecte</p>
            <a href="{{ route('organizer.subdomain-requests.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer une demande
            </a>
        </div>
    @else
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contenu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-domaine demandé</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($requests as $request)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($request->content_type === 'event')
                                        <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                                    @elseif($request->content_type === 'contest')
                                        <i class="fas fa-trophy text-purple-600 mr-2"></i>
                                    @elseif($request->content_type === 'fundraising')
                                        <i class="fas fa-heart text-green-600 mr-2"></i>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $request->content_title ?? 'N/A' }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($request->content_type === 'event')
                                                Événement
                                            @elseif($request->content_type === 'contest')
                                                Concours
                                            @elseif($request->content_type === 'fundraising')
                                                Collecte
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-mono text-gray-900">{{ $request->requested_subdomain }}</div>
                                @if($request->actual_subdomain)
                                    <div class="text-xs text-gray-500">Réel: {{ $request->actual_subdomain }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($request->status === 'pending')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <i class="fas fa-clock mr-1"></i>En attente
                                    </span>
                                @elseif($request->status === 'approved')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        <i class="fas fa-check-circle mr-1"></i>Approuvé
                                    </span>
                                @elseif($request->status === 'completed')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        <i class="fas fa-check-double mr-1"></i>Complété
                                    </span>
                                @elseif($request->status === 'rejected')
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        <i class="fas fa-times-circle mr-1"></i>Rejeté
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $request->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('organizer.subdomain-requests.show', $request) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye mr-1"></i>Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $requests->links() }}
        </div>
    @endif
</div>
@endsection


