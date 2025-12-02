@extends('layouts.admin')

@section('title', 'Catégories de Blog')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Catégories de Blog</h1>
        <a href="{{ route('admin.blog-categories.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
            <i class="fas fa-plus mr-2"></i>Nouvelle catégorie
        </a>
    </div>

    @if($categories->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nom</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Slug</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Couleur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Articles</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-semibold text-gray-900">{{ $category->name }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->slug }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded" style="background-color: {{ $category->color }}"></div>
                                        <span class="text-sm text-gray-600">{{ $category->color }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-600">{{ $category->blogs()->count() }}</td>
                                <td class="px-6 py-4">
                                    @if($category->is_active)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Active</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Inactive</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('admin.blog-categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blog-categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-tags text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg mb-6">Aucune catégorie pour le moment.</p>
            <a href="{{ route('admin.blog-categories.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition inline-block">
                <i class="fas fa-plus mr-2"></i>Créer la première catégorie
            </a>
        </div>
    @endif
</div>
@endsection

