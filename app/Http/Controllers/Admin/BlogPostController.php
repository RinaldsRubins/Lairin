<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::query()
            ->with('author')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin.blog-posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog-posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);
        $validated['author_id'] = $request->user()->id;

        BlogPost::query()->create($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Raksts izveidots.');
    }

    public function show(BlogPost $blogPost): View
    {
        $blogPost->load('author');

        return view('admin.blog-posts.show', ['post' => $blogPost]);
    }

    public function edit(BlogPost $blogPost): View
    {
        return view('admin.blog-posts.edit', ['post' => $blogPost]);
    }

    public function update(Request $request, BlogPost $blogPost): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $blogPost->update($validated);

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Raksts atjaunināts.');
    }

    public function destroy(BlogPost $blogPost): RedirectResponse
    {
        $blogPost->delete();

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('success', 'Raksts dzēsts.');
    }

    protected function validatePost(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'excerpt' => ['nullable', 'string'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'published_at' => ['nullable', 'date'],
        ]);
    }
}
