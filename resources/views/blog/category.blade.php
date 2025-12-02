@extends('layouts.app')

@section('title', $category->name . ' - Blog Tikehub')

@section('content')
<!-- Hero Section -->
<section class="py-16 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl sm:text-5xl font-bold mb-4">{{ $category->name }}</h1>
        @if($category->description)
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto">{{ $category->description }}</p>
        @endif
    </div>
</section>

<!-- Blog Content -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 mb-4">
                <i class="fas fa-arrow-left mr-2"></i>Retour au blog
            </a>
        </div>

        @if($blogs->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($blogs as $blog)
                    <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                        @if($blog->featured_image)
                            <a href="{{ route('blog.show', $blog) }}">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-48 object-cover">
                            </a>
                        @endif
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-800 mb-2">
                                <a href="{{ route('blog.show', $blog) }}" class="hover:text-indigo-600 transition">
                                    {{ $blog->title }}
                                </a>
                            </h2>
                            @if($blog->excerpt)
                                <p class="text-gray-600 mb-4">{{ Str::limit($blog->excerpt, 100) }}</p>
                            @endif
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $blog->published_at->format('d/m/Y') }}</span>
                                <span><i class="fas fa-eye mr-1"></i>{{ $blog->views_count }}</span>
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
                <p class="text-gray-600 text-lg">Aucun article dans cette catégorie.</p>
            </div>
        @endif
    </div>
</section>
@endsection

