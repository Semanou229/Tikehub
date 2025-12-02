@extends('layouts.app')

@section('title', 'Blog - Tikehub')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">Blog Tikehub</h1>
        <p class="text-xl text-indigo-100 max-w-2xl mx-auto">
            Découvrez nos articles, conseils et actualités
        </p>
    </div>
</section>

<!-- Blog Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <aside class="lg:col-span-1">
                <!-- Categories -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Catégories</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('blog.index') }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition">
                                Toutes les catégories
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('blog.category', $category) }}" class="block px-4 py-2 rounded-lg hover:bg-indigo-50 text-gray-700 hover:text-indigo-600 transition flex items-center">
                                    <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Featured Articles -->
                @if($featuredBlogs->count() > 0)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Articles populaires</h3>
                        <div class="space-y-4">
                            @foreach($featuredBlogs as $featured)
                                <a href="{{ route('blog.show', $featured) }}" class="block group">
                                    @if($featured->featured_image)
                                        <img src="{{ asset('storage/' . $featured->featured_image) }}" alt="{{ $featured->title }}" class="w-full h-32 object-cover rounded-lg mb-2 group-hover:opacity-80 transition">
                                    @endif
                                    <h4 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition">{{ Str::limit($featured->title, 50) }}</h4>
                                    <p class="text-sm text-gray-500">{{ $featured->views_count }} vues</p>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Search -->
                <form method="GET" action="{{ route('blog.index') }}" class="mb-8">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher un article..." 
                               class="flex-1 px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-indigo-500 focus:outline-none">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                @if($blogs->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($blogs as $blog)
                            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                @if($blog->featured_image)
                                    <a href="{{ route('blog.show', $blog) }}">
                                        <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                                    </a>
                                @endif
                                <div class="p-6">
                                    @if($blog->category)
                                        <a href="{{ route('blog.category', $blog->category) }}" class="inline-block mb-2">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $blog->category->color }}20; color: {{ $blog->category->color }}">
                                                {{ $blog->category->name }}
                                            </span>
                                        </a>
                                    @endif
                                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                                        <a href="{{ route('blog.show', $blog) }}" class="hover:text-indigo-600 transition">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    @if($blog->excerpt)
                                        <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 100) }}</p>
                                    @endif
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-user mr-2"></i>
                                            <span>{{ $blog->author->name ?? 'Admin' }}</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <span><i class="fas fa-eye mr-1"></i>{{ $blog->views_count }}</span>
                                            <span>{{ $blog->published_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $blogs->links() }}
                    </div>
                @else
                    <div class="bg-white rounded-lg shadow-md p-12 text-center">
                        <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
                        <p class="text-gray-600 text-lg">Aucun article trouvé.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

