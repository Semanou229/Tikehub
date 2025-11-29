@extends('layouts.dashboard')

@section('title', 'Sponsors')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Sponsors & Partenaires</h1>
            <p class="text-gray-600 mt-1">Gérez vos sponsors et partenaires</p>
        </div>
        <a href="{{ route('organizer.crm.sponsors.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau sponsor
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total sponsors</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Contribution totale</div>
            <div class="text-3xl font-bold text-green-600">{{ number_format($stats['total_contribution'], 0, ',', ' ') }} XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Confirmés</div>
            <div class="text-3xl font-bold text-purple-600">{{ $stats['by_status']['confirmed'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Liste des sponsors -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
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
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('organizer.crm.sponsors.show', $sponsor) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('organizer.crm.sponsors.edit', $sponsor) }}" class="text-gray-600 hover:text-gray-900" title="Modifier">
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

    @if($sponsors->hasPages())
        <div class="mt-4">
            {{ $sponsors->links() }}
        </div>
    @endif
</div>
@endsection

