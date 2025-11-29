@extends('layouts.dashboard')

@section('title', 'Formulaires')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Formulaires Personnalisés</h1>
            <p class="text-gray-600 mt-1">Créez des formulaires pour collecter des informations</p>
        </div>
        <a href="{{ route('organizer.crm.forms.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouveau formulaire
        </a>
    </div>

    <!-- Liste des formulaires -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($forms as $form)
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ $form->name }}</h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $form->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $form->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>
                @if($form->description)
                    <p class="text-gray-600 text-sm mb-4">{{ Str::limit($form->description, 100) }}</p>
                @endif
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-file-alt mr-1"></i>{{ $form->submissions_count }} soumissions
                    </div>
                    <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                        {{ ucfirst($form->form_type) }}
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('organizer.crm.forms.show', $form) }}" class="flex-1 text-center bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition text-sm">
                        <i class="fas fa-eye mr-1"></i>Voir
                    </a>
                    <a href="{{ route('organizer.crm.forms.edit', $form) }}" class="text-gray-600 hover:text-gray-900 px-4 py-2">
                        <i class="fas fa-edit"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="md:col-span-3 bg-white rounded-lg shadow-md p-12 text-center">
                <i class="fas fa-file-alt text-4xl mb-3 text-gray-300"></i>
                <p class="text-gray-500 mb-4">Aucun formulaire créé</p>
                <a href="{{ route('organizer.crm.forms.create') }}" class="text-indigo-600 hover:text-indigo-800">
                    Créer votre premier formulaire
                </a>
            </div>
        @endforelse
    </div>

    @if($forms->hasPages())
        <div class="mt-4">
            {{ $forms->links() }}
        </div>
    @endif
</div>
@endsection


