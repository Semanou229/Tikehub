@extends('layouts.dashboard')

@section('title', 'Nouvelle Campagne Email')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Nouvelle Campagne Email</h1>
        <a href="{{ route('organizer.crm.campaigns.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.crm.campaigns.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom de la campagne *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Type de template</label>
                    <select name="template_type" id="template_type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        @foreach($templates as $key => $label)
                            <option value="{{ $key }}" {{ old('template_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Segment</label>
                    <select name="segment_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Tous les contacts</option>
                        @foreach($segments as $segment)
                            <option value="{{ $segment->id }}" {{ old('segment_id') == $segment->id ? 'selected' : '' }}>{{ $segment->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sujet *</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('subject')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Contenu *</label>
                    <textarea name="content" id="content" rows="15" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 font-mono text-sm">{{ old('content') }}</textarea>
                    <p class="text-xs text-gray-500 mt-1">Vous pouvez utiliser {{ '{nom}' }}, {{ '{email}' }}, {{ '{evenement}' }} pour personnaliser</p>
                    @error('content')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Programmer l'envoi (optionnel)</label>
                    <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Laissez vide pour sauvegarder en brouillon</p>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Créer la campagne
                </button>
                <a href="{{ route('organizer.crm.campaigns.index') }}" class="text-gray-600 hover:text-gray-800 px-8 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

