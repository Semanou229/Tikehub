@extends('layouts.dashboard')

@section('title', 'Nouvelle Demande de Sous-domaine')

@section('content')
<div class="p-4 sm:p-6">
    <!-- Header -->
    <div class="mb-6">
        <a href="{{ route('organizer.subdomain-requests.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4 transition">
            <i class="fas fa-arrow-left mr-2"></i>
            <span class="font-medium">Retour</span>
        </a>
        <div class="flex items-center space-x-3 mb-2">
            <div class="bg-gradient-to-br from-indigo-500 to-purple-600 p-3 rounded-xl shadow-lg">
                <i class="fas fa-globe text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Nouvelle Demande de Sous-domaine</h1>
                <p class="text-gray-600 mt-1">Créez une adresse personnalisée pour votre contenu</p>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-lg shadow-sm">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                <div class="flex-1">
                    <h3 class="text-red-800 font-semibold mb-2">Erreurs de validation</h3>
                    <ul class="list-disc list-inside text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('organizer.subdomain-requests.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Card principale -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center">
                    <i class="fas fa-file-alt mr-2"></i>
                    Informations de la demande
                </h2>
            </div>
            
            <div class="p-6 space-y-6">
                <!-- Type de contenu -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-tag text-indigo-600 mr-2"></i>
                        Type de contenu <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="content_type" value="event" 
                                {{ old('content_type', $contentType) === 'event' ? 'checked' : '' }}
                                class="peer sr-only" required>
                            <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-indigo-300 peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-alt text-2xl text-indigo-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Événement</div>
                                        <div class="text-xs text-gray-500">Pour vos événements</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="content_type" value="contest" 
                                {{ old('content_type', $contentType) === 'contest' ? 'checked' : '' }}
                                class="peer sr-only" required>
                            <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-purple-300 peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                <div class="flex items-center">
                                    <i class="fas fa-trophy text-2xl text-purple-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Concours</div>
                                        <div class="text-xs text-gray-500">Pour vos concours</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="content_type" value="fundraising" 
                                {{ old('content_type', $contentType) === 'fundraising' ? 'checked' : '' }}
                                class="peer sr-only" required>
                            <div class="border-2 border-gray-200 rounded-xl p-4 hover:border-green-300 peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                <div class="flex items-center">
                                    <i class="fas fa-heart text-2xl text-green-600 mr-3"></i>
                                    <div>
                                        <div class="font-semibold text-gray-900">Collecte</div>
                                        <div class="text-xs text-gray-500">Pour vos collectes</div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Sélection du contenu -->
                <div id="content_id_container">
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-list text-indigo-600 mr-2"></i>
                        Sélectionnez le contenu <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="relative">
                        <select name="content_id" id="content_id" 
                            class="w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-3 text-gray-900 bg-white transition-all appearance-none cursor-pointer" 
                            required>
                            <option value="">Sélectionnez d'abord un type</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none">
                            <i class="fas fa-chevron-down text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Sous-domaine -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-link text-indigo-600 mr-2"></i>
                        Sous-domaine demandé <span class="text-red-500 ml-1">*</span>
                    </label>
                    <div class="flex items-center">
                        <div class="flex-1 relative">
                            <input type="text" name="requested_subdomain" id="requested_subdomain" 
                                value="{{ old('requested_subdomain') }}" 
                                class="w-full rounded-l-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-3 text-gray-900 placeholder-gray-400 transition-all" 
                                placeholder="mon-evenement" 
                                pattern="[a-z0-9-]+" 
                                minlength="3" 
                                maxlength="50"
                                required>
                        </div>
                        <div class="px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-50 border-2 border-l-0 border-gray-200 rounded-r-lg text-gray-700 font-mono text-sm">
                            .{{ parse_url(config('app.url'), PHP_URL_HOST) }}
                        </div>
                    </div>
                    <div class="mt-2 flex items-start text-sm text-gray-600 bg-gray-50 rounded-lg p-3">
                        <i class="fas fa-info-circle text-indigo-500 mr-2 mt-0.5"></i>
                        <div>
                            <p class="font-medium mb-1">Règles de nommage :</p>
                            <ul class="list-disc list-inside space-y-1 text-xs">
                                <li>Utilisez uniquement des lettres minuscules, des chiffres et des tirets</li>
                                <li>Minimum 3 caractères, maximum 50 caractères</li>
                                <li>Exemple : <code class="bg-white px-1 rounded">mon-evenement-2025</code></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Raison -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                        <i class="fas fa-comment-alt text-indigo-600 mr-2"></i>
                        Raison de la demande <span class="text-gray-400 text-xs font-normal ml-2">(optionnel)</span>
                    </label>
                    <textarea name="reason" id="reason" rows="5" 
                        class="w-full rounded-lg border-2 border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 px-4 py-3 text-gray-900 placeholder-gray-400 transition-all resize-none"
                        placeholder="Expliquez pourquoi vous avez besoin de ce sous-domaine personnalisé... (ex: pour une meilleure visibilité, pour un événement important, etc.)">{{ old('reason') }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        <i class="fas fa-lightbulb mr-1"></i>
                        Cette information aidera l'administrateur à mieux comprendre votre demande
                    </p>
                </div>
            </div>
        </div>

        <!-- Note informative -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-5 shadow-sm">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-500 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-blue-900 font-semibold mb-2 flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        Processus de validation
                    </h3>
                    <p class="text-blue-800 text-sm leading-relaxed">
                        Après soumission de votre demande, un administrateur examinera votre requête. 
                        Une fois approuvée, le sous-domaine sera créé manuellement sur notre serveur. 
                        Vous recevrez une notification par email dès que votre sous-domaine sera actif et prêt à l'emploi.
                    </p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 border-t border-gray-200">
            <a href="{{ route('organizer.subdomain-requests.index') }}" 
                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-all">
                <i class="fas fa-times mr-2"></i>
                Annuler
            </a>
            <button type="submit" 
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-paper-plane mr-2"></i>
                Soumettre la demande
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contentTypeRadios = document.querySelectorAll('input[name="content_type"]');
    const contentIdSelect = document.getElementById('content_id');
    
    const events = @json($events);
    const contests = @json($contests);
    const fundraisings = @json($fundraisings);
    const preselectedContentId = @json($contentId ?? null);
    const preselectedContentType = @json($contentType ?? null);

    function updateContentOptions() {
        const selectedRadio = document.querySelector('input[name="content_type"]:checked');
        if (!selectedRadio) {
            contentIdSelect.innerHTML = '<option value="">Sélectionnez d\'abord un type</option>';
            contentIdSelect.disabled = true;
            return;
        }

        const contentType = selectedRadio.value;
        contentIdSelect.innerHTML = '<option value="">Sélectionnez un contenu</option>';
        contentIdSelect.disabled = false;

        let items = [];
        if (contentType === 'event') {
            items = events;
        } else if (contentType === 'contest') {
            items = contests;
        } else if (contentType === 'fundraising') {
            items = fundraisings;
        }

        if (items.length === 0) {
            contentIdSelect.innerHTML = '<option value="">Aucun contenu disponible</option>';
            contentIdSelect.disabled = true;
            return;
        }

        items.forEach(item => {
            const option = document.createElement('option');
            option.value = item.id;
            option.textContent = item.title;
            if (preselectedContentId && item.id == preselectedContentId) {
                option.selected = true;
            }
            contentIdSelect.appendChild(option);
        });
    }

    // Écouter les changements sur les radio buttons
    contentTypeRadios.forEach(radio => {
        radio.addEventListener('change', updateContentOptions);
    });
    
    // Initialiser si un type est déjà sélectionné
    if (preselectedContentType) {
        const radio = document.querySelector(`input[name="content_type"][value="${preselectedContentType}"]`);
        if (radio) {
            radio.checked = true;
            updateContentOptions();
        }
    }

    // Validation du sous-domaine en temps réel
    const subdomainInput = document.getElementById('requested_subdomain');
    if (subdomainInput) {
        subdomainInput.addEventListener('input', function() {
            this.value = this.value.toLowerCase().replace(/[^a-z0-9-]/g, '');
        });
    }
});
</script>
@endsection

