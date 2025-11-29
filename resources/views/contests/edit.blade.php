@extends('layouts.dashboard')

@section('title', 'Modifier un Concours')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier le Concours</h1>
        <a href="{{ route('organizer.contests.index') }}" class="text-purple-600 hover:text-purple-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('contests.update', $contest) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <!-- Informations de base -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Informations de base</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom du concours *</label>
                            <input type="text" name="name" value="{{ old('name', $contest->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Ex: Miss Bénin 2025">
                            @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                            <textarea name="description" rows="5" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Décrivez votre concours...">{{ old('description', $contest->description) }}</textarea>
                            @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Règles du concours</label>
                            <textarea name="rules" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Règles et conditions de participation...">{{ old('rules', $contest->rules) }}</textarea>
                            @error('rules')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Image de couverture</label>
                            @if($contest->cover_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($contest->cover_image) }}" alt="Couverture actuelle" class="w-32 h-32 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="cover_image" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('cover_image')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
                        </div>
                    </div>
                </div>

                <!-- Paramètres de vote -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Paramètres de vote</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Prix par vote (XOF) *</label>
                            <input type="number" name="price_per_vote" value="{{ old('price_per_vote', $contest->price_per_vote) }}" min="0" step="0.01" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="100">
                            @error('price_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Points par vote *</label>
                            <input type="number" name="points_per_vote" value="{{ old('points_per_vote', $contest->points_per_vote) }}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="1">
                            @error('points_per_vote')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                            <p class="text-sm text-gray-500 mt-1">Nombre de points attribués par vote</p>
                        </div>
                    </div>
                </div>

                <!-- Dates -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Dates</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de début *</label>
                            <input type="datetime-local" name="start_date" value="{{ old('start_date', $contest->start_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin *</label>
                            <input type="datetime-local" name="end_date" value="{{ old('end_date', $contest->end_date->format('Y-m-d\TH:i')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Événement associé (optionnel) -->
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Événement associé (optionnel)</h2>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lier à un événement</label>
                        <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Aucun événement</option>
                            @foreach($events as $event)
                                <option value="{{ $event->id }}" {{ old('event_id', $contest->event_id) == $event->id ? 'selected' : '' }}>
                                    {{ $event->title }} ({{ $event->start_date->format('d/m/Y') }})
                                </option>
                            @endforeach
                        </select>
                        @error('event_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        <p class="text-sm text-gray-500 mt-1">Vous pouvez associer ce concours à un événement existant</p>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex items-center gap-4">
                <button type="submit" class="bg-purple-600 text-white px-8 py-3 rounded-lg hover:bg-purple-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                </button>
                <a href="{{ route('organizer.contests.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>

@push('scripts')
<script>
let candidateIndex = {{ $contest->candidates->max('number') ?? 0 }};

document.getElementById('addCandidateBtn').addEventListener('click', function() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    
    // Masquer le message "aucun candidat"
    if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
    
    candidateIndex++;
    const candidateHtml = `
        <div class="candidate-item border-2 border-purple-200 rounded-lg p-5 bg-white shadow-sm hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-purple-700 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    Nouveau Candidat #<span class="candidate-number">${candidateIndex}</span>
                </h3>
                <button type="button" class="removeCandidateBtn text-red-600 hover:text-red-800 hover:bg-red-50 px-3 py-1 rounded-lg transition text-sm font-medium">
                    <i class="fas fa-trash mr-1"></i> Supprimer
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                    <input type="text" name="candidates[${candidateIndex}][name]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Ex: Amina Diallo">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Numéro *</label>
                    <input type="number" name="candidates[${candidateIndex}][number]" value="${candidateIndex}" min="1" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Photo (optionnel)</label>
                    <input type="file" name="candidates[${candidateIndex}][photo]" accept="image/*" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 text-sm">
                    <p class="text-xs text-gray-500 mt-1">JPG, PNG (max 2MB)</p>
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description / Biographie</label>
                <textarea name="candidates[${candidateIndex}][description]" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500" placeholder="Courte description ou biographie du candidat..."></textarea>
                <p class="text-xs text-gray-500 mt-1">Cette description sera visible sur la page publique du concours</p>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', candidateHtml);
    updateCandidateNumbers();
    updateNoCandidatesMessage();
    
    // Ajouter l'événement de suppression
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
    const items = document.querySelectorAll('#candidatesContainer .candidate-item');
    let currentNumber = {{ $contest->candidates->max('number') ?? 0 }};
    items.forEach((item) => {
        currentNumber++;
        const numberSpan = item.querySelector('.candidate-number');
        if (numberSpan) {
            numberSpan.textContent = currentNumber;
        }
        const numberInput = item.querySelector('input[name*="[number]"]');
        if (numberInput) {
            // Mettre à jour l'index dans le name pour éviter les conflits
            const oldName = numberInput.name;
            const newName = oldName.replace(/candidates\[\d+\]/, `candidates[${currentNumber}]`);
            numberInput.name = newName;
            numberInput.value = currentNumber;
            
            // Mettre à jour tous les autres champs du même candidat
            const candidateItem = item;
            candidateItem.querySelectorAll('input, textarea').forEach(input => {
                if (input.name && input.name.includes('[name]')) {
                    input.name = input.name.replace(/candidates\[\d+\]/, `candidates[${currentNumber}]`);
                } else if (input.name && input.name.includes('[description]')) {
                    input.name = input.name.replace(/candidates\[\d+\]/, `candidates[${currentNumber}]`);
                } else if (input.name && input.name.includes('[photo]')) {
                    input.name = input.name.replace(/candidates\[\d+\]/, `candidates[${currentNumber}]`);
                }
            });
        }
    });
}

function updateNoCandidatesMessage() {
    const container = document.getElementById('candidatesContainer');
    const noCandidatesMessage = document.getElementById('noCandidatesMessage');
    const items = container.querySelectorAll('.candidate-item');
    const existingCount = {{ $contest->candidates->count() }};
    
    if (items.length === 0 && existingCount === 0 && noCandidatesMessage) {
        noCandidatesMessage.style.display = 'block';
    } else if (noCandidatesMessage) {
        noCandidatesMessage.style.display = 'none';
    }
}

// Permettre la suppression des candidats
document.addEventListener('click', function(e) {
    if (e.target.closest('.removeCandidateBtn')) {
        e.target.closest('.candidate-item').remove();
        updateCandidateNumbers();
        updateNoCandidatesMessage();
    }
});
</script>
@endpush

    <!-- Section candidats -->
    <div class="mt-6 bg-purple-50 border-2 border-purple-200 rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-users text-purple-600 mr-2"></i>
                    Candidats ({{ $contest->candidates->count() }})
                </h2>
                <p class="text-sm text-gray-600 mt-1">Gérez les candidats de ce concours</p>
            </div>
            <button type="button" id="addCandidateBtn" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-semibold shadow-md">
                <i class="fas fa-plus mr-2"></i>Ajouter un candidat
            </button>
        </div>

        <!-- Candidats existants -->
        @if($contest->candidates->count() > 0)
            <div class="mb-6">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Candidats existants</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($contest->candidates as $candidate)
                        <div class="border-2 border-purple-200 rounded-lg p-4 bg-white">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-semibold text-purple-600">#{{ $candidate->number }}</span>
                                <span class="text-xs text-gray-500">{{ $candidate->votes()->sum('points') }} points</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $candidate->name }}</h3>
                            @if($candidate->description)
                                <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($candidate->description, 60) }}</p>
                            @endif
                            @if($candidate->photo)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($candidate->photo) }}" alt="{{ $candidate->name }}" class="w-16 h-16 object-cover rounded-lg">
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Formulaire d'ajout de nouveaux candidats -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
            <div class="flex items-start">
                <i class="fas fa-exclamation-triangle text-yellow-600 mt-1 mr-2"></i>
                <p class="text-sm text-yellow-800">
                    <strong>Note :</strong> Les nouveaux candidats ajoutés ici seront enregistrés avec les modifications du concours. 
                    Vous devez enregistrer les modifications pour que les candidats soient créés.
                </p>
            </div>
        </div>

        <div id="candidatesContainer" class="space-y-4">
            <!-- Les nouveaux candidats seront ajoutés ici dynamiquement -->
        </div>
        
        <div id="noCandidatesMessage" class="text-center py-8 text-gray-500" style="{{ $contest->candidates->count() > 0 ? 'display: none;' : '' }}">
            <i class="fas fa-user-plus text-4xl mb-3 text-gray-300"></i>
            <p class="text-sm">Aucun candidat ajouté pour le moment. Cliquez sur "Ajouter un candidat" pour commencer.</p>
        </div>
    </div>
</div>
@endsection

