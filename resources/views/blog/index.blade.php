@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-accent/10 via-primary/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-accent font-semibold text-sm uppercase tracking-wider">Blogs</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 dark:text-white mt-2 mb-6">
            Jaunumi un <span class="text-gradient">ekspertīze</span>
        </h1>
        <p class="text-lg text-secondary-600 dark:text-slate-400 max-w-2xl mx-auto">
            IT tendences, praktiski padomi un mūsu komandas pieredze digitālās transformācijas jomā.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article class="group">
                    <a href="{{ route('blog.show', $post->slug) }}" class="block glass-card !p-0 overflow-hidden h-full">
                        @if($post->featured_image)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            </div>
                        @else
                            <div class="aspect-video bg-gradient-to-br from-primary/20 to-accent/20 flex items-center justify-center">
                                <x-icon name="document" class="w-12 h-12 text-primary/40" />
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-secondary-500 dark:text-slate-400 mb-3">
                                @if($post->published_at)
                                    <time datetime="{{ $post->published_at->toIso8601String() }}">{{ $post->published_at->translatedFormat('d. F Y') }}</time>
                                @endif
                                @if($post->author)
                                    <span>·</span>
                                    <span>{{ $post->author->name }}</span>
                                @endif
                            </div>
                            <h2 class="text-lg font-bold text-secondary-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2">{{ $post->title }}</h2>
                            @if($post->excerpt)
                                <p class="text-sm text-secondary-600 dark:text-slate-400 mt-2 line-clamp-3">{{ $post->excerpt }}</p>
                            @endif
                            <span class="inline-flex items-center gap-1 text-sm text-primary font-semibold mt-4 group-hover:gap-2 transition-all">
                                Lasīt vairāk <x-icon name="arrow-right" class="w-4 h-4" />
                            </span>
                        </div>
                    </a>
                </article>
            @empty
                <div class="col-span-full text-center py-16">
                    <p class="text-secondary-500 dark:text-slate-400">Vēl nav publicētu rakstu.</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
