@extends('layouts.collaborator')

@section('title', 'Mes Tâches')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Tâches</h1>
        <p class="text-gray-600 mt-2">Tâches qui vous sont assignées</p>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">En attente</div>
            <div class="text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">En cours</div>
            <div class="text-3xl font-bold text-blue-600">{{ $stats['in_progress'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Terminées</div>
            <div class="text-3xl font-bold text-green-600">{{ $stats['completed'] }}</div>
        </div>
    </div>

    <!-- Liste des tâches -->
    @if($tasks->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tâche</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Équipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date limite</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($tasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('collaborator.tasks.show', $task) }}" class="font-semibold text-gray-800 hover:text-indigo-600">
                                        {{ $task->title }}
                                    </a>
                                    @if($task->description)
                                        <p class="text-sm text-gray-500 mt-1">{{ Str::limit($task->description, 100) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $task->team->name ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($task->due_date)
                                        {{ $task->due_date->translatedFormat('d M Y') }}
                                        @if($task->due_date->isPast() && $task->status !== 'completed')
                                            <span class="text-red-600 ml-2">(En retard)</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">Aucune</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        @if($task->status === 'completed') bg-green-100 text-green-800
                                        @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800
                                        @endif">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <form action="{{ route('collaborator.tasks.updateStatus', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded px-2 py-1">
                                            <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                                            <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-4 border-t border-gray-200">
                {{ $tasks->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-tasks text-6xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Aucune tâche assignée</h3>
            <p class="text-gray-600">Vous n'avez pas encore de tâches assignées.</p>
        </div>
    @endif
</div>
@endsection

