@extends('layouts.admin')

@section('title', 'Paramètres de la Plateforme')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Paramètres de la Plateforme</h1>
        <p class="text-gray-600 mt-2">Gérez les paramètres généraux de la plateforme</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
            <p class="text-green-800">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <p class="text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @foreach($settings as $group => $groupSettings)
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-600 capitalize">
                    {{ str_replace('_', ' ', $group) }}
                </h2>
                
                <div class="space-y-4">
                    @foreach($groupSettings as $setting)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                {{ $setting->description ?? ucfirst(str_replace('_', ' ', $setting->key)) }}
                            </label>
                            
                            @if($setting->type === 'boolean')
                                <label class="flex items-center">
                                    <input type="checkbox" name="settings[{{ $setting->key }}]" value="1" 
                                        {{ $setting->value == '1' ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">Activer</span>
                                </label>
                            @elseif($setting->type === 'json')
                                <textarea name="settings[{{ $setting->key }}]" rows="4" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ is_string($setting->value) ? $setting->value : json_encode($setting->value) }}</textarea>
                            @elseif($setting->type === 'integer' || $setting->type === 'float')
                                <input type="number" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" 
                                    step="{{ $setting->type === 'float' ? '0.01' : '1' }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @else
                                <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            @endif
                            
                            <p class="text-xs text-gray-500 mt-1">Type: {{ $setting->type }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end">
            <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                <i class="fas fa-save mr-2"></i>Enregistrer les paramètres
            </button>
        </div>
    </form>
</div>
@endsection

