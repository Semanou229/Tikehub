@extends('layouts.collaborator')

@section('title', $task->title)

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('collaborator.tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux tâches
        </a>
        <h1 class="text-3xl font-bold text-gray-800">{{ $task->title }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Description -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Description</h2>
                <p class="text-gray-700">{{ $task->description ?? 'Aucune description' }}</p>
            </div>

            <!-- Notes -->
            @if($task->notes)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Notes</h2>
                    <p class="text-gray-700">{{ $task->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Informations -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations</h2>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-600">Statut</p>
                        <span class="px-2 py-1 text-xs font-semibold rounded-full mt-1 inline-block
                            @if($task->status === 'completed') bg-green-100 text-green-800
                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($task->status) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Équipe</p>
                        <p class="font-semibold">{{ $task->team->name ?? 'N/A' }}</p>
                    </div>
                    @if($task->due_date)
                        <div>
                            <p class="text-sm text-gray-600">Date limite</p>
                            <p class="font-semibold">{{ $task->due_date->translatedFormat('d M Y à H:i') }}</p>
                            @if($task->due_date->isPast() && $task->status !== 'completed')
                                <span class="text-red-600 text-sm">(En retard)</span>
                            @endif
                        </div>
                    @endif
                    @if($task->completed_at)
                        <div>
                            <p class="text-sm text-gray-600">Terminée le</p>
                            <p class="font-semibold">{{ $task->completed_at->translatedFormat('d M Y à H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Changer le statut</h2>
                <form action="{{ route('collaborator.tasks.updateStatus', $task) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                        <option value="pending" {{ $task->status === 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="in_progress" {{ $task->status === 'in_progress' ? 'selected' : '' }}>En cours</option>
                        <option value="completed" {{ $task->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                    </select>
                    <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                        Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


