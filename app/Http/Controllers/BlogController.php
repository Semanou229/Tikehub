<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author'])->published();

        // Filtre par catégorie
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(12);
        $categories = BlogCategory::where('is_active', true)->orderBy('order')->get();
        $featuredBlogs = Blog::published()->orderBy('views_count', 'desc')->take(3)->get();

        return view('blog.index', compact('blogs', 'categories', 'featuredBlogs'));
    }

    public function show(Blog $blog)
    {
        if (!$blog->is_published || ($blog->published_at && $blog->published_at->isFuture())) {
            abort(404);
        }

        $blog->incrementViews();
        $blog->load(['category', 'author']);

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where(function ($q) use ($blog) {
                if ($blog->blog_category_id) {
                    $q->where('blog_category_id', $blog->blog_category_id);
                }
            })
            ->take(3)
            ->get();

        return view('blog.show', compact('blog', 'relatedBlogs'));
    }

    public function category(BlogCategory $category)
    {
        $blogs = Blog::published()
            ->where('blog_category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = BlogCategory::where('is_active', true)->orderBy('order')->get();

        return view('blog.category', compact('category', 'blogs', 'categories'));
    }
}
