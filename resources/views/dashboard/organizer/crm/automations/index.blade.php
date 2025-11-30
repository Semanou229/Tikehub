@extends('layouts.dashboard')

@section('title', 'Automations')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Automations</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Créez des workflows automatiques pour vos contacts</p>
        </div>
        <a href="{{ route('organizer.crm.automations.create') }}" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center w-full sm:w-auto">
            <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouvelle automation</span><span class="sm:hidden">Nouvelle</span>
        </a>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total automations</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Actives</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600">{{ $stats['active'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Exécutions totales</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-purple-600 whitespace-nowrap">{{ number_format($stats['total_executed']) }}</div>
        </div>
    </div>

    <!-- Liste des automations -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Déclencheur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Exécutions</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($automations as $automation)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $automation->name }}</div>
                            @if($automation->description)
                                <div class="text-sm text-gray-500">{{ Str::limit($automation->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @php
                                $triggers = [
                                    'ticket_purchased' => 'Achat de billet',
                                    'cart_abandoned' => 'Panier abandonné',
                                    'before_event' => 'Avant l\'événement',
                                    'after_event' => 'Après l\'événement',
                                    'vote_cast' => 'Vote effectué',
                                    'donation_made' => 'Don effectué',
                                    'custom' => 'Personnalisé',
                                ];
                            @endphp
                            {{ $triggers[$automation->trigger_type] ?? $automation->trigger_type }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            @php
                                $actions = [
                                    'send_email' => 'Envoyer un email',
                                    'add_tag' => 'Ajouter une étiquette',
                                    'assign_to' => 'Assigner à un membre',
                                    'update_stage' => 'Mettre à jour le pipeline',
                                    'create_task' => 'Créer une tâche',
                                ];
                            @endphp
                            {{ $actions[$automation->action_type] ?? $automation->action_type }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $automation->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $automation->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ number_format($automation->executed_count) }}
                            @if($automation->last_executed_at)
                                <div class="text-xs text-gray-400 mt-1">Dernière: {{ $automation->last_executed_at->format('d/m/Y H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-3 sm:px-6 py-4">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('organizer.crm.automations.toggle', $automation) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-{{ $automation->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $automation->is_active ? 'yellow' : 'green' }}-900 active:text-{{ $automation->is_active ? 'yellow' : 'green' }}-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="{{ $automation->is_active ? 'Désactiver' : 'Activer' }}">
                                        <i class="fas fa-{{ $automation->is_active ? 'pause' : 'play' }}"></i>
                                    </button>
                                </form>
                                <a href="{{ route('organizer.crm.automations.edit', $automation) }}" class="text-gray-600 hover:text-gray-900 active:text-gray-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('organizer.crm.automations.destroy', $automation) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette automation ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 active:text-red-700 min-w-[36px] min-h-[36px] flex items-center justify-center" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-cogs text-4xl mb-3 text-gray-300"></i>
                            <p>Aucune automation trouvée</p>
                            <a href="{{ route('organizer.crm.automations.create') }}" class="text-indigo-600 hover:text-indigo-800 mt-4 inline-block">
                                Créer votre première automation
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>

    @if($automations->hasPages())
        <div class="mt-4">
            {{ $automations->links() }}
        </div>
    @endif
</div>
@endsection


