@extends('layouts.dashboard')

@section('title', 'Nouveau Contact')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Nouveau Contact</h1>
        <a href="{{ route('organizer.crm.contacts.index') }}" class="text-indigo-600 hover:text-indigo-800">
            <i class="fas fa-arrow-left mr-2"></i>Retour
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.crm.contacts.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prénom *</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('first_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nom *</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('last_name')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Téléphone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                    @error('phone')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Entreprise</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Poste</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catégorie *</label>
                    <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="participant" {{ old('category') == 'participant' ? 'selected' : '' }}>Participant</option>
                        <option value="sponsor" {{ old('category') == 'sponsor' ? 'selected' : '' }}>Sponsor</option>
                        <option value="staff" {{ old('category') == 'staff' ? 'selected' : '' }}>Staff</option>
                        <option value="press" {{ old('category') == 'press' ? 'selected' : '' }}>Presse</option>
                        <option value="vip" {{ old('category') == 'vip' ? 'selected' : '' }}>VIP</option>
                        <option value="partner" {{ old('category') == 'partner' ? 'selected' : '' }}>Partenaire</option>
                        <option value="prospect" {{ old('category') == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pipeline *</label>
                    <select name="pipeline_stage" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="prospect" {{ old('pipeline_stage') == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="confirmed" {{ old('pipeline_stage') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                        <option value="partner" {{ old('pipeline_stage') == 'partner' ? 'selected' : '' }}>Partenaire</option>
                        <option value="closed" {{ old('pipeline_stage') == 'closed' ? 'selected' : '' }}>Clôturé</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Assigné à</label>
                    <select name="assigned_to" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">
                        <option value="">Non assigné</option>
                        @foreach($teamMembers as $member)
                            <option value="{{ $member->id }}" {{ old('assigned_to') == $member->id ? 'selected' : '' }}>{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Étiquettes</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($tags as $tag)
                            <label class="flex items-center px-3 py-1 rounded-full border border-gray-300 cursor-pointer hover:bg-gray-50">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="mr-2">
                                <span class="text-sm" style="color: {{ $tag->color }}">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                    <textarea name="notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="mt-8 flex gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-8 py-3 rounded-lg hover:bg-indigo-700 transition font-semibold">
                    <i class="fas fa-save mr-2"></i>Créer le contact
                </button>
                <a href="{{ route('organizer.crm.contacts.index') }}" class="text-gray-600 hover:text-gray-800 px-8 py-3">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

