@extends('layouts.admin')

@section('title', 'Créer une FAQ')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer une FAQ</h1>
    </div>

    <form action="{{ route('admin.faqs.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="question" class="block text-sm font-semibold text-gray-700 mb-2">Question *</label>
                <input type="text" name="question" id="question" required value="{{ old('question') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                @error('question')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="answer" class="block text-sm font-semibold text-gray-700 mb-2">Réponse *</label>
                <textarea name="answer" id="answer" rows="6" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('answer') }}</textarea>
                @error('answer')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                <input type="text" name="category" id="category" value="{{ old('category') }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none"
                       placeholder="Ex: Général, Paiements, Événements...">
                <p class="text-sm text-gray-500 mt-1">Laissez vide pour "Général"</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Ordre d'affichage</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-gray-700">Active</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.faqs.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                Annuler
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-save mr-2"></i>Créer
            </button>
        </div>
    </form>
</div>
@endsection

