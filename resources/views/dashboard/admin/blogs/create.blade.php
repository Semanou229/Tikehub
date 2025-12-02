@extends('layouts.admin')

@section('title', 'Créer un Article de Blog')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Créer un Article de Blog</h1>
    </div>

    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
        @csrf

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    <p class="text-sm text-gray-500 mt-1">Laissez vide pour générer automatiquement</p>
                </div>
            </div>

            <div>
                <label for="blog_category_id" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                <select name="blog_category_id" id="blog_category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    <option value="">Aucune catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('blog_category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-2">Résumé</label>
                <textarea name="excerpt" id="excerpt" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none"
                          placeholder="Court résumé de l'article (affiché dans la liste)">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Contenu *</label>
                <textarea name="content" id="content" rows="15" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-semibold text-gray-700 mb-2">Image à la une</label>
                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG (max 2MB)</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Ordre d'affichage</label>
                    <input type="number" name="order" id="order" value="{{ old('order', 0) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">Meta Description (SEO)</label>
                <textarea name="meta_description" id="meta_description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('meta_description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">Date de publication</label>
                    <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-gray-700">Publier immédiatement</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.blogs.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                Annuler
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-save mr-2"></i>Créer
            </button>
        </div>
    </form>
</div>
@endsection

