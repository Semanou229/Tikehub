@extends('layouts.dashboard')

@section('title', 'Gestion des Agents')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Gestion des Agents</h1>
        <a href="{{ route('organizer.agents.create') }}" class="bg-indigo-600 text-white px-3 sm:px-5 lg:px-6 py-2 sm:py-2.5 lg:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg w-full sm:w-auto">
            <i class="fas fa-plus text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Assigner un agent</span><span class="sm:hidden">Assigner</span>
        </a>
    </div>

    @if($agents->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Agent</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Événements assignés</th>
                            <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($agents as $agent)
                            <tr class="hover:bg-gray-50">
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                    <div class="text-xs sm:text-sm font-medium text-gray-900 break-words">{{ $agent->name }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 mt-1 break-words">{{ $agent->email }}</div>
                                    <div class="text-xs sm:text-sm text-gray-500 mt-2 md:hidden">
                                        <span class="font-medium">Événements:</span>
                                        <div class="flex flex-wrap gap-1.5 mt-1">
                                            @foreach($agent->agentEvents as $event)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ Str::limit($event->title, 20) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 hidden md:table-cell">
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($agent->agentEvents as $event)
                                            <span class="inline-flex items-center px-2 sm:px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 break-words max-w-[200px]">
                                                {{ $event->title }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                    <div class="flex flex-col sm:flex-row flex-wrap gap-1.5 sm:gap-2">
                                        @foreach($agent->agentEvents as $event)
                                            <form action="{{ route('organizer.agents.destroy', [$event, $agent]) }}" method="POST" class="inline" onsubmit="return confirm('Retirer cet agent de cet événement ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 active:text-red-700 text-xs sm:text-sm min-w-[32px] min-h-[32px] sm:min-w-[36px] sm:min-h-[36px] flex items-center justify-center" title="Retirer de {{ $event->title }}">
                                                    <i class="fas fa-times text-xs sm:text-sm"></i><span class="hidden lg:inline ml-1">{{ Str::limit($event->title, 15) }}</span>
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($agents->hasPages())
            <div class="mt-4 sm:mt-6 overflow-x-auto">
                <div class="min-w-fit">
                    {{ $agents->links() }}
                </div>
            </div>
        @endif
    @else
        <div class="bg-white rounded-lg shadow-md p-6 sm:p-8 lg:p-12 text-center">
            <i class="fas fa-users text-4xl sm:text-5xl lg:text-6xl text-gray-300 mb-3 sm:mb-4"></i>
            <p class="text-sm sm:text-base text-gray-500 mb-3 sm:mb-4">Aucun agent assigné</p>
            <a href="{{ route('organizer.agents.create') }}" class="inline-block bg-indigo-600 text-white px-4 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                <i class="fas fa-plus text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Assigner un agent
            </a>
        </div>
    @endif
</div>
@endsection


