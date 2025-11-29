@extends('layouts.admin')

@section('title', 'Détails du signalement - Administration')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="text-red-600 hover:text-red-800 mb-4 inline-block">
            <i class="fas fa-arrow-left mr-2"></i>Retour à la liste
        </a>
        <h1 class="text-3xl font-bold text-gray-800">Détails du signalement</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informations principales -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informations du signalement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Informations du signalement</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type de contenu</label>
                        <div class="flex items-center gap-2">
                            @if($report->reportable_type === 'App\Models\Event')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                                    <i class="fas fa-calendar-alt mr-1"></i>Événement
                                </span>
                            @elseif($report->reportable_type === 'App\Models\Contest')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-purple-100 text-purple-800">
                                    <i class="fas fa-trophy mr-1"></i>Concours
                                </span>
                            @elseif($report->reportable_type === 'App\Models\Fundraising')
                                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-hand-holding-heart mr-1"></i>Collecte
                                </span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contenu signalé</label>
                        <p class="text-gray-900 font-semibold">
                            @if($report->reportable_type === 'App\Models\Event')
                                {{ $report->reportable->title ?? 'N/A' }}
                            @elseif($report->reportable_type === 'App\Models\Contest')
                                {{ $report->reportable->name ?? 'N/A' }}
                            @elseif($report->reportable_type === 'App\Models\Fundraising')
                                {{ $report->reportable->name ?? 'N/A' }}
                            @endif
                        </p>
                        <a href="@if($report->reportable_type === 'App\Models\Event'){{ route('events.show', $report->reportable) }}@elseif($report->reportable_type === 'App\Models\Contest'){{ route('contests.show', $report->reportable) }}@elseif($report->reportable_type === 'App\Models\Fundraising'){{ route('fundraisings.show', $report->reportable) }}@endif" 
                           target="_blank" 
                           class="text-red-600 hover:text-red-800 text-sm mt-1 inline-block">
                            <i class="fas fa-external-link-alt mr-1"></i>Voir le contenu
                        </a>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Raison du signalement</label>
                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                            @if($report->reason === 'inappropriate_content') bg-red-100 text-red-800
                            @elseif($report->reason === 'scam') bg-orange-100 text-orange-800
                            @else bg-yellow-100 text-yellow-800
                            @endif">
                            {{ $report->reason_label }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Message du signalant</label>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <p class="text-gray-800 whitespace-pre-wrap">{{ $report->message }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Signalé par</label>
                            <p class="text-gray-900">{{ $report->reporter->name ?? 'Utilisateur' }}</p>
                            <p class="text-sm text-gray-500">{{ $report->reporter->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date du signalement</label>
                            <p class="text-gray-900">{{ $report->created_at->translatedFormat('d/m/Y à H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes admin -->
            @if($report->admin_notes)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-blue-800 mb-2">Notes de l'administrateur</h3>
                    <p class="text-blue-900 whitespace-pre-wrap">{{ $report->admin_notes }}</p>
                    @if($report->reviewer)
                        <p class="text-sm text-blue-700 mt-2">
                            Par {{ $report->reviewer->name }} le {{ $report->reviewed_at->translatedFormat('d/m/Y à H:i') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="space-y-6">
            <!-- Statut actuel -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Statut actuel</h3>
                <span class="px-4 py-2 text-sm font-semibold rounded-full 
                    @if($report->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($report->status === 'reviewed') bg-blue-100 text-blue-800
                    @elseif($report->status === 'resolved') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ $report->status_label }}
                </span>
            </div>

            <!-- Formulaire de traitement -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Traiter le signalement</h3>
                <form method="POST" action="{{ route('admin.reports.update', $report) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nouveau statut *</label>
                        <select name="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                            <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="reviewed" {{ $report->status === 'reviewed' ? 'selected' : '' }}>Examiné</option>
                            <option value="resolved" {{ $report->status === 'resolved' ? 'selected' : '' }}>Résolu</option>
                            <option value="dismissed" {{ $report->status === 'dismissed' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes (optionnel)</label>
                        <textarea name="admin_notes" rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Ajoutez des notes sur le traitement de ce signalement...">{{ $report->admin_notes }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                        <i class="fas fa-save mr-2"></i>Enregistrer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


