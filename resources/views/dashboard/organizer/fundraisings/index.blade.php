@extends('layouts.dashboard')

@section('title', 'Mes Collectes de Fonds')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Mes Collectes de Fonds</h1>
        <a href="{{ route('fundraisings.create') }}" class="bg-green-600 text-white px-3 sm:px-5 lg:px-6 py-2 sm:py-2.5 lg:py-3 rounded-lg hover:bg-green-700 active:bg-green-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
            <i class="fas fa-plus text-xs sm:text-sm mr-1.5 sm:mr-2"></i><span class="hidden sm:inline">Nouvelle collecte</span><span class="sm:hidden">Nouvelle</span>
        </a>
    </div>

    @if($fundraisings->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($fundraisings as $fundraising)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">{{ $fundraising->name }}</h3>
                                @if($fundraising->description)
                                    <p class="text-sm text-gray-600 line-clamp-2">{{ Str::limit($fundraising->description, 80) }}</p>
                                @endif
                            </div>
                            <div class="ml-4 flex flex-col gap-1">
                                @if($fundraising->is_published)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Publiée</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Brouillon</span>
                                @endif
                                @if($fundraising->isActive())
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Active</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Terminée</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-calendar-alt text-green-600 mr-2 w-4"></i>
                                <span>{{ $fundraising->start_date->format('d/m/Y') }} au {{ $fundraising->end_date->format('d/m/Y') }}</span>
                            </div>
                            
                            <!-- Barre de progression -->
                            <div>
                                <div class="flex justify-between text-sm mb-2">
                                    <span class="text-gray-600">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</span>
                                    <span class="text-gray-600">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-300" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-green-600 font-semibold">{{ number_format($fundraising->progress_percentage, 1) }}% atteint</span>
                                    <span class="text-gray-500">{{ $fundraising->donations_count }} dons</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('fundraisings.show', $fundraising) }}" class="text-indigo-600 hover:text-indigo-900 p-2 rounded-lg hover:bg-indigo-50" title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('fundraisings.edit', $fundraising) }}" class="text-gray-600 hover:text-gray-900 p-2 rounded-lg hover:bg-gray-50" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(!$fundraising->is_published)
                                    <form action="{{ route('fundraisings.publish', $fundraising) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900 p-2 rounded-lg hover:bg-green-50" title="Publier">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <form action="{{ route('organizer.fundraisings.destroy', $fundraising) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50" title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $fundraisings->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-heart text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 mb-4">Aucune collecte de fonds créée pour le moment</p>
            <a href="{{ route('fundraisings.create') }}" class="inline-block bg-green-600 text-white px-4 sm:px-5 lg:px-6 py-2.5 sm:py-3 rounded-lg hover:bg-green-700 active:bg-green-800 transition font-medium text-xs sm:text-sm lg:text-base min-h-[40px] sm:min-h-[44px] flex items-center justify-center shadow-md hover:shadow-lg">
                <i class="fas fa-plus text-xs sm:text-sm mr-1.5 sm:mr-2"></i>Créer ma première collecte
            </a>
        </div>
    @endif
</div>
@endsection

