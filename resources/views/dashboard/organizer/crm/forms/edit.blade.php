@extends('layouts.dashboard')

@section('title', 'Modifier Formulaire')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Formulaire</h1>
        <a href="{{ route('organizer.crm.forms.show', $form) }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.crm.forms.update', $form) }}" method="POST" id="formForm">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom du formulaire *</label>
                    <input type="text" name="name" value="{{ old('name', $form->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description', $form->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de formulaire *</label>
                    <select name="form_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="press" {{ old('form_type', $form->form_type) == 'press' ? 'selected' : '' }}>Presse</option>
                        <option value="exhibitor" {{ old('form_type', $form->form_type) == 'exhibitor' ? 'selected' : '' }}>Exposant</option>
                        <option value="volunteer" {{ old('form_type', $form->form_type) == 'volunteer' ? 'selected' : '' }}>Bénévole</option>
                        <option value="vip" {{ old('form_type', $form->form_type) == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="custom" {{ old('form_type', $form->form_type) == 'custom' ? 'selected' : '' }}>Personnalisé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événement</label>
                    <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Formulaire général</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id', $form->event_id) == $event->id ? 'selected' : '' }}>{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="requires_approval" value="1" {{ old('requires_approval', $form->requires_approval) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm text-gray-700">Nécessite une approbation</span>
                    </label>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $form->is_active) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm text-gray-700">Activer ce formulaire</span>
                    </label>
                </div>
            </div>

            <!-- Champs du formulaire -->
            <div class="mt-8">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">Champs du formulaire</h3>
                    <button type="button" onclick="addField()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                        <i class="fas fa-plus mr-1"></i>Ajouter un champ
                    </button>
                </div>
                <div id="fieldsContainer" class="space-y-4">
                    @foreach(old('fields', $form->fields ?? []) as $index => $field)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200" data-field-index="{{ $index }}">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de champ</label>
                                    <select name="fields[{{ $index }}][type]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="text" {{ ($field['type'] ?? 'text') == 'text' ? 'selected' : '' }}>Texte</option>
                                        <option value="email" {{ ($field['type'] ?? '') == 'email' ? 'selected' : '' }}>Email</option>
                                        <option value="phone" {{ ($field['type'] ?? '') == 'phone' ? 'selected' : '' }}>Téléphone</option>
                                        <option value="textarea" {{ ($field['type'] ?? '') == 'textarea' ? 'selected' : '' }}>Zone de texte</option>
                                        <option value="select" {{ ($field['type'] ?? '') == 'select' ? 'selected' : '' }}>Liste déroulante</option>
                                        <option value="checkbox" {{ ($field['type'] ?? '') == 'checkbox' ? 'selected' : '' }}>Case à cocher</option>
                                        <option value="file" {{ ($field['type'] ?? '') == 'file' ? 'selected' : '' }}>Fichier</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Label *</label>
                                    <input type="text" name="fields[{{ $index }}][label]" value="{{ $field['label'] ?? '' }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                </div>
                                <div class="flex items-end">
                                    <label class="flex items-center">
                                        <input type="checkbox" name="fields[{{ $index }}][required]" value="1" {{ ($field['required'] ?? false) ? 'checked' : '' }} class="mr-2">
                                        <span class="text-sm text-gray-700">Obligatoire</span>
                                    </label>
                                    <button type="button" onclick="removeField({{ $index }})" class="ml-auto text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="{{ route('organizer.crm.forms.show', $form) }}" class="text-gray-600 hover:text-gray-800 px-8 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
let fieldIndex = {{ count(old('fields', $form->fields ?? [])) }};

function addField() {
    const container = document.getElementById('fieldsContainer');
    const fieldHtml = `
        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200" data-field-index="${fieldIndex}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de champ</label>
                    <select name="fields[${fieldIndex}][type]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="text">Texte</option>
                        <option value="email">Email</option>
                        <option value="phone">Téléphone</option>
                        <option value="textarea">Zone de texte</option>
                        <option value="select">Liste déroulante</option>
                        <option value="checkbox">Case à cocher</option>
                        <option value="file">Fichier</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Label *</label>
                    <input type="text" name="fields[${fieldIndex}][label]" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>
                <div class="flex items-end">
                    <label class="flex items-center">
                        <input type="checkbox" name="fields[${fieldIndex}][required]" value="1" class="mr-2">
                        <span class="text-sm text-gray-700">Obligatoire</span>
                    </label>
                    <button type="button" onclick="removeField(${fieldIndex})" class="ml-auto text-red-600 hover:text-red-900">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', fieldHtml);
    fieldIndex++;
}

function removeField(index) {
    const field = document.querySelector(`[data-field-index="${index}"]`);
    if (field) {
        field.remove();
    }
}
</script>
@endpush
@endsection


