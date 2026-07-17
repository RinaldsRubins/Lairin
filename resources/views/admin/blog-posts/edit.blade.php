@extends('admin.layout')

@section('page_title', 'Rediģēt rakstu')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.blog-posts.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
</div>

<form method="POST" action="{{ route('admin.blog-posts.update', $post) }}" class="max-w-3xl">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-secondary-700 mb-1">Virsraksts *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label for="slug" class="block text-sm font-medium text-secondary-700 mb-1">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $post->slug) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="published_at" class="block text-sm font-medium text-secondary-700 mb-1">Publicēšanas datums</label>
                <input type="datetime-local" id="published_at" name="published_at"
                       value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="excerpt" class="block text-sm font-medium text-secondary-700 mb-1">Ievads</label>
            <textarea id="excerpt" name="excerpt" rows="3"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-secondary-700 mb-1">Saturs *</label>
            <textarea id="content" name="content" rows="12" required
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('content', $post->content) }}</textarea>
            @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="featured_image" class="block text-sm font-medium text-secondary-700 mb-1">Galvenais attēls (URL)</label>
            <input type="text" id="featured_image" name="featured_image" value="{{ old('featured_image', $post->featured_image) }}"
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
            @error('featured_image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', $post->is_published))
                   class="rounded border-slate-300 text-primary focus:ring-primary">
            <label for="is_published" class="text-sm font-medium text-secondary-700">Publicēts</label>
        </div>

        <div class="border-t border-slate-200 pt-6">
            <h3 class="text-sm font-semibold text-secondary-900 mb-4">SEO</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-secondary-700 mb-1">Meta virsraksts</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    @error('meta_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-secondary-700 mb-1">Meta apraksts</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('meta_description', $post->meta_description) }}</textarea>
                    @error('meta_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="meta_keywords" class="block text-sm font-medium text-secondary-700 mb-1">Atslēgvārdi</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    @error('meta_keywords') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
            Atjaunināt
        </button>
        <a href="{{ route('admin.blog-posts.show', $post) }}" class="text-sm text-secondary-500 hover:text-secondary-700">Skatīt</a>
    </div>
</form>
@endsection
