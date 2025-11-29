@extends('layouts.dashboard')

@section('title', 'Mes Concours')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Concours</h1>
        <a href="{{ route('contests.create') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau concours
        </a>
    </div>

    @if($contests->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Concours</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statistiques</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($contests as $contest)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $contest->name }}</div>
                                @if($contest->description)
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($contest->description, 60) }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $contest->start_date->format('d/m/Y') }}</div>
                                <div class="text-sm text-gray-500">au {{ $contest->end_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="fas fa-vote-yea text-purple-600 mr-1"></i>
                                    {{ number_format($contest->votes_count, 0, ',', ' ') }} votes
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-users text-purple-600 mr-1"></i>
                                    {{ $contest->candidates_count }} candidats
                                </div>
                                <div class="text-sm text-gray-500">
                                    <i class="fas fa-coins text-purple-600 mr-1"></i>
                                    {{ number_format($contest->price_per_vote, 0, ',', ' ') }} XOF/vote
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @if($contest->is_published)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publié</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                    @endif
                                    @if($contest->isActive())
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Actif</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminé</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('contests.show', $contest) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('contests.edit', $contest) }}" class="text-gray-600 hover:text-gray-900" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$contest->is_published)
                                        <form action="{{ route('contests.publish', $contest) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Publier">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('organizer.contests.destroy', $contest) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce concours ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $contests->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-trophy text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucun concours créé pour le moment</p>
            <a href="{{ route('contests.create') }}" class="inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-plus mr-2"></i>Créer mon premier concours
            </a>
        </div>
    @endif
</div>
@endsection

