@extends('layouts.app')

@section('title', $blog->title . ' - Blog Tikehub')

@section('content')
<article class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            @if($blog->category)
                <a href="{{ route('blog.category', $blog->category) }}" class="inline-block mb-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold" style="background-color: {{ $blog->category->color }}20; color: {{ $blog->category->color }}">
                        {{ $blog->category->name }}
                    </span>
                </a>
            @endif
            <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $blog->title }}</h1>
            <div class="flex items-center gap-4 text-gray-600">
                <div class="flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    <span>{{ $blog->author->name ?? 'Admin' }}</span>
                </div>
                <span>•</span>
                <span>{{ $blog->published_at->format('d F Y') }}</span>
                <span>•</span>
                <span><i class="fas fa-eye mr-1"></i>{{ $blog->views_count }} vues</span>
            </div>
        </div>

        <!-- Featured Image -->
        @if($blog->featured_image)
            <div class="mb-8">
                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
            </div>
        @endif

        <!-- Content -->
        <div class="prose max-w-none mb-12">
            {!! nl2br(e($blog->content)) !!}
        </div>

        <!-- Related Articles -->
        @if($relatedBlogs->count() > 0)
            <div class="mt-16 pt-8 border-t border-gray-200">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Articles similaires</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedBlogs as $related)
                        <a href="{{ route('blog.show', $related) }}" class="block group">
                            @if($related->featured_image)
                                <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-32 object-cover rounded-lg mb-2 group-hover:opacity-80 transition">
                            @endif
                            <h3 class="font-semibold text-gray-800 group-hover:text-indigo-600 transition">{{ Str::limit($related->title, 60) }}</h3>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Back to Blog -->
        <div class="mt-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800">
                <i class="fas fa-arrow-left mr-2"></i>Retour au blog
            </a>
        </div>
    </div>
</article>
@endsection

