@extends('layouts.admin')

@section('title', 'Modifier un Article de Blog')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Modifier un Article de Blog</h1>
    </div>

    <form action="{{ route('admin.blogs.update', $blog) }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Titre *</label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $blog->title) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-semibold text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $blog->slug) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="blog_category_id" class="block text-sm font-semibold text-gray-700 mb-2">Catégorie</label>
                <select name="blog_category_id" id="blog_category_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                    <option value="">Aucune catégorie</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('blog_category_id', $blog->blog_category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="excerpt" class="block text-sm font-semibold text-gray-700 mb-2">Résumé</label>
                <textarea name="excerpt" id="excerpt" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('excerpt', $blog->excerpt) }}</textarea>
            </div>

            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Contenu *</label>
                <textarea name="content" id="content" rows="15" required
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('content', $blog->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="featured_image" class="block text-sm font-semibold text-gray-700 mb-2">Image à la une</label>
                @if($blog->featured_image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-32 h-32 object-cover rounded-lg">
                    </div>
                @endif
                <input type="file" name="featured_image" id="featured_image" accept="image/*"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                <p class="text-sm text-gray-500 mt-1">Laisser vide pour conserver l'image actuelle</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="meta_title" class="block text-sm font-semibold text-gray-700 mb-2">Meta Title (SEO)</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $blog->meta_title) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label for="order" class="block text-sm font-semibold text-gray-700 mb-2">Ordre d'affichage</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $blog->order) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="meta_description" class="block text-sm font-semibold text-gray-700 mb-2">Meta Description (SEO)</label>
                <textarea name="meta_description" id="meta_description" rows="3"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">{{ old('meta_description', $blog->meta_description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-2">Date de publication</label>
                    <input type="datetime-local" name="published_at" id="published_at" 
                           value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : '') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Statut</label>
                    <label class="flex items-center">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $blog->is_published) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-gray-700">Publié</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <a href="{{ route('admin.blogs.index') }}" class="bg-gray-200 text-gray-800 px-6 py-3 rounded-lg hover:bg-gray-300 transition">
                Annuler
            </a>
            <button type="submit" class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                <i class="fas fa-save mr-2"></i>Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

