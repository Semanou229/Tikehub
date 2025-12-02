@extends('layouts.admin')

@section('title', 'Gestion des FAQs')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion des FAQs</h1>
        <a href="{{ route('admin.faqs.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle FAQ
        </a>
    </div>

    @if($faqs->isEmpty())
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-question-circle text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg mb-6">Aucune FAQ pour le moment.</p>
            <a href="{{ route('admin.faqs.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition inline-block">
                <i class="fas fa-plus mr-2"></i>Créer la première FAQ
            </a>
        </div>
    @else
        @foreach($faqs as $category => $categoryFaqs)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                @if($category)
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-500">
                        {{ $category }}
                    </h2>
                @else
                    <h2 class="text-xl font-bold text-gray-800 mb-4 pb-2 border-b-2 border-indigo-500">
                        Général
                    </h2>
                @endif

                <div class="space-y-4">
                    @foreach($categoryFaqs as $faq)
                        <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-indigo-500 transition">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="text-sm font-semibold text-gray-500">#{{ $faq->order }}</span>
                                        <h3 class="font-semibold text-gray-800">{{ $faq->question }}</h3>
                                        @if(!$faq->is_active)
                                            <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600">Inactive</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($faq->answer, 150) }}</p>
                                </div>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}" class="text-indigo-600 hover:text-indigo-800" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette FAQ ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

