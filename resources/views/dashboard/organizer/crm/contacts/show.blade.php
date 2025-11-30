@extends('layouts.dashboard')

@section('title', $contact->full_name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $contact->full_name }}</h1>
            @if($contact->company)
                <p class="text-gray-600 mt-1">{{ $contact->company }}</p>
            @endif
        </div>
        <div class="flex gap-3">
            <a href="{{ route('organizer.crm.contacts.edit', $contact) }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('organizer.crm.contacts.index') }}" class="text-gray-600 hover:text-gray-800 px-6 py-3">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations principales -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Informations</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <span class="text-sm text-gray-600">Prénom:</span>
                        <p class="font-semibold text-gray-800">{{ $contact->first_name }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Nom:</span>
                        <p class="font-semibold text-gray-800">{{ $contact->last_name }}</p>
                    </div>
                    @if($contact->email)
                        <div>
                            <span class="text-sm text-gray-600">Email:</span>
                            <p class="font-semibold text-gray-800">
                                <a href="mailto:{{ $contact->email }}" class="text-indigo-600 hover:text-indigo-800">{{ $contact->email }}</a>
                            </p>
                        </div>
                    @endif
                    @if($contact->phone)
                        <div>
                            <span class="text-sm text-gray-600">Téléphone:</span>
                            <p class="font-semibold text-gray-800">
                                <a href="tel:{{ $contact->phone }}" class="text-indigo-600 hover:text-indigo-800">{{ $contact->phone }}</a>
                            </p>
                        </div>
                    @endif
                    @if($contact->company)
                        <div>
                            <span class="text-sm text-gray-600">Entreprise:</span>
                            <p class="font-semibold text-gray-800">{{ $contact->company }}</p>
                        </div>
                    @endif
                    @if($contact->job_title)
                        <div>
                            <span class="text-sm text-gray-600">Poste:</span>
                            <p class="font-semibold text-gray-800">{{ $contact->job_title }}</p>
                        </div>
                    @endif
                    @if($contact->category)
                        <div>
                            <span class="text-sm text-gray-600">Catégorie:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                {{ ucfirst($contact->category) }}
                            </span>
                        </div>
                    @endif
                    @if($contact->pipeline_stage)
                        <div>
                            <span class="text-sm text-gray-600">Étape pipeline:</span>
                            <span class="ml-2 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($contact->pipeline_stage) }}
                            </span>
                        </div>
                    @endif
                    @if($contact->assignedUser)
                        <div>
                            <span class="text-sm text-gray-600">Assigné à:</span>
                            <p class="font-semibold text-gray-800">{{ $contact->assignedUser->name }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tags -->
            @if($contact->tags->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($contact->tags as $tag)
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 text-sm rounded-full">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Segments -->
            @if($contact->segments->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Segments</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach($contact->segments as $segment)
                            <span class="px-3 py-1 bg-green-100 text-green-800 text-sm rounded-full">
                                {{ $segment->name }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Notes -->
            @if($contact->notes)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Notes</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $contact->notes }}</p>
                    </div>
                </div>
            @endif

            <!-- Historique des activités -->
            @if($activities->count() > 0)
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Historique des activités</h3>
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <div class="border-l-4 border-indigo-500 pl-4 py-2">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="font-semibold text-gray-800">{{ $activity->description ?? 'Activité' }}</p>
                                    <span class="text-xs text-gray-500">{{ $activity->created_at->translatedFormat('d/m/Y à H:i') }}</span>
                                </div>
                                @if($activity->properties)
                                    <p class="text-sm text-gray-600">{{ json_encode($activity->properties, JSON_PRETTY_PRINT) }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Statistiques -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statistiques</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm text-gray-600">Billets achetés:</span>
                        <p class="text-2xl font-bold text-indigo-600">{{ $contact->tickets->count() }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Votes:</span>
                        <p class="text-2xl font-bold text-purple-600">{{ $contact->votes->count() }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-600">Dons:</span>
                        <p class="text-2xl font-bold text-green-600">{{ $contact->donations->count() }}</p>
                    </div>
                    @if($contact->total_spent > 0)
                        <div>
                            <span class="text-sm text-gray-600">Total dépensé:</span>
                            <p class="text-2xl font-bold text-green-600">{{ number_format($contact->total_spent, 0, ',', ' ') }} XOF</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Dates importantes -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Dates importantes</h3>
                <div class="space-y-3">
                    @if($contact->last_contacted_at)
                        <div>
                            <span class="text-sm text-gray-600">Dernier contact:</span>
                            <p class="text-sm font-semibold text-gray-800">{{ $contact->last_contacted_at->translatedFormat('d/m/Y') }}</p>
                        </div>
                    @endif
                    @if($contact->next_follow_up_at)
                        <div>
                            <span class="text-sm text-gray-600">Prochain suivi:</span>
                            <p class="text-sm font-semibold text-gray-800">{{ $contact->next_follow_up_at->translatedFormat('d/m/Y') }}</p>
                        </div>
                    @endif
                    <div>
                        <span class="text-sm text-gray-600">Créé le:</span>
                        <p class="text-sm font-semibold text-gray-800">{{ $contact->created_at->translatedFormat('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Statut -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statut</h3>
                <div class="space-y-2">
                    <div>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $contact->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $contact->is_active ? 'Actif' : 'Inactif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Billets -->
    @if($contact->tickets->count() > 0)
        <div class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Billets achetés</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Événement</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prix</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($contact->tickets as $ticket)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($ticket->event)
                                        <a href="{{ route('events.show', $ticket->event) }}" class="text-indigo-600 hover:text-indigo-800">
                                            {{ $ticket->event->title }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->ticketType->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ number_format($ticket->price, 0, ',', ' ') }} XOF</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ticket->created_at->translatedFormat('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-semibold rounded {{ $ticket->status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
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

