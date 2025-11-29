@extends('layouts.dashboard')

@section('title', 'Assigner un Agent')

@section('content')
<div class="p-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Assigner un Agent</h1>

    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('organizer.agents.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email de l'agent *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="agent@example.com" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    @error('email')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    <p class="text-sm text-gray-500 mt-1">L'utilisateur doit avoir le rôle "agent"</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Événements à assigner *</label>
                    <div class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-4">
                        @foreach($events as $event)
                            <label class="flex items-center">
                                <input type="checkbox" name="event_ids[]" value="{{ $event->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700">{{ $event->title }} ({{ $event->start_date->format('d/m/Y') }})</span>
                            </label>
                        @endforeach
                    </div>
                    @error('event_ids')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-save mr-2"></i>Assigner
                </button>
                <a href="{{ route('organizer.agents.index') }}" class="text-gray-600 hover:text-gray-800">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection


