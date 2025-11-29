@extends('layouts.dashboard')

@section('title', 'Tâches de l\'Équipe')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Tâches</h1>
            <p class="text-gray-600 mt-1">Équipe: {{ $team->name }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('organizer.crm.teams.tasks.create', $team) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvelle tâche
            </a>
            <a href="{{ route('organizer.crm.teams.show', $team) }}" class="text-gray-600 hover:text-gray-800 px-4 py-2">
                <i class="fas fa-arrow-left mr-2"></i>Retour à l'équipe
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'todo']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'todo' ? 'bg-gray-800 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                À faire
            </a>
            <a href="{{ route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'in_progress']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'in_progress' ? 'bg-yellow-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                En cours
            </a>
            <a href="{{ route('organizer.crm.teams.tasks.index', ['team' => $team, 'status' => 'done']) }}" class="px-4 py-2 rounded-lg {{ request('status') == 'done' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                Terminé
            </a>
            <a href="{{ route('organizer.crm.teams.tasks.index', $team) }}" class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200">
                Toutes
            </a>
        </div>
    </div>

    <!-- Liste des tâches -->
    <div class="space-y-4">
        @forelse($tasks as $task)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-800">{{ $task->title }}</h3>
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                {{ $task->status === 'done' ? 'bg-green-100 text-green-800' : 
                                   ($task->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $task->status === 'done' ? 'Terminé' : ($task->status === 'in_progress' ? 'En cours' : 'À faire') }}
                            </span>
                        </div>
                        
                        @if($task->description)
                            <p class="text-gray-600 mb-4">{{ $task->description }}</p>
                        @endif

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                            @if($task->assignedUser)
                                <span><i class="fas fa-user mr-1"></i>Assigné à: {{ $task->assignedUser->name }}</span>
                            @else
                                <span><i class="fas fa-user mr-1"></i>Non assigné</span>
                            @endif
                            
                            @if($task->due_date)
                                <span><i class="fas fa-calendar mr-1"></i>Échéance: {{ $task->due_date->format('d/m/Y') }}</span>
                                @if($task->due_date->isPast() && $task->status !== 'done')
                                    <span class="text-red-600 font-semibold">En retard</span>
                                @endif
                            @endif
                            
                            <span><i class="fas fa-clock mr-1"></i>{{ $task->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="flex gap-2 ml-4">
                        <a href="{{ route('organizer.crm.teams.tasks.edit', [$team, $task]) }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('organizer.crm.teams.tasks.destroy', [$team, $task]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition text-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-tasks text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucune tâche trouvée</p>
                <a href="{{ route('organizer.crm.teams.tasks.create', $team) }}" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre première tâche
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($tasks->hasPages())
        <div class="mt-6">
            {{ $tasks->links() }}
        </div>
    @endif
</div>
@endsection

