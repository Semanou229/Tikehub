@extends('layouts.collaborator')

@section('title', 'Dashboard Collaborateur')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Dashboard Collaborateur</h1>
        <p class="text-sm sm:text-base text-gray-600 mt-1 sm:mt-2">Bienvenue, {{ auth()->user()->name }}</p>
    </div>

    <!-- Statistiques principales -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Scans totaux</p>
                    <p class="text-xl sm:text-2xl font-bold text-indigo-600 break-words">{{ $stats['total_scans'] }}</p>
                </div>
                <i class="fas fa-qrcode text-xl sm:text-2xl lg:text-3xl text-indigo-400 flex-shrink-0 ml-2"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Scans aujourd'hui</p>
                    <p class="text-xl sm:text-2xl font-bold text-green-600 break-words">{{ $stats['today_scans'] }}</p>
                </div>
                <i class="fas fa-calendar-day text-xl sm:text-2xl lg:text-3xl text-green-400 flex-shrink-0 ml-2"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Tâches en cours</p>
                    <p class="text-xl sm:text-2xl font-bold text-yellow-600 break-words">{{ $stats['pending_tasks'] }}</p>
                </div>
                <i class="fas fa-tasks text-xl sm:text-2xl lg:text-3xl text-yellow-400 flex-shrink-0 ml-2"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                    <p class="text-xs sm:text-sm text-gray-600 mb-1">Tâches terminées</p>
                    <p class="text-xl sm:text-2xl font-bold text-blue-600 break-words">{{ $stats['completed_tasks'] }}</p>
                </div>
                <i class="fas fa-check-circle text-xl sm:text-2xl lg:text-3xl text-blue-400 flex-shrink-0 ml-2"></i>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <!-- Événements assignés -->
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-3 sm:mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Événements assignés</h2>
                <a href="{{ route('collaborator.events.index') }}" class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm min-h-[44px] flex items-center">
                    Voir tout <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
            @if($assignedEvents->count() > 0)
                <div class="space-y-2 sm:space-y-3">
                    @foreach($assignedEvents->take(5) as $event)
                        <a href="{{ route('collaborator.events.show', $event) }}" class="block p-2.5 sm:p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 break-words">{{ $event->title }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                                        <i class="fas fa-calendar mr-1 text-xs"></i>
                                        {{ $event->start_date->translatedFormat('d M Y à H:i') }}
                                    </p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-xs sm:text-sm flex-shrink-0 ml-2"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-xs sm:text-sm text-gray-500 text-center py-6 sm:py-8">Aucun événement assigné pour le moment</p>
            @endif
        </div>

        <!-- Mes tâches -->
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 sm:gap-0 mb-3 sm:mb-4">
                <h2 class="text-lg sm:text-xl font-bold text-gray-800">Mes tâches</h2>
                <a href="{{ route('collaborator.tasks.index') }}" class="text-indigo-600 hover:text-indigo-800 text-xs sm:text-sm min-h-[44px] flex items-center">
                    Voir tout <i class="fas fa-arrow-right ml-1 text-xs"></i>
                </a>
            </div>
            @if($myTasks->count() > 0)
                <div class="space-y-2 sm:space-y-3">
                    @foreach($myTasks->take(5) as $task)
                        <a href="{{ route('collaborator.tasks.show', $task) }}" class="block p-2.5 sm:p-3 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                            <div class="flex items-center justify-between">
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-sm sm:text-base font-semibold text-gray-800 break-words">{{ $task->title }}</h3>
                                    <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 mt-1">
                                        <span class="px-2 py-1 text-xs rounded-full whitespace-nowrap
                                            @if($task->status === 'completed') bg-green-100 text-green-800
                                            @elseif($task->status === 'in_progress') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800
                                            @endif">
                                            @if($task->status === 'completed')
                                                Terminée
                                            @elseif($task->status === 'in_progress')
                                                En cours
                                            @else
                                                En attente
                                            @endif
                                        </span>
                                        @if($task->due_date)
                                            <span class="text-xs text-gray-500">
                                                <i class="fas fa-clock mr-1 text-xs"></i>
                                                {{ $task->due_date->translatedFormat('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 text-xs sm:text-sm flex-shrink-0 ml-2"></i>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="text-xs sm:text-sm text-gray-500 text-center py-6 sm:py-8">Aucune tâche assignée</p>
            @endif
        </div>
    </div>

    <!-- Scans récents -->
    <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 sm:mb-4">Scans récents</h2>
        @if($recentScans->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Date</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Événement</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden sm:table-cell">Billet</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Acheteur</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentScans as $scan)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                    {{ $scan->created_at->translatedFormat('d/m/Y H:i') }}
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900">
                                    <div class="break-words">{{ $scan->event->title ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500 mt-1 sm:hidden">
                                        Billet: {{ $scan->ticket->code ?? 'N/A' }}
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 md:hidden">
                                        {{ $scan->ticket->buyer->name ?? $scan->ticket->buyer_name ?? 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden sm:table-cell">
                                    {{ $scan->ticket->code ?? 'N/A' }}
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-900 hidden md:table-cell">
                                    <span class="truncate max-w-[150px] block">{{ $scan->ticket->buyer->name ?? $scan->ticket->buyer_name ?? 'N/A' }}</span>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                    @if($scan->is_valid)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 whitespace-nowrap">Valide</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 whitespace-nowrap">Invalide</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-xs sm:text-sm text-gray-500 text-center py-6 sm:py-8">Aucun scan effectué pour le moment</p>
        @endif
    </div>
</div>
@endsection


