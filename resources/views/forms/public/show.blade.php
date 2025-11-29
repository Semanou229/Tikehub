@extends('layouts.app')

@section('title', $form->name)

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-8">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $form->name }}</h1>
                @if($form->description)
                    <p class="text-gray-600">{{ $form->description }}</p>
                @endif
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Informations du soumissionnaire -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Vos informations</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nom complet *</label>
                            <input type="text" name="submitter_name" value="{{ old('submitter_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('submitter_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                            <input type="email" name="submitter_email" value="{{ old('submitter_email') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('submitter_email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                            <input type="tel" name="submitter_phone" value="{{ old('submitter_phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                            @error('submitter_phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Champs du formulaire -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Formulaire</h3>
                    <div class="space-y-4">
                        @foreach($form->fields as $index => $field)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $field['label'] ?? 'Champ' }}
                                    @if(isset($field['required']) && $field['required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                
                                @if($field['type'] === 'textarea')
                                    <textarea name="field_{{ $index }}" {{ (isset($field['required']) && $field['required']) ? 'required' : '' }} rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('field_' . $index) }}</textarea>
                                @elseif($field['type'] === 'select')
                                    <select name="field_{{ $index }}" {{ (isset($field['required']) && $field['required']) ? 'required' : '' }} class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Sélectionnez...</option>
                                        <!-- Options à ajouter dynamiquement si nécessaire -->
                                    </select>
                                @elseif($field['type'] === 'checkbox')
                                    <label class="flex items-center">
                                        <input type="checkbox" name="field_{{ $index }}" value="1" {{ (isset($field['required']) && $field['required']) ? 'required' : '' }} class="mr-2">
                                        <span class="text-sm text-gray-700">Oui</span>
                                    </label>
                                @elseif($field['type'] === 'file')
                                    <input type="file" name="field_{{ $index }}" {{ (isset($field['required']) && $field['required']) ? 'required' : '' }} class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                @else
                                    <input type="{{ $field['type'] === 'email' ? 'email' : ($field['type'] === 'phone' ? 'tel' : 'text') }}" 
                                           name="field_{{ $index }}" 
                                           value="{{ old('field_' . $index) }}"
                                           {{ (isset($field['required']) && $field['required']) ? 'required' : '' }}
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                                @endif
                                
                                @error('field_' . $index)
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                        <i class="fas fa-paper-plane mr-2"></i>Soumettre
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


