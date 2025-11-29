@extends('layouts.dashboard')

@section('title', $team->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $team->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('organizer.crm.teams.edit', $team) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('organizer.crm.teams.index') }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    @if($team->description)
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <p class="text-gray-700">{{ $team->description }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['members_count'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Membres</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['tasks_todo'] + $stats['tasks_in_progress'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Tâches en cours</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-3xl font-bold text-green-600">{{ $stats['tasks_done'] }}</div>
            <div class="text-sm text-gray-600 mt-1">Tâches terminées</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Membres -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Membres</h2>
                <button onclick="showAddMemberModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Ajouter
                </button>
            </div>
            
            @if($team->members->count() > 0)
                <div class="space-y-3">
                    @foreach($team->members as $member)
                        <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                            <div>
                                <div class="font-semibold text-gray-800">{{ $member->name }}</div>
                                <div class="text-sm text-gray-600">{{ $member->email }}</div>
                                <div class="text-xs text-indigo-600 mt-1">{{ ucfirst($member->team_role) }}</div>
                            </div>
                            <form action="{{ route('organizer.crm.teams.removeMember', [$team, $member]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer ce membre ?')">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">Aucun membre dans cette équipe</p>
            @endif
        </div>

        <!-- Tâches -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Tâches</h2>
                <a href="{{ route('organizer.crm.teams.tasks.create', $team) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                    <i class="fas fa-plus mr-2"></i>Nouvelle tâche
                </a>
            </div>
            
            @if($team->tasks->count() > 0)
                <div class="space-y-3">
                    @foreach($team->tasks->take(10) as $task)
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">{{ $task->title }}</div>
                                    @if($task->description)
                                        <div class="text-sm text-gray-600 mt-1">{{ Str::limit($task->description, 50) }}</div>
                                    @endif
                                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500">
                                        @if($task->assignee)
                                            <span><i class="fas fa-user mr-1"></i>{{ $task->assignee->name }}</span>
                                        @endif
                                        @if($task->due_date)
                                            <span><i class="fas fa-calendar mr-1"></i>{{ $task->due_date->format('d/m/Y') }}</span>
                                        @endif
                                        <span class="px-2 py-1 rounded {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($team->tasks->count() > 10)
                    <div class="mt-4 text-center">
                        <a href="{{ route('organizer.crm.teams.tasks.index', $team) }}" class="text-indigo-600 hover:text-indigo-800">
                            Voir toutes les tâches ({{ $team->tasks->count() }})
                        </a>
                    </div>
                @endif
            @else
                <p class="text-gray-500 text-center py-8">Aucune tâche assignée</p>
            @endif
        </div>
    </div>
</div>

<!-- Modal pour ajouter un membre -->
<div id="addMemberModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Ajouter un membre</h3>
            <button onclick="hideAddMemberModal()" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <form action="{{ route('organizer.crm.teams.addMember', $team) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Utilisateur *</label>
                    <select name="user_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Sélectionner un utilisateur</option>
                        @foreach(\App\Models\User::where('id', '!=', auth()->id())->get() as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rôle *</label>
                    <select name="team_role" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="staff">Staff</option>
                        <option value="manager">Manager</option>
                        <option value="agent">Agent</option>
                        <option value="volunteer">Bénévole</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex gap-4">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                    Ajouter
                </button>
                <button type="button" onclick="hideAddMemberModal()" class="flex-1 bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showAddMemberModal() {
    document.getElementById('addMemberModal').classList.remove('hidden');
}

function hideAddMemberModal() {
    document.getElementById('addMemberModal').classList.add('hidden');
}
</script>
@endpush
@endsection

