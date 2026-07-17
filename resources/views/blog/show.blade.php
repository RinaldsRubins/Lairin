@extends('layouts.public')

@push('head')
@if($post->meta_title || $post->title)
<meta property="article:published_time" content="{{ $post->published_at?->toIso8601String() }}">
@if($post->author)
<meta property="article:author" content="{{ $post->author->name }}">
@endif
@endif
@endpush

@push('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ $post->meta_title ?? $post->title }}",
    "description": "{{ $post->meta_description ?? $post->excerpt }}",
    "datePublished": "{{ $post->published_at?->toIso8601String() }}",
    "author": {
        "@type": "Person",
        "name": "{{ $post->author?->name ?? config('lairin.company.name') }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ config('lairin.company.name') }}",
        "logo": {
            "@type": "ImageObject",
            "url": "{{ asset('images/logo.png') }}"
        }
    }
    @if($post->featured_image)
    ,"image": "{{ asset('storage/' . $post->featured_image) }}"
    @endif
}
</script>
@endpush

@section('title', $post->meta_title ?? $post->title)
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('meta_keywords', $post->meta_keywords ?? '')
@section('og_type', 'article')
@if($post->featured_image)
@section('og_image', asset('storage/' . $post->featured_image))
@endif

@section('content')
<article>
    <header class="relative py-20 overflow-hidden">
        @if($post->featured_image)
            <div class="absolute inset-0">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" class="w-full h-full object-cover opacity-15 dark:opacity-10">
                <div class="absolute inset-0 bg-gradient-to-b from-slate-50/95 to-slate-50 dark:from-secondary-900/98 dark:to-secondary-900"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-accent/5"></div>
        @endif

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <nav class="text-sm text-secondary-500 dark:text-slate-400 mb-6">
                <a href="{{ route('blog.index') }}" class="hover:text-primary">Blogs</a>
                <span class="mx-2">/</span>
                <span class="text-secondary-900 dark:text-white line-clamp-1">{{ $post->title }}</span>
            </nav>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-secondary-900 dark:text-white leading-tight mb-6">{{ $post->title }}</h1>

            <div class="flex flex-wrap items-center gap-4 text-sm text-secondary-500 dark:text-slate-400">
                @if($post->published_at)
                    <time datetime="{{ $post->published_at->toIso8601String() }}" class="flex items-center gap-2">
                        <x-icon name="calendar" class="w-4 h-4" />
                        {{ $post->published_at->translatedFormat('d. F Y') }}
                    </time>
                @endif
                @if($post->author)
                    <span class="flex items-center gap-2">
                        <x-icon name="users" class="w-4 h-4" />
                        {{ $post->author->name }}
                    </span>
                @endif
            </div>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
        @if($post->featured_image)
            <div class="rounded-2xl overflow-hidden shadow-glass-lg mb-12 -mt-8 relative z-10">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full">
            </div>
        @endif

        @if($post->excerpt)
            <p class="text-xl text-secondary-600 dark:text-slate-300 leading-relaxed mb-8 font-medium border-l-4 border-primary pl-6">
                {{ $post->excerpt }}
            </p>
        @endif

        <div class="prose prose-lg dark:prose-invert max-w-none prose-headings:text-secondary-900 dark:prose-headings:text-white prose-a:text-primary">
            {!! $post->content !!}
        </div>

        <div class="section-divider my-12"></div>

        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-primary font-semibold hover:gap-3 transition-all">
                <svg class="w-5 h-5 rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                Atpakaļ uz blogu
            </a>
            <a href="{{ route('booking.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-0.5 transition-all">
                Pieteikt konsultāciju
            </a>
        </div>

        @if($relatedPosts->isNotEmpty())
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-secondary-900 dark:text-white mb-8">Saistītie raksti</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related->slug) }}" class="group glass-card !p-0 overflow-hidden">
                            @if($related->featured_image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ asset('storage/' . $related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                                </div>
                            @endif
                            <div class="p-4">
                                <h3 class="font-bold text-secondary-900 dark:text-white text-sm group-hover:text-primary transition-colors line-clamp-2">{{ $related->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</article>
@endsection
