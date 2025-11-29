@extends('layouts.dashboard')

@section('title', 'Contacts CRM')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Contacts CRM</h1>
            <p class="text-gray-600 mt-1">Gérez tous vos contacts et relations</p>
        </div>
        <div class="flex gap-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-file-import mr-2"></i>Importer CSV/Excel
            </button>
            <a href="{{ route('organizer.crm.contacts.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouveau contact
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="text-sm text-gray-600 mb-1">Total contacts</div>
            <div class="text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        @foreach(['participant', 'sponsor', 'vip', 'staff'] as $cat)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="text-sm text-gray-600 mb-1">{{ ucfirst($cat) }}s</div>
                <div class="text-3xl font-bold text-purple-600">{{ $stats['by_category'][$cat] ?? 0 }}</div>
            </div>
        @endforeach
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('organizer.crm.contacts.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie</label>
                <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Toutes</option>
                    @foreach(['participant', 'sponsor', 'staff', 'press', 'vip', 'partner', 'prospect'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pipeline</label>
                <select name="pipeline_stage" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <option value="">Tous</option>
                    @foreach(['prospect', 'confirmed', 'partner', 'closed'] as $stage)
                        <option value="{{ $stage }}" {{ request('pipeline_stage') == $stage ? 'selected' : '' }}>{{ ucfirst($stage) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition w-full">
                    <i class="fas fa-search mr-2"></i>Filtrer
                </button>
                <a href="{{ route('organizer.crm.contacts.index') }}" class="bg-gray-200 text-gray-700 px-4 py-3 rounded-lg hover:bg-gray-300 transition">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des contacts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pipeline</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigné à</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $contact->full_name }}</div>
                            <div class="text-sm text-gray-500">
                                @if($contact->email)
                                    <i class="fas fa-envelope mr-1"></i>{{ $contact->email }}
                                @endif
                                @if($contact->phone)
                                    <span class="ml-3"><i class="fas fa-phone mr-1"></i>{{ $contact->phone }}</span>
                                @endif
                            </div>
                            @if($contact->company)
                                <div class="text-xs text-gray-400 mt-1">{{ $contact->company }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($contact->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $contact->pipeline_stage === 'prospect' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $contact->pipeline_stage === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $contact->pipeline_stage === 'partner' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $contact->pipeline_stage === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($contact->pipeline_stage) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $contact->assignedUser->name ?? 'Non assigné' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('organizer.crm.contacts.show', $contact) }}" class="text-indigo-600 hover:text-indigo-900" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('organizer.crm.contacts.edit', $contact) }}" class="text-gray-600 hover:text-gray-900" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-address-book text-4xl mb-3 text-gray-300"></i>
                            <p>Aucun contact trouvé</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($contacts->hasPages())
        <div class="mt-4">
            {{ $contacts->links() }}
        </div>
    @endif
</div>

<!-- Modal Import -->
<div id="importModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-800">Importer des contacts</h3>
            <button onclick="document.getElementById('importModal').classList.add('hidden')" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form action="{{ route('organizer.crm.contacts.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Fichier CSV/Excel</label>
                <input type="file" name="file" accept=".csv,.xlsx,.xls" required class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                <p class="text-xs text-gray-500 mt-1">Colonnes attendues: Prénom, Nom, Email, Téléphone, Entreprise</p>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-upload mr-2"></i>Importer
                </button>
                <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                    Annuler
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

