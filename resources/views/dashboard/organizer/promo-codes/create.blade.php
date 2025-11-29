@extends('layouts.dashboard')

@section('title', 'Créer un code promo')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('organizer.promo-codes.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Créer un code promo</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.promo-codes.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Code -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Code promo *</label>
                    <input type="text" name="code" value="{{ old('code') }}" required 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Ex: PROMO2024" maxlength="50">
                    <p class="text-xs text-gray-500 mt-1">Le code sera automatiquement converti en majuscules</p>
                    @error('code')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Nom -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom (optionnel)</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Ex: Réduction été 2024">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Événement -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événement (optionnel)</label>
                    <select name="event_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les événements</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('event_id')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description (optionnel)</label>
                    <textarea name="description" rows="3" 
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                              placeholder="Description du code promo...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Type de réduction -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de réduction *</label>
                    <select name="discount_type" id="discount_type" required 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="percentage" {{ old('discount_type', 'percentage') == 'percentage' ? 'selected' : '' }}>Pourcentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Montant fixe (XOF)</option>
                    </select>
                    @error('discount_type')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Valeur de la réduction -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Valeur de la réduction *</label>
                    <div class="flex items-center">
                        <input type="number" name="discount_value" value="{{ old('discount_value') }}" required step="0.01" min="0.01"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                               placeholder="10" id="discount_value">
                        <span class="ml-2 text-gray-600" id="discount_unit">%</span>
                    </div>
                    @error('discount_value')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Montant minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Montant minimum (optionnel)</label>
                    <input type="number" name="minimum_amount" value="{{ old('minimum_amount') }}" step="0.01" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Montant minimum d'achat pour utiliser le code</p>
                    @error('minimum_amount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Réduction maximum (pour pourcentage) -->
                <div id="max_discount_container">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Réduction maximum (optionnel)</label>
                    <input type="number" name="maximum_discount" value="{{ old('maximum_discount') }}" step="0.01" min="0"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="0">
                    <p class="text-xs text-gray-500 mt-1">Limite la réduction pour les codes en pourcentage</p>
                    @error('maximum_discount')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Limite d'utilisation -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Limite d'utilisation totale (optionnel)</label>
                    <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="100">
                    <p class="text-xs text-gray-500 mt-1">Nombre maximum d'utilisations du code</p>
                    @error('usage_limit')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Limite par utilisateur -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Limite par utilisateur (optionnel)</label>
                    <input type="number" name="usage_limit_per_user" value="{{ old('usage_limit_per_user') }}" min="1"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="1">
                    <p class="text-xs text-gray-500 mt-1">Nombre maximum d'utilisations par utilisateur</p>
                    @error('usage_limit_per_user')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Date de début -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de début (optionnel)</label>
                    <input type="datetime-local" name="start_date" value="{{ old('start_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('start_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date de fin (optionnel)</label>
                    <input type="datetime-local" name="end_date" value="{{ old('end_date') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('end_date')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <!-- Actif -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="mr-2 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700">Code promo actif</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-4">
                <a href="{{ route('organizer.promo-codes.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    Annuler
                </a>
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-save mr-2"></i>Créer le code promo
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('discount_type').addEventListener('change', function() {
    const unit = this.value === 'percentage' ? '%' : 'XOF';
    document.getElementById('discount_unit').textContent = unit;
    
    const maxDiscountContainer = document.getElementById('max_discount_container');
    if (this.value === 'percentage') {
        maxDiscountContainer.style.display = 'block';
    } else {
        maxDiscountContainer.style.display = 'none';
    }
});
</script>
@endpush
@endsection


