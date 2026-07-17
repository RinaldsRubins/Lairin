@extends('admin.layout')

@section('page_title', $project->title)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.projects.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.projects.edit', $project) }}"
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
            Rediģēt
        </a>
        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Vai tiešām dzēst šo projektu?')">
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
                <h2 class="text-xl font-bold text-secondary-900">{{ $project->title }}</h2>
                <div class="flex flex-wrap gap-1 shrink-0">
                    @if($project->is_published)
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Publicēts</span>
                    @else
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Melnraksts</span>
                    @endif
                    @if($project->is_featured)
                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">Izcelts</span>
                    @endif
                </div>
            </div>

            @if($project->description)
                <p class="text-secondary-600 text-sm mb-6">{{ $project->description }}</p>
            @endif

            @if($project->content)
                <div class="prose prose-sm max-w-none text-secondary-800">
                    {!! $project->content !!}
                </div>
            @endif
        </div>

        @if($project->gallery && count($project->gallery))
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-secondary-900 mb-4">Galerija</h2>
                <div class="grid sm:grid-cols-2 gap-4">
                    @foreach($project->gallery as $url)
                        <img src="{{ $url }}" alt="" class="rounded-lg w-full aspect-video object-cover">
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div class="space-y-6">
        @if($project->image)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-secondary-900 mb-4">Galvenais attēls</h2>
                <img src="{{ $project->image }}" alt="{{ $project->title }}" class="rounded-lg w-full">
            </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-secondary-900 mb-4">Detaļas</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Slug</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->slug }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Klients</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->client ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Nozare</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->industry ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Kārtība</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->sort_order }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Publicēts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->published_at?->format('d.m.Y H:i') ?? '—' }}</dd>
                </div>
                @if($project->technologies)
                    <div>
                        <dt class="text-secondary-500">Tehnoloģijas</dt>
                        <dd class="mt-1 flex flex-wrap gap-1">
                            @foreach($project->technologies as $tech)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-slate-100 text-secondary-700">{{ $tech }}</span>
                            @endforeach
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-secondary-900 mb-4">SEO</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Meta virsraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->meta_title ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Meta apraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $project->meta_description ?: '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
