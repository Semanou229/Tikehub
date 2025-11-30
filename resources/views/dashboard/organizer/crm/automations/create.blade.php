@extends('layouts.dashboard')

@section('title', 'Nouvelle Automation')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Nouvelle Automation</h1>
        <a href="{{ route('organizer.crm.automations.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm sm:text-base min-h-[44px] flex items-center">
            <i class="fas fa-arrow-left text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
        <form action="{{ route('organizer.crm.automations.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Nom de l'automation *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    @error('name')<p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Type de déclencheur *</label>
                    <select name="trigger_type" id="trigger_type" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        @foreach($triggers as $key => $label)
                            <option value="{{ $key }}" {{ old('trigger_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('trigger_type')<p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Type d'action *</label>
                    <select name="action_type" id="action_type" required class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                        @foreach($actions as $key => $label)
                            <option value="{{ $key }}" {{ old('action_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('action_type')<p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1.5 sm:mb-2">Délai avant exécution (minutes)</label>
                    <input type="number" name="delay_minutes" value="{{ old('delay_minutes', 0) }}" min="0" class="w-full px-3 sm:px-4 py-2 text-sm sm:text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 min-h-[44px]">
                    <p class="text-xs text-gray-500 mt-1">Temps d'attente avant d'exécuter l'action</p>
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="mr-2">
                        <span class="text-sm text-gray-700">Activer cette automation immédiatement</span>
                    </label>
                </div>
            </div>

            <div class="mt-6 sm:mt-8 flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 sm:gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-4 sm:px-6 lg:px-8 py-2.5 sm:py-3 rounded-lg hover:bg-indigo-700 active:bg-indigo-800 transition font-semibold text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                    <i class="fas fa-save text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Créer l'automation
                </button>
                <a href="{{ route('organizer.crm.automations.index') }}" class="text-gray-600 hover:text-gray-800 active:text-gray-900 text-center sm:text-left py-2.5 sm:py-0 text-xs sm:text-sm min-h-[40px] sm:min-h-[44px] flex items-center justify-center sm:justify-start">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


