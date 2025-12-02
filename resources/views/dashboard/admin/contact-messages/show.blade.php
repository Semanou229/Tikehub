@extends('layouts.admin')

@section('title', 'Message de Contact')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.contact-messages.index') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Message de Contact</h1>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $contactMessage->subject }}</h2>
                    <p class="text-gray-600 mt-1">{{ $contactMessage->created_at->format('d/m/Y à H:i') }}</p>
                </div>
                @if(!$contactMessage->is_read)
                    <form action="{{ route('admin.contact-messages.read', $contactMessage) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            Marquer comme lu
                        </button>
                    </form>
                @else
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Lu</span>
                @endif
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Expéditeur</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="font-semibold text-gray-800">{{ $contactMessage->name }}</p>
                    <a href="mailto:{{ $contactMessage->email }}" class="text-indigo-600 hover:text-indigo-800">
                        {{ $contactMessage->email }}
                    </a>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-2">Message</h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <p class="text-gray-700 whitespace-pre-line">{{ $contactMessage->message }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                    <i class="fas fa-reply mr-2"></i>Répondre
                </a>
                <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-trash mr-2"></i>Supprimer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

