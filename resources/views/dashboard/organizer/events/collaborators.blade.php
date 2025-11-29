@extends('layouts.dashboard')

@section('title', 'Collaborateurs - ' . $event->title)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Collaborateurs</h1>
            <p class="text-gray-600 mt-1">{{ $event->title }}</p>
        </div>
        <a href="{{ route('organizer.events.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux événements
        </a>
    </div>

    <!-- Collaborateurs assignés -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Collaborateurs assignés</h2>
        @if($assignedCollaborators->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($assignedCollaborators as $collaborator)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                            <span class="text-indigo-600 font-semibold">{{ substr($collaborator->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $collaborator->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $collaborator->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($collaborator->hasRole('agent'))
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Agent</span>
                                    @elseif($collaborator->team_id)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Membre d'équipe</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Collaborateur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $collaborator->team->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('organizer.events.collaborators.destroy', [$event, $collaborator]) }}" method="POST" onsubmit="return confirm('Retirer ce collaborateur de l\'événement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Retirer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 text-center py-8">Aucun collaborateur assigné pour le moment</p>
        @endif
    </div>

    <!-- Ajouter un collaborateur -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ajouter un collaborateur</h2>
        
        <form action="{{ route('organizer.events.collaborators.store', $event) }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <!-- Membres d'équipe -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Membres d'équipe</label>
                    @if($teamMembers->count() > 0)
                        <select id="team_member_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un membre d'équipe</option>
                            @foreach($teamMembers as $member)
                                <option value="{{ $member->id }}" data-type="team_member">
                                    {{ $member->name }} ({{ $member->email }}) - {{ $member->team->name ?? 'N/A' }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-gray-500">Aucun membre d'équipe disponible. Créez une équipe dans la section CRM.</p>
                    @endif
                </div>

                <!-- Agents -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Agents</label>
                    @if($availableAgents->count() > 0)
                        <select id="agent_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionner un agent</option>
                            @foreach($availableAgents as $agent)
                                <option value="{{ $agent->id }}" data-type="agent">
                                    {{ $agent->name }} ({{ $agent->email }})
                                </option>
                            @endforeach
                        </select>
                    @else
                        <p class="text-sm text-gray-500">Aucun agent disponible.</p>
                    @endif
                </div>
            </div>

            <input type="hidden" name="type" id="collaborator_type" value="team_member">
            <input type="hidden" name="collaborator_id" id="collaborator_id_input" required>

            <div class="mt-6">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-plus mr-2"></i>Ajouter le collaborateur
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const teamMemberSelect = document.getElementById('team_member_select');
    const agentSelect = document.getElementById('agent_select');
    const typeInput = document.getElementById('collaborator_type');
    const collaboratorIdInput = document.getElementById('collaborator_id_input');

    function updateForm() {
        if (teamMemberSelect && teamMemberSelect.value) {
            collaboratorIdInput.value = teamMemberSelect.value;
            typeInput.value = 'team_member';
            if (agentSelect) agentSelect.value = '';
        } else if (agentSelect && agentSelect.value) {
            collaboratorIdInput.value = agentSelect.value;
            typeInput.value = 'agent';
            if (teamMemberSelect) teamMemberSelect.value = '';
        } else {
            collaboratorIdInput.value = '';
        }
    }

    if (teamMemberSelect) {
        teamMemberSelect.addEventListener('change', updateForm);
    }
    if (agentSelect) {
        agentSelect.addEventListener('change', updateForm);
    }

    // Validation du formulaire
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!collaboratorIdInput.value) {
            e.preventDefault();
            alert('Veuillez sélectionner un collaborateur.');
            return false;
        }
    });
});
</script>
@endpush
@endsection

