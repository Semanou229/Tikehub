@extends('layouts.app')

@section('title', $fundraising->name)

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    @if($fundraising->cover_image)
        <div class="relative h-96 bg-cover bg-center" style="background-image: url('{{ asset('storage/' . $fundraising->cover_image) }}')">
            <div class="absolute inset-0 bg-black bg-opacity-50"></div>
            <div class="relative z-10 h-full flex items-center justify-center">
                <div class="text-center text-white px-4">
                    <span class="bg-green-600 px-4 py-2 rounded-full text-sm font-semibold mb-4 inline-block">Collecte de fonds</span>
                    <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $fundraising->name }}</h1>
                    <div class="mt-6">
                        <div class="text-3xl font-bold mb-2">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</div>
                        <div class="text-lg">sur {{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-gradient-to-r from-green-600 to-teal-600 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="bg-white bg-opacity-20 px-4 py-2 rounded-full text-sm font-semibold mb-4 inline-block">Collecte de fonds</span>
                <h1 class="text-4xl md:text-6xl font-bold mb-4">{{ $fundraising->name }}</h1>
                <div class="mt-6">
                    <div class="text-3xl font-bold mb-2">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</div>
                    <div class="text-lg">sur {{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</div>
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <!-- Barre de progression -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-gray-600">Collecté</span>
                        <span class="text-gray-600">{{ number_format($fundraising->progress_percentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-4 mb-4">
                        <div class="bg-green-600 h-4 rounded-full transition-all duration-500" style="width: {{ min(100, $fundraising->progress_percentage) }}%"></div>
                    </div>
                    <div class="flex justify-between">
                        <div>
                            <div class="text-2xl font-bold text-green-600">{{ number_format($fundraising->current_amount, 0, ',', ' ') }} XOF</div>
                            <div class="text-sm text-gray-600">Collecté</div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-bold text-gray-800">{{ number_format($fundraising->goal_amount, 0, ',', ' ') }} XOF</div>
                            <div class="text-sm text-gray-600">Objectif</div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">À propos</h2>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($fundraising->description)) !!}
                    </div>
                </div>

                <!-- Jalons -->
                @if($fundraising->milestones && count($fundraising->milestones) > 0)
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Jalons</h2>
                        <div class="space-y-4">
                            @foreach($fundraising->milestones as $milestone)
                                <div class="border-l-4 border-green-600 pl-4">
                                    <div class="font-semibold text-gray-800">{{ $milestone['title'] ?? 'Jalon' }}</div>
                                    <div class="text-sm text-gray-600">{{ number_format($milestone['amount'] ?? 0, 0, ',', ' ') }} XOF</div>
                                    @if(isset($milestone['description']))
                                        <div class="text-gray-700 mt-2">{{ $milestone['description'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Derniers donateurs -->
                @if($fundraising->show_donors && $fundraising->donations->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Derniers donateurs</h2>
                        <div class="space-y-3">
                            @foreach($fundraising->donations->take(10) as $donation)
                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <div>
                                        <div class="font-semibold text-gray-800">{{ $donation->donor_name ?? 'Anonyme' }}</div>
                                        <div class="text-sm text-gray-500">{{ $donation->created_at->format('d M Y') }}</div>
                                    </div>
                                    <div class="text-lg font-bold text-green-600">
                                        {{ number_format($donation->amount, 0, ',', ' ') }} XOF
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Contribuer</h3>
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Période</div>
                            <div class="text-gray-800">
                                Du {{ $fundraising->start_date->format('d M Y') }}<br>
                                au {{ $fundraising->end_date->format('d M Y') }}
                            </div>
                        </div>
                        @if($fundraising->organizer)
                            <div>
                                <div class="text-sm text-gray-600 mb-1">Organisateur</div>
                                <div class="text-gray-800">{{ $fundraising->organizer->name }}</div>
                            </div>
                        @endif
                    </div>

                    <a href="{{ route('fundraisings.show', $fundraising) }}" class="block w-full text-center bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                        Contribuer maintenant
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

