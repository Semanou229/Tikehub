@extends('layouts.dashboard')

@section('title', 'Gestion des Agents')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Agents</h1>
        <a href="{{ route('organizer.agents.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Assigner un agent
        </a>
    </div>

    @if($agents->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événements assignés</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($agents as $agent)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $agent->name }}</div>
                                <div class="text-sm text-gray-500">{{ $agent->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($agent->agentEvents as $event)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                            {{ $event->title }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @foreach($agent->agentEvents as $event)
                                    <form action="{{ route('organizer.agents.destroy', [$event, $agent]) }}" method="POST" class="inline mr-2" onsubmit="return confirm('Retirer cet agent de cet événement ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Retirer de {{ $event->title }}">
                                            <i class="fas fa-times"></i> {{ Str::limit($event->title, 20) }}
                                        </button>
                                    </form>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $agents->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun agent assigné</p>
            <a href="{{ route('organizer.agents.create') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Assigner un agent
            </a>
        </div>
    @endif
</div>
@endsection

