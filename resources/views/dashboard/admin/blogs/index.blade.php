@extends('layouts.admin')

@section('title', 'Gestion du Blog')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gestion du Blog</h1>
        <div class="flex gap-3">
            <a href="{{ route('admin.blog-categories.index') }}" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                <i class="fas fa-tags mr-2"></i>Catégories
            </a>
            <a href="{{ route('admin.blogs.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-plus mr-2"></i>Nouvel article
            </a>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('admin.blogs.index') }}" class="flex gap-4 flex-wrap">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher..." class="flex-1 min-w-[200px] px-4 py-2 border border-gray-300 rounded-lg">
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <select name="published" class="px-4 py-2 border border-gray-300 rounded-lg">
                <option value="">Tous</option>
                <option value="1" {{ request('published') === '1' ? 'selected' : '' }}>Publiés</option>
                <option value="0" {{ request('published') === '0' ? 'selected' : '' }}>Non publiés</option>
            </select>
            <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-search mr-2"></i>Rechercher
            </button>
        </form>
    </div>

    <!-- Liste des articles -->
    @if($blogs->count() > 0)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Titre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catégorie</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Auteur</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vues</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Statut</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($blogs as $blog)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($blog->featured_image)
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-12 h-12 rounded-lg object-cover mr-3">
                                        @endif
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $blog->title }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($blog->excerpt, 50) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($blog->category)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $blog->category->color }}20; color: {{ $blog->category->color }}">
                                            {{ $blog->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Aucune</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $blog->author->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $blog->views_count }}</td>
                                <td class="px-6 py-4">
                                    @if($blog->is_published)
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Publié</span>
                                    @else
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Brouillon</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : $blog->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <a href="{{ route('blog.show', $blog) }}" target="_blank" class="text-blue-600 hover:text-blue-800" title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-indigo-600 hover:text-indigo-800" title="Modifier">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
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
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $blogs->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 text-lg mb-6">Aucun article de blog pour le moment.</p>
            <a href="{{ route('admin.blogs.create') }}" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition inline-block">
                <i class="fas fa-plus mr-2"></i>Créer le premier article
            </a>
        </div>
    @endif
</div>
@endsection

