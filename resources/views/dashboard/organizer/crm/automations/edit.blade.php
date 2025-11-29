@extends('layouts.dashboard')

@section('title', 'Modifier Automation')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier Automation</h1>
        <a href="{{ route('organizer.crm.automations.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.crm.automations.update', $automation) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de l'automation *</label>
                    <input type="text" name="name" value="{{ old('name', $automation->name) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description', $automation->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de déclencheur *</label>
                    <select name="trigger_type" id="trigger_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @foreach($triggers as $key => $label)
                            <option value="{{ $key }}" {{ old('trigger_type', $automation->trigger_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type d'action *</label>
                    <select name="action_type" id="action_type" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @foreach($actions as $key => $label)
                            <option value="{{ $key }}" {{ old('action_type', $automation->action_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Délai avant exécution (minutes)</label>
                    <input type="number" name="delay_minutes" value="{{ old('delay_minutes', $automation->delay_minutes) }}" min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $automation->is_active) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm text-gray-700">Activer cette automation</span>
                    </label>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Enregistrer
                </button>
                <a href="{{ route('organizer.crm.automations.index') }}" class="text-gray-600 hover:text-gray-800 px-8 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

