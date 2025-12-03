@extends('layouts.app')

@section('title', ($blog->meta_title ?? $blog->title) . ' - Blog Tikehub')

@push('head')
<!-- SEO Meta Tags -->
<meta name="description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 160) }}">
<meta name="keywords" content="billetterie en ligne, événements Afrique, gestion d'événements, {{ $blog->category->name ?? '' }}">
<meta name="author" content="{{ $blog->author->name ?? 'Tikehub' }}">
<meta name="robots" content="index, follow">
<meta name="article:published_time" content="{{ $blog->published_at->toAtomString() }}">
<meta name="article:modified_time" content="{{ $blog->updated_at->toAtomString() }}">
@if($blog->category)
<meta name="article:section" content="{{ $blog->category->name }}">
@endif

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/blog/' . $blog->slug) }}">
<meta property="og:title" content="{{ $blog->meta_title ?? $blog->title }}">
<meta property="og:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 200) }}">
@if($blog->featured_image)
<meta property="og:image" content="{{ asset('storage/' . $blog->featured_image) }}">
@endif
<meta property="og:locale" content="fr_FR">
<meta property="og:site_name" content="Tikehub">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url('/blog/' . $blog->slug) }}">
<meta property="twitter:title" content="{{ $blog->meta_title ?? $blog->title }}">
<meta property="twitter:description" content="{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 200) }}">
@if($blog->featured_image)
<meta property="twitter:image" content="{{ asset('storage/' . $blog->featured_image) }}">
@endif

<!-- Structured Data JSON-LD pour Article -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ $blog->title }}",
  "description": "{{ $blog->meta_description ?? $blog->excerpt ?? Str::limit(strip_tags($blog->content), 200) }}",
  "image": "{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('images/og-image.jpg') }}",
  "datePublished": "{{ $blog->published_at->toAtomString() }}",
  "dateModified": "{{ $blog->updated_at->toAtomString() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $blog->author->name ?? 'Tikehub' }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "Tikehub",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/logo.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url('/blog/' . $blog->slug) }}"
  }
}
</script>
@endpush

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
        <div class="prose prose-lg max-w-none mb-12">
            {!! $blog->content !!}
        </div>
        
        @push('styles')
        <style>
            /* Styles pour le contenu des articles de blog */
            .prose {
                color: #374151;
                line-height: 1.75;
            }
            
            .prose h2 {
                font-size: 1.875rem;
                font-weight: 700;
                margin-top: 2rem;
                margin-bottom: 1rem;
                color: #1f2937;
                line-height: 1.3;
            }
            
            .prose h3 {
                font-size: 1.5rem;
                font-weight: 600;
                margin-top: 1.5rem;
                margin-bottom: 0.75rem;
                color: #374151;
                line-height: 1.4;
            }
            
            .prose p {
                margin-top: 1.25rem;
                margin-bottom: 1.25rem;
                line-height: 1.75;
            }
            
            .prose ul, .prose ol {
                margin-top: 1.25rem;
                margin-bottom: 1.25rem;
                padding-left: 1.625rem;
            }
            
            .prose ul {
                list-style-type: disc;
            }
            
            .prose ol {
                list-style-type: decimal;
            }
            
            .prose li {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
                padding-left: 0.375rem;
            }
            
            .prose li::marker {
                color: #4f46e5;
            }
            
            .prose strong {
                font-weight: 600;
                color: #1f2937;
            }
            
            .prose a {
                color: #4f46e5;
                text-decoration: underline;
                font-weight: 500;
            }
            
            .prose a:hover {
                color: #4338ca;
            }
            
            .prose code {
                background-color: #f3f4f6;
                padding: 0.125rem 0.375rem;
                border-radius: 0.25rem;
                font-size: 0.875em;
                color: #dc2626;
            }
            
            .prose blockquote {
                border-left: 4px solid #4f46e5;
                padding-left: 1rem;
                margin: 1.5rem 0;
                font-style: italic;
                color: #6b7280;
            }
            
            .prose img {
                max-width: 100%;
                height: auto;
                border-radius: 0.5rem;
                margin: 1.5rem 0;
            }
            
            .prose hr {
                border: none;
                border-top: 1px solid #e5e7eb;
                margin: 2rem 0;
            }
            
            @media (max-width: 640px) {
                .prose h2 {
                    font-size: 1.5rem;
                }
                
                .prose h3 {
                    font-size: 1.25rem;
                }
            }
        </style>
        @endpush

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

