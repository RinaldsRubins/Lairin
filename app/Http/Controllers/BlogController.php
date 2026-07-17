<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LoadsSeoData;
use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    use LoadsSeoData;

    public function index(): View
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->with('author')
            ->orderByDesc('published_at')
            ->paginate(12);

        return view('blog.index', [
            'posts' => $posts,
            'seo' => $this->seoFor('/blogs'),
        ]);
    }

    public function show(string $slug): View
    {
        $post = BlogPost::query()
            ->where('slug', $slug)
            ->where('is_published', true)
            ->with('author')
            ->firstOrFail();

        $relatedPosts = BlogPost::query()
            ->where('is_published', true)
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
            'seo' => $this->seoFor("/blogs/{$slug}"),
        ]);
    }
}
