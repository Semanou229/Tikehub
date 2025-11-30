@extends('layouts.dashboard')

@section('title', 'Contacts CRM')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Contacts CRM</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1">Gérez tous vos contacts et relations</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="bg-gray-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-gray-700 active:bg-gray-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                <i class="fas fa-file-import mr-2"></i><span class="hidden sm:inline">Importer CSV/Excel</span><span class="sm:hidden">Importer</span>
            </button>
            <a href="{{ route('organizer.crm.contacts.create') }}" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i><span class="hidden sm:inline">Nouveau contact</span><span class="sm:hidden">Nouveau</span>
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total contacts</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total'] }}</div>
        </div>
        @foreach(['participant', 'sponsor', 'vip', 'staff'] as $cat)
            <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
                <div class="text-xs sm:text-sm text-gray-600 mb-1">{{ ucfirst($cat) }}s</div>
                <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-purple-600">{{ $stats['by_category'][$cat] ?? 0 }}</div>
            </div>
        @endforeach
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6 mb-4 sm:mb-6">
        <form method="GET" action="{{ route('organizer.crm.contacts.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Recherche</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nom, email, téléphone..." class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Catégorie</label>
                <select name="category" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <option value="">Toutes</option>
                    @foreach(['participant', 'sponsor', 'staff', 'press', 'vip', 'partner', 'prospect'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Pipeline</label>
                <select name="pipeline_stage" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <option value="">Tous</option>
                    @foreach(['prospect', 'confirmed', 'partner', 'closed'] as $stage)
                        <option value="{{ $stage }}" {{ request('pipeline_stage') == $stage ? 'selected' : '' }}>{{ ucfirst($stage) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2 sm:gap-2">
                <button type="submit" class="flex-1 bg-indigo-600 text-white px-3 sm:px-4 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-medium text-xs sm:text-sm min-h-[44px] flex items-center justify-center shadow-sm hover:shadow-md">
                    <i class="fas fa-search text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Filtrer</span><span class="sm:hidden">Filt.</span>
                </button>
                <a href="{{ route('organizer.crm.contacts.index') }}" class="bg-gray-200 text-gray-700 px-3 sm:px-4 py-2.5 sm:py-3 rounded-lg hover:bg-gray-300 active:bg-gray-400 transition min-w-[44px] min-h-[44px] flex items-center justify-center">
                    <i class="fas fa-times text-xs sm:text-sm"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Liste des contacts -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Contact</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Catégorie</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Pipeline</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Assigné à</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($contacts as $contact)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                <div class="font-semibold text-sm sm:text-base text-gray-900 break-words">{{ $contact->full_name }}</div>
                                <div class="text-xs sm:text-sm text-gray-500 mt-1">
                                    @if($contact->email)
                                        <div class="flex items-center"><i class="fas fa-envelope mr-1 text-xs"></i><span class="truncate max-w-[200px] sm:max-w-none">{{ $contact->email }}</span></div>
                                    @endif
                                    @if($contact->phone)
                                        <div class="flex items-center mt-1"><i class="fas fa-phone mr-1 text-xs"></i><span>{{ $contact->phone }}</span></div>
                                    @endif
                                </div>
                                @if($contact->company)
                                    <div class="text-xs text-gray-400 mt-1 truncate max-w-[200px] sm:max-w-none">{{ $contact->company }}</div>
                                @endif
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 whitespace-nowrap">
                                    {{ ucfirst($contact->category) }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                                    {{ $contact->pipeline_stage === 'prospect' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $contact->pipeline_stage === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $contact->pipeline_stage === 'partner' ? 'bg-purple-100 text-purple-800' : '' }}
                                    {{ $contact->pipeline_stage === 'closed' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($contact->pipeline_stage) }}
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 text-xs sm:text-sm text-gray-500 hidden md:table-cell">
                                <span class="truncate max-w-[150px] block">{{ $contact->assignedUser->name ?? 'Non assigné' }}</span>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                <div class="flex items-center gap-2 sm:gap-3">
                                    <a href="{{ route('organizer.crm.contacts.show', $contact) }}" class="text-indigo-600 hover:text-indigo-900 min-w-[32px] min-h-[32px] flex items-center justify-center" title="Voir">
                                        <i class="fas fa-eye text-sm sm:text-base"></i>
                                    </a>
                                    <a href="{{ route('organizer.crm.contacts.edit', $contact) }}" class="text-gray-600 hover:text-gray-900 min-w-[32px] min-h-[32px] flex items-center justify-center" title="Modifier">
                                        <i class="fas fa-edit text-sm sm:text-base"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-3 sm:px-6 py-8 sm:py-12 text-center text-gray-500">
                                <i class="fas fa-address-book text-3xl sm:text-4xl mb-3 text-gray-300"></i>
                                <p class="text-sm sm:text-base">Aucun contact trouvé</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($contacts->hasPages())
        <div class="mt-4 sm:mt-6 overflow-x-auto">
            <div class="min-w-fit">
                {{ $contacts->links() }}
            </div>
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


