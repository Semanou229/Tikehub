@extends('layouts.dashboard')

@section('title', 'Mes Collectes de Fonds')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Collectes de Fonds</h1>
        <a href="{{ route('fundraisings.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle collecte
        </a>
    </div>

    @if($fundraisings->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Collecte</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Progression</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($fundraisings as $fundraising)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $fundraising->name }}</div>
                                @if($fundraising->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($fundraising->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $fundraising->start_date->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">au {{ $fundraising->end_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 mb-1">
                                    <strong>{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</strong> / 
                                    {{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-1">
                                    <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format($fundraising->progress_percentage, 1) }}% - {{ $fundraising->donations_count }} dons
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($fundraising->is_published)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publiée</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                    @endif
                                    @if($fundraising->isActive())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('fundraisings.show', $fundraising) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('fundraisings.edit', $fundraising) }}" class="text-gray-600 hover:text-gray-900" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$fundraising->is_published)
                                        <form action="{{ route('fundraisings.publish', $fundraising) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Publier">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('organizer.fundraisings.destroy', $fundraising) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette collecte ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $fundraisings->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucune collecte de fonds créée pour le moment</p>
            <a href="{{ route('fundraisings.create') }}" class="inline-block bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer ma première collecte
            </a>
        </div>
    @endif
</div>
@endsection

