@extends('admin.layout')

@section('page_title', $post->title)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.blog-posts.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.blog-posts.edit', $post) }}"
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
            Rediģēt
        </a>
        <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}" onsubmit="return confirm('Vai tiešām dzēst šo rakstu?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-100 transition-colors">
                Dzēst
            </button>
        </form>
    </div>
</div>

<div class="grid lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-start justify-between gap-4 mb-4">
                <h2 class="text-xl font-bold text-secondary-900">{{ $post->title }}</h2>
                @if($post->is_published)
                    <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Publicēts</span>
                @else
                    <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Melnraksts</span>
                @endif
            </div>

            @if($post->excerpt)
                <p class="text-secondary-600 text-sm mb-6">{{ $post->excerpt }}</p>
            @endif

            <div class="prose prose-sm max-w-none text-secondary-800">
                {!! $post->content !!}
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-secondary-900 mb-4">Detaļas</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Slug</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->slug }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Autors</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->author?->name ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Publicēts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->published_at?->format('d.m.Y H:i') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Izveidots</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->created_at->format('d.m.Y H:i') }}</dd>
                </div>
                @if($post->tags)
                    <div>
                        <dt class="text-secondary-500">Birkas</dt>
                        <dd class="mt-1 flex flex-wrap gap-1">
                            @foreach($post->tags as $tag)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-slate-100 text-secondary-700">{{ $tag }}</span>
                            @endforeach
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        @if($post->featured_image)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-secondary-900 mb-4">Galvenais attēls</h2>
                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="rounded-lg w-full">
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-secondary-900 mb-4">SEO</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Meta virsraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->meta_title ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Meta apraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $post->meta_description ?: '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
