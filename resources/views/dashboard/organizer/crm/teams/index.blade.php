@extends('layouts.dashboard')

@section('title', 'Équipes')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Équipes</h1>
            <p class="text-gray-600 mt-1">Gérez vos équipes et collaborateurs</p>
        </div>
        <a href="{{ route('organizer.crm.teams.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle équipe
        </a>
    </div>

    <!-- Liste des équipes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($teams as $team)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $team->name }}</h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                        {{ $team->members()->count() }} membres
                    </span>
                </div>
                @if($team->description)
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($team->description, 100) }}</p>
                @endif
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-tasks mr-1"></i>{{ $team->tasks()->count() }} tâches
                    </div>
                    <a href="{{ route('organizer.crm.teams.show', $team) }}" class="text-indigo-600 hover:text-indigo-800">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="md:col-span-3 bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-users text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucune équipe créée</p>
                <a href="{{ route('organizer.crm.teams.create') }}" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre première équipe
                </a>
            </div>
        @endforelse
    </div>

    <!-- Section Agents (ancien système) -->
    @if($agents->count() > 0)
        <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Agents existants</h2>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($agents as $agent)
                            <tr>
                                <td class="px-6 py-4">{{ $agent->name }}</td>
                                <td class="px-6 py-4">{{ $agent->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-500">Assignez à une équipe depuis la page de l'équipe</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

