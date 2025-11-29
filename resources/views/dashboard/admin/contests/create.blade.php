@extends('layouts.admin')

@section('title', 'Créer un Concours')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Concours</h1>
        <a href="{{ route('admin.contests.index') }}" class="text-red-600 hover:text-red-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('admin.contests.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <!-- Organisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Organisateur *</label>
                    <select name="organizer_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Sélectionner un organisateur</option>
                        @foreach($organizers as $organizer)
                            <option value="{{ $organizer->id }}" {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                                {{ $organizer->name }} ({{ $organizer->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('organizer_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du concours *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('description') }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Règles du concours</label>
                            <textarea name="rules" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">{{ old('rules') }}</textarea>
                            @error('rules')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Paramètres de vote -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Paramètres de vote</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix par vote (XOF) *</label>
                            <input type="number" name="price_per_vote" value="{{ old('price_per_vote') }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('price_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points par vote *</label>
                            <input type="number" name="points_per_vote" value="{{ old('points_per_vote', 1) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('points_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Événement associé -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événement associé (optionnel)</label>
                    <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="">Aucun événement</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }} - {{ $event->organizer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Statut -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Statut</h2>
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm text-gray-700">Publier immédiatement</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                            <span class="text-sm text-gray-700">Actif</span>
                        </label>
                    </div>
                </div>

                <!-- Candidats -->
                <div class="bg-red-50 border-2 border-red-200 rounded-lg p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                                <i class="fas fa-users text-red-600 mr-2"></i>
                                Candidats / Candidates
                            </h2>
                            <p class="text-sm text-gray-600 mt-1">Ajoutez les candidats qui participeront à ce concours</p>
                        </div>
                        <button type="button" id="addCandidateBtn" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-semibold shadow-md">
                            <i class="fas fa-plus mr-2"></i>Ajouter un candidat
                        </button>
                    </div>
                    
                    <div id="candidatesContainer" class="space-y-4">
                        <!-- Les candidats seront ajoutés ici dynamiquement -->
                    </div>
                    
                    <div id="noCandidatesMessage" class="text-center py-8 text-gray-500">
                        <i class="fas fa-user-plus text-4xl mb-3 text-gray-300"></i>
                        <p class="text-sm">Aucun candidat ajouté pour le moment. Cliquez sur "Ajouter un candidat" pour commencer.</p>
                    </div>
                    
                    @error('candidates')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                    @error('candidates.*')<p class="text-red-500 text-sm mt-2">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-red-600 text-white px-8 py-3 rounded-lg hover:bg-red-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Créer le concours
                </button>
                <a href="{{ route('admin.contests.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let candidateIndex = 0;

document.getElementById('addCandidateBtn').addEventListener('click', function() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    
    if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
    
    const candidateHtml = `
        <div class="candidate-item border-2 border-red-200 rounded-lg p-5 bg-white shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-red-700 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    Candidat #<span class="candidate-number">${candidateIndex + 1}</span>
                </h3>
                <button type="button" class="removeCandidateBtn text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-1 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="candidates[${candidateIndex}][name]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro *</label>
                    <input type="number" name="candidates[${candidateIndex}][number]" value="${candidateIndex + 1}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo (optionnel)</label>
                    <input type="file" name="candidates[${candidateIndex}][photo]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 text-sm">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description / Biographie</label>
                <textarea name="candidates[${candidateIndex}][description]" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', candidateHtml);
    candidateIndex++;
    updateCandidateNumbers();
    updateNoCandidatesMessage();
    
    const newItem = container.lastElementChild;
    const removeBtn = newItem.querySelector('.removeCandidateBtn');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            this.closest('.candidate-item').remove();
            updateCandidateNumbers();
            updateNoCandidatesMessage();
        });
    }
});

function updateCandidateNumbers() {
    const items = document.querySelectorAll('.candidate-item');
    items.forEach((item, index) => {
        const numberSpan = item.querySelector('.candidate-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
        const numberInput = item.querySelector('input[name*="[number]"]');
        if (numberInput) {
            numberInput.value = index + 1;
        }
    });
}

function updateNoCandidatesMessage() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    const items = container.querySelectorAll('.candidate-item');
    
    if (items.length === 0 && noCandidatesMessage) {
        noCandidatesMessage.style.display = 'block';
    } else if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
}

document.addEventListener('click', function(e) {
    if (e.target.closest('.removeCandidateBtn')) {
        e.target.closest('.candidate-item').remove();
        updateCandidateNumbers();
        updateNoCandidatesMessage();
    }
});
</script>
@endpush
@endsection

