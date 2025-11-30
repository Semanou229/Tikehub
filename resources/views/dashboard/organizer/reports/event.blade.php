@extends('layouts.dashboard')

@section('title', 'Rapport - ' . $event->title)

@section('content')
<div class="p-3 sm:p-4 lg:p-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0 mb-4 sm:mb-6">
        <div class="flex-1 min-w-0">
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800">Rapport d'Événement</h1>
            <p class="text-sm sm:text-base text-gray-600 mt-1 break-words">{{ $event->title }}</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2 sm:gap-2 w-full sm:w-auto">
            <a href="{{ route('organizer.reports.export', [$event, 'csv']) }}" class="bg-green-600 text-white px-3 sm:px-4 lg:px-6 py-2.5 sm:py-2 lg:py-2 rounded-lg hover:bg-green-700 active:bg-green-800 transition font-medium text-xs sm:text-sm min-h-[44px] flex items-center justify-center shadow-sm hover:shadow-md">
                <i class="fas fa-download text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Export CSV</span><span class="sm:hidden">CSV</span>
            </a>
            <a href="{{ route('organizer.reports.export', [$event, 'excel']) }}" class="bg-blue-600 text-white px-3 sm:px-4 lg:px-6 py-2.5 sm:py-2 lg:py-2 rounded-lg hover:bg-blue-700 active:bg-blue-800 transition font-medium text-xs sm:text-sm min-h-[44px] flex items-center justify-center shadow-sm hover:shadow-md">
                <i class="fas fa-file-excel text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Export Excel</span><span class="sm:hidden">Excel</span>
            </a>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6 lg:mb-8">
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Billets vendus</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-indigo-600">{{ $stats['total_sold'] }}</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Revenus totaux</div>
            <div class="text-lg sm:text-xl lg:text-2xl xl:text-3xl font-bold text-green-600 break-words">{{ number_format($stats['total_revenue'], 0, ',', ' ') }} XOF</div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-3 sm:p-4 lg:p-6">
            <div class="text-xs sm:text-sm text-gray-600 mb-1">Types de billets</div>
            <div class="text-xl sm:text-2xl lg:text-3xl font-bold text-purple-600">{{ $stats['by_type']->count() }}</div>
        </div>
    </div>

    <!-- Liste des billets -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 border-b border-gray-200">
            <h2 class="text-lg sm:text-xl font-bold text-gray-800">Détails des billets vendus</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">ID</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Type</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden md:table-cell">Acheteur</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden lg:table-cell">Email</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Prix</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap hidden sm:table-cell">Date</th>
                        <th class="px-3 sm:px-4 lg:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase whitespace-nowrap">Statut</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($tickets as $ticket)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900">#{{ $ticket->id }}</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 break-words max-w-[120px] sm:max-w-none">{{ $ticket->ticketType->name ?? 'N/A' }}</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-900 hidden md:table-cell">{{ $ticket->buyer->name ?? 'N/A' }}</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden lg:table-cell truncate max-w-[200px]">{{ $ticket->buyer->email ?? 'N/A' }}</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm font-semibold text-gray-900">{{ number_format($ticket->price, 0, ',', ' ') }} XOF</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap text-xs sm:text-sm text-gray-500 hidden sm:table-cell">{{ $ticket->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-3 sm:px-4 lg:px-6 py-3 sm:py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 whitespace-nowrap">{{ $ticket->status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4 sm:mt-6">
        <a href="{{ route('organizer.reports.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm sm:text-base min-h-[44px] flex items-center">
            <i class="fas fa-arrow-left text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Retour aux rapports
        </a>
    </div>
</div>
@endsection


