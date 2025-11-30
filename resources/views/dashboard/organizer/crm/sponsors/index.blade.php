@extends('layouts.dashboard')

@section('title', 'Sponsors')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Sponsors & Partenaires</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Gérez vos sponsors et partenaires</p>
        </div>
        <a href="{{ route('organizer.crm.sponsors.create') }}" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouveau sponsor</span><span class="sm:hidden">Nouveau</span>
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total sponsors</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Contribution totale</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600 whitespace-nowrap">{{ number_format($stats['total_contribution'], 0, ',', ' ') }} XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Confirmés</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-purple-600">{{ $stats['by_status']['confirmed'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Liste des sponsors -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Sponsor</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contribution</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($sponsors as $sponsor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $sponsor->name }}</div>
                            @if($sponsor->company)
                                <div class="text-sm text-gray-500">{{ $sponsor->company }}</div>
                            @endif
                            @if($sponsor->event)
                                <div class="text-xs text-gray-400 mt-1">{{ $sponsor->event->title }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($sponsor->sponsor_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                            {{ number_format($sponsor->contribution_amount, 0, ',', ' ') }} {{ $sponsor->currency }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $sponsor->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $sponsor->status === 'prospect' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $sponsor->status === 'negotiating' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $sponsor->status === 'delivered' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $sponsor->status === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($sponsor->status) }}
                            </span>
                        </td>
                        <td class="px-3 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('organizer.crm.sponsors.show', $sponsor) }}" class="text-indigo-600 hover:text-indigo-900 active:text-indigo-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('organizer.crm.sponsors.edit', $sponsor) }}" class="text-gray-600 hover:text-gray-900 active:text-gray-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-handshake text-4xl mb-3 text-gray-300"></i>
                            <p>Aucun sponsor trouvé</p>
                            <a href="{{ route('organizer.crm.sponsors.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                                Ajouter votre premier sponsor
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    @if($sponsors->hasPages())
        <div class="mt-4">
            {{ $sponsors->links() }}
        </div>
    @endif
</div>
@endsection


