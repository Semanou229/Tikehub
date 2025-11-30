@extends('layouts.dashboard')

@section('title', 'Emails Marketing')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Emails Marketing</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Créez et envoyez des campagnes email ciblées</p>
        </div>
        <a href="{{ route('organizer.crm.campaigns.create') }}" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouvelle campagne</span><span class="sm:hidden">Nouvelle</span>
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total campagnes</div>
            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Envoyées</div>
            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-green-600">{{ $stats['sent'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Brouillons</div>
            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-yellow-600">{{ $stats['draft'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Emails envoyés</div>
            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-blue-600 whitespace-nowrap">{{ number_format($stats['total_sent']) }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Taux d'ouverture</div>
            <div class="text-lg sm:text-xl lg:text-3xl font-bold text-purple-600">
                {{ $stats['total_sent'] > 0 ? round(($stats['total_opened'] / $stats['total_sent']) * 100, 1) : 0 }}%
            </div>
        </div>
    </div>

    <!-- Liste des campagnes -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Campagne</th>
                    <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Segment</th>
                    <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Statut</th>
                    <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden lg:table-cell">Statistiques</th>
                    <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($campaigns as $campaign)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                            <div class="font-semibold text-sm sm:text-base text-gray-900 break-words">{{ $campaign->name }}</div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1 break-words">{{ $campaign->subject }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $campaign->created_at->format('d/m/Y H:i') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500 mt-1 md:hidden">
                                <span class="font-medium">Segment:</span> {{ $campaign->segment->name ?? 'Tous les contacts' }}
                            </div>
                            <div class="text-xs sm:text-sm mt-1 lg:hidden">
                                <div class="mt-1"><span class="font-medium">Envoyés:</span> <strong>{{ $campaign->sent_count }}</strong></div>
                                <div class="mt-1"><span class="font-medium">Ouverts:</span> <strong>{{ $campaign->opened_count }}</strong>
                                    @if($campaign->sent_count > 0)
                                        ({{ round(($campaign->opened_count / $campaign->sent_count) * 100, 1) }}%)
                                    @endif
                                </div>
                                <div class="mt-1"><span class="font-medium">Clics:</span> <strong>{{ $campaign->clicked_count }}</strong></div>
                            </div>
                        </td>
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 hidden md:table-cell">
                            <span class="truncate max-w-[150px] block">{{ $campaign->segment->name ?? 'Tous les contacts' }}</span>
                        </td>
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                            @php
                                $statusLabels = [
                                    'sent' => 'Envoyée',
                                    'draft' => 'Brouillon',
                                    'scheduled' => 'Planifiée',
                                    'sending' => 'En cours'
                                ];
                                $statusLabel = $statusLabels[$campaign->status] ?? ucfirst($campaign->status);
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                                {{ $campaign->status === 'sent' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $campaign->status === 'draft' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $campaign->status === 'scheduled' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $campaign->status === 'sending' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ $statusLabel }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-xs sm:text-sm hidden lg:table-cell">
                            <div>Envoyés: <strong>{{ $campaign->sent_count }}</strong></div>
                            <div>Ouverts: <strong>{{ $campaign->opened_count }}</strong> 
                                @if($campaign->sent_count > 0)
                                    ({{ round(($campaign->opened_count / $campaign->sent_count) * 100, 1) }}%)
                                @endif
                            </div>
                            <div>Clics: <strong>{{ $campaign->clicked_count }}</strong></div>
                        </td>
                        <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                            <div class="flex items-center gap-1.5 sm:gap-2">
                                <a href="{{ route('organizer.crm.campaigns.show', $campaign) }}" class="text-indigo-600 hover:text-indigo-900 active:text-indigo-700 min-w-[32px] min-h-[32px] sm:min-w-[36px] sm:min-h-[36px] flex items-center justify-center" title="Voir">
                                    <i class="fas fa-eye text-xs sm:text-sm"></i>
                                </a>
                                @if($campaign->status === 'draft')
                                    <a href="{{ route('organizer.crm.campaigns.edit', $campaign) }}" class="text-gray-600 hover:text-gray-900 active:text-gray-700 min-w-[32px] min-h-[32px] sm:min-w-[36px] sm:min-h-[36px] flex items-center justify-center" title="Modifier">
                                        <i class="fas fa-edit text-xs sm:text-sm"></i>
                                    </a>
                                    <form action="{{ route('organizer.crm.campaigns.send', $campaign) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 active:text-green-700 min-w-[32px] min-h-[32px] sm:min-w-[36px] sm:min-h-[36px] flex items-center justify-center" title="Envoyer" onclick="return confirm('Êtes-vous sûr de vouloir envoyer cette campagne ?')">
                                            <i class="fas fa-paper-plane text-xs sm:text-sm"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-3 sm:px-6 py-8 sm:py-12 text-center text-gray-500">
                            <i class="fas fa-envelope text-3xl sm:text-4xl mb-3 text-gray-300"></i>
                            <p class="text-sm sm:text-base">Aucune campagne trouvée</p>
                            <a href="{{ route('organizer.crm.campaigns.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block text-sm sm:text-base">
                                Créer votre première campagne
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    @if($campaigns->hasPages())
        <div class="mt-4 sm:mt-6 overflow-x-auto">
            <div class="min-w-fit">
                {{ $campaigns->links() }}
            </div>
        </div>
    @endif
</div>
@endsection


