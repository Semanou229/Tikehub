@extends('layouts.admin')

@section('title', 'Gestion des Logos')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des Logos</h1>
        <p class="text-gray-600 mt-2">Uploadez et gérez les différents logos du site</p>
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

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($types as $typeKey => $typeConfig)
            @php
                $logo = $logos->where('type', $typeKey)->where('is_active', true)->first();
            @endphp
            
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $typeConfig['name'] }}</h3>
                <p class="text-sm text-gray-600 mb-4">{{ $typeConfig['description'] }}</p>
                
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2">
                        <strong>Dimensions recommandées:</strong> {{ $typeConfig['recommended'] }}
                    </p>
                    @if($typeConfig['width'] && $typeConfig['height'])
                        <p class="text-xs text-gray-500">
                            <strong>Largeur:</strong> {{ $typeConfig['width'] }}px | 
                            <strong>Hauteur:</strong> {{ $typeConfig['height'] }}px
                        </p>
                    @endif
                </div>

                @if($logo)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-green-200">
                        <div class="flex items-center justify-center mb-3">
                            <img src="{{ $logo->url }}" alt="{{ $typeConfig['name'] }}" 
                                 class="max-w-full max-h-24 object-contain">
                        </div>
                        <p class="text-xs text-gray-600 text-center">
                            Logo actif depuis {{ $logo->created_at->format('d/m/Y') }}
                        </p>
                    </div>

                    <form action="{{ route('admin.logos.update', $logo) }}" method="POST" enctype="multipart/form-data" class="mb-2">
                        @csrf
                        @method('PUT')
                        <input type="file" name="logo" accept="image/*" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mb-2">
                        <div class="flex items-center mb-2">
                            <input type="checkbox" name="is_active" id="active_{{ $logo->id }}" 
                                   {{ $logo->is_active ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                            <label for="active_{{ $logo->id }}" class="ml-2 text-sm text-gray-700">Actif</label>
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            Mettre à jour
                        </button>
                    </form>

                    <form action="{{ route('admin.logos.destroy', $logo) }}" method="POST" 
                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce logo ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition text-sm font-medium">
                            Supprimer
                        </button>
                    </form>
                @else
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                        <p class="text-xs text-gray-500 text-center">Aucun logo uploadé</p>
                    </div>

                    <form action="{{ route('admin.logos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="{{ $typeKey }}">
                        <input type="file" name="logo" accept="image/*" required
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mb-2">
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-lg hover:bg-indigo-700 transition text-sm font-medium">
                            Uploader le logo
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection


