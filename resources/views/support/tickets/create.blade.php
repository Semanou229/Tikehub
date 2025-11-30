@extends('layouts.app')

@section('title', 'Créer un Ticket de Support')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <a href="{{ route('support.tickets.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>Retour aux tickets
        </a>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Créer un Ticket de Support</h1>
        <p class="text-gray-600">Décrivez votre problème et notre équipe vous répondra rapidement</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-8">
        <form method="POST" action="{{ route('support.tickets.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Sujet -->
            <div class="mb-6">
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                    Sujet <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="subject" 
                       name="subject" 
                       value="{{ old('subject') }}"
                       required
                       maxlength="255"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('subject') border-red-500 @enderror"
                       placeholder="Résumez votre problème en quelques mots">
                @error('subject')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Priorité -->
            <div class="mb-6">
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                    Priorité <span class="text-red-500">*</span>
                </label>
                <select id="priority" 
                        name="priority" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('priority') border-red-500 @enderror">
                    <option value="">Sélectionner une priorité</option>
                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Basse - Question générale</option>
                    <option value="medium" {{ old('priority') == 'medium' || !old('priority') ? 'selected' : '' }}>Moyenne - Problème standard</option>
                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Haute - Problème important</option>
                    <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgente - Blocage critique</option>
                </select>
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Choisissez la priorité qui correspond le mieux à votre situation
                </p>
            </div>

            <!-- Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description du problème <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="10"
                          required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror"
                          placeholder="Décrivez votre problème en détail. Plus vous fournissez d'informations, plus nous pourrons vous aider rapidement.">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-sm text-gray-500">
                    <i class="fas fa-lightbulb mr-1"></i>
                    Incluez des détails comme : étapes pour reproduire le problème, messages d'erreur, captures d'écran, etc.
                </p>
            </div>

            <!-- Boutons -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('support.tickets.index') }}" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-times mr-2"></i>Annuler
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                    <i class="fas fa-paper-plane mr-2"></i>Envoyer le ticket
                </button>
            </div>
        </form>
    </div>

    <!-- Info box -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-1">Temps de réponse</p>
                <p>Notre équipe s'engage à répondre à votre ticket dans les délais suivants :</p>
                <ul class="mt-2 ml-4 list-disc">
                    <li><strong>Urgente :</strong> Moins de 2 heures</li>
                    <li><strong>Haute :</strong> Moins de 4 heures</li>
                    <li><strong>Moyenne :</strong> Moins de 24 heures</li>
                    <li><strong>Basse :</strong> Moins de 48 heures</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

