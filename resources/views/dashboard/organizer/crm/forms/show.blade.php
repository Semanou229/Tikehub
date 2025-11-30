@extends('layouts.dashboard')

@section('title', $form->name)

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 break-words">{{ $form->name }}</h1>
            @if($form->description)
                <p class="text-sm sm:text-base text-gray-600 mt-1 break-words">{{ $form->description }}</p>
            @endif
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3 w-full sm:w-auto">
            <a href="{{ route('organizer.crm.forms.edit', $form) }}" class="bg-gray-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-gray-700 active:bg-gray-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                <i class="fas fa-edit mr-2"></i>Modifier
            </a>
            <a href="{{ route('organizer.crm.forms.submissions', $form) }}" class="bg-indigo-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm sm:text-base font-medium min-h-[44px] flex items-center justify-center">
                <i class="fas fa-list mr-2"></i><span class="hidden sm:inline">Voir les soumissions</span><span class="sm:hidden">Soumissions</span>
            </a>
            @if($stats['total_submissions'] > 0)
                <div class="relative group">
                    <button class="bg-green-600 text-white px-4 sm:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-green-700 active:bg-green-800 transition flex items-center justify-center min-h-[44px] w-full sm:w-auto text-sm sm:text-base font-medium">
                        <i class="fas fa-download mr-2"></i>Exporter
                        <i class="fas fa-chevron-down ml-2 text-sm"></i>
                    </button>
                    <div class="hidden group-hover:block absolute right-0 mt-2 bg-white rounded-lg shadow-lg border border-gray-200 z-10 min-w-[150px]">
                        <a href="{{ route('organizer.crm.forms.export', ['form' => $form, 'format' => 'xlsx']) }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 active:bg-gray-200 rounded-t-lg min-h-[44px] flex items-center">
                            <i class="fas fa-file-excel mr-2 text-green-600"></i>Excel (.xlsx)
                        </a>
                        <a href="{{ route('organizer.crm.forms.export', ['form' => $form, 'format' => 'csv']) }}" class="block px-4 py-2.5 text-gray-700 hover:bg-gray-100 active:bg-gray-200 rounded-b-lg min-h-[44px] flex items-center">
                            <i class="fas fa-file-csv mr-2 text-blue-600"></i>CSV (.csv)
                        </a>
                    </div>
                </div>
            @endif
            <a href="{{ route('organizer.crm.forms.index') }}" class="text-indigo-600 hover:text-indigo-800 active:text-indigo-900 px-4 sm:px-6 py-2.5 sm:py-3 min-h-[44px] flex items-center justify-center">
                <i class="fas fa-arrow-left mr-2"></i>Retour
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total soumissions</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total_submissions'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">En attente</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-yellow-600">{{ $stats['pending'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Approuvées</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600">{{ $stats['approved'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Rejetées</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-red-600">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <!-- Informations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-4 sm:mb-6">
        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Informations</h3>
            <div class="space-y-3">
                <div>
                    <span class="text-sm text-gray-600">Type:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($form->form_type) }}
                    </span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Statut:</span>
                    <span class="ml-2 px-2 py-1 text-xs font-semibold rounded-full {{ $form->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $form->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                @if($form->event)
                    <div>
                        <span class="text-sm text-gray-600">Événement:</span>
                        <span class="ml-2">{{ $form->event->title }}</span>
                    </div>
                @endif
                <div>
                    <span class="text-sm text-gray-600">Approbation requise:</span>
                    <span class="ml-2">{{ $form->requires_approval ? 'Oui' : 'Non' }}</span>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Lien public:</span>
                    <div class="mt-1 flex items-center gap-2">
                        <input type="text" readonly value="{{ url('/form/' . $form->slug) }}" id="formLink" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-xs sm:text-sm min-h-[44px]">
                        <button onclick="copyLink()" class="bg-indigo-600 text-white px-4 py-2.5 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition text-sm font-medium min-h-[44px] min-w-[44px] flex items-center justify-center">
                            <i class="fas fa-copy"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 sm:p-6">
            <h3 class="text-base sm:text-lg font-bold text-gray-800 mb-3 sm:mb-4">Aperçu du formulaire</h3>
            <div class="space-y-4">
                @foreach($form->fields as $field)
                    <div class="border border-gray-200 rounded-lg p-3">
                        <div class="flex items-center justify-between">
                            <span class="font-semibold text-gray-800">{{ $field['label'] ?? 'Champ' }}</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-600">
                                {{ ucfirst($field['type'] ?? 'text') }}
                            </span>
                        </div>
                        @if(isset($field['required']) && $field['required'])
                            <span class="text-xs text-red-600 mt-1">* Obligatoire</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function copyLink() {
    const input = document.getElementById('formLink');
    input.select();
    input.setSelectionRange(0, 99999); // Pour mobile
    document.execCommand('copy');
    alert('Lien copié dans le presse-papiers !');
}
</script>
@endpush
@endsection

