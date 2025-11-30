@extends('layouts.dashboard')

@section('title', 'Rapports')

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-4 sm:mb-6">Rapports</h1>

    <!-- Statistiques -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6 lg:mb-8">
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Total événements</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total_events'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Billets vendus</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-green-600">{{ $stats['total_tickets_sold'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Revenus totaux</div>
            <div class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-purple-600 break-words">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Paiements en attente</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-orange-600">{{ $stats['pending_payments'] }}</div>
        </div>
    </div>

    <!-- Liste des événements -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">Rapports par événement</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Événement</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden sm:table-cell">Date</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Billets</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Revenus</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($events as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-900 break-words">{{ $event->title }}</div>
                                <div class="text-xs text-gray-500 mt-1 sm:hidden">{{ $event->start_date->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">
                                {{ $event->start_date->format('d/m/Y') }}
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">
                                {{ $event->tickets_sold ?? 0 }}
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900 hidden md:table-cell">
                                {{ number_format($event->revenue ?? 0, 0, ',', ' ') }} XOF
                            </td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <div class="flex flex-wrap items-center gap-1.5 sm:gap-2">
                                    <a href="{{ route('organizer.reports.event', $event) }}" class="text-indigo-600 hover:text-indigo-900 text-xs sm:text-sm min-w-[32px] min-h-[32px] flex items-center justify-center" title="Voir">
                                        <i class="fas fa-eye text-xs sm:text-sm"></i><span class="hidden lg:inline ml-1">Voir</span>
                                    </a>
                                    <a href="{{ route('organizer.reports.export', [$event, 'csv']) }}" class="text-green-600 hover:text-green-900 text-xs sm:text-sm min-w-[32px] min-h-[32px] flex items-center justify-center" title="CSV">
                                        <i class="fas fa-download text-xs sm:text-sm"></i><span class="hidden lg:inline ml-1">CSV</span>
                                    </a>
                                    <a href="{{ route('organizer.reports.export', [$event, 'excel']) }}" class="text-blue-600 hover:text-blue-900 text-xs sm:text-sm min-w-[32px] min-h-[32px] flex items-center justify-center" title="Excel">
                                        <i class="fas fa-file-excel text-xs sm:text-sm"></i><span class="hidden lg:inline ml-1">Excel</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


