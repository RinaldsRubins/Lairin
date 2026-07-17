@extends('admin.layout')

@section('page_title', 'Rediģēt projektu')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.projects.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
</div>

@php
    $technologies = old('technologies', $project->technologies ?? []);
    if (empty($technologies)) $technologies = [''];
    $gallery = old('gallery', $project->gallery ?? []);
    if (empty($gallery)) $gallery = [''];
@endphp

<form method="POST" action="{{ route('admin.projects.update', $project) }}" class="max-w-3xl">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div>
            <label for="title" class="block text-sm font-medium text-secondary-700 mb-1">Nosaukums *</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required
                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid sm:grid-cols-2 gap-6">
            <div>
                <label for="slug" class="block text-sm font-medium text-secondary-700 mb-1">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $project->slug) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="sort_order" class="block text-sm font-medium text-secondary-700 mb-1">Kārtība</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $project->sort_order) }}" min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="client" class="block text-sm font-medium text-secondary-700 mb-1">Klients</label>
                <input type="text" id="client" name="client" value="{{ old('client', $project->client) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('client') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="industry" class="block text-sm font-medium text-secondary-700 mb-1">Nozare</label>
                <input type="text" id="industry" name="industry" value="{{ old('industry', $project->industry) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('industry') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="published_at" class="block text-sm font-medium text-secondary-700 mb-1">Publicēšanas datums</label>
                <input type="datetime-local" id="published_at" name="published_at"
                       value="{{ old('published_at', $project->published_at?->format('Y-m-d\TH:i')) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('published_at') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="image" class="block text-sm font-medium text-secondary-700 mb-1">Galvenais attēls (URL)</label>
                <input type="text" id="image" name="image" value="{{ old('image', $project->image) }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-secondary-700 mb-1">Īss apraksts</label>
            <textarea id="description" name="description" rows="3"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('description', $project->description) }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-secondary-700 mb-1">Pilns saturs</label>
            <textarea id="content" name="content" rows="10"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm font-mono focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('content', $project->content) }}</textarea>
            @error('content') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-secondary-700 mb-2">Tehnoloģijas</label>
            <div class="space-y-2" id="technologies-list">
                @foreach($technologies as $tech)
                    <input type="text" name="technologies[]" value="{{ $tech }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @endforeach
            </div>
            <button type="button" onclick="addArrayField('technologies-list', 'technologies[]')"
                    class="mt-2 text-xs text-primary hover:underline">+ Pievienot tehnoloģiju</button>
            @error('technologies') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-secondary-700 mb-2">Galerija (URL)</label>
            <div class="space-y-2" id="gallery-list">
                @foreach($gallery as $url)
                    <input type="text" name="gallery[]" value="{{ $url }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @endforeach
            </div>
            <button type="button" onclick="addArrayField('gallery-list', 'gallery[]')"
                    class="mt-2 text-xs text-primary hover:underline">+ Pievienot attēlu</button>
            @error('gallery') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex flex-wrap items-center gap-6">
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" id="is_published" name="is_published" value="1" @checked(old('is_published', $project->is_published))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                <label for="is_published" class="text-sm font-medium text-secondary-700">Publicēts</label>
            </div>
            <div class="flex items-center gap-3">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                <label for="is_featured" class="text-sm font-medium text-secondary-700">Izcelts</label>
            </div>
        </div>

        <div class="border-t border-slate-200 pt-6">
            <h3 class="text-sm font-semibold text-secondary-900 mb-4">SEO</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-secondary-700 mb-1">Meta virsraksts</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $project->meta_title) }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    @error('meta_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-secondary-700 mb-1">Meta apraksts</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('meta_description', $project->meta_description) }}</textarea>
                    @error('meta_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
            Atjaunināt
        </button>
        <a href="{{ route('admin.projects.show', $project) }}" class="text-sm text-secondary-500 hover:text-secondary-700">Skatīt</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
function addArrayField(containerId, inputName) {
    const container = document.getElementById(containerId);
    const input = document.createElement('input');
    input.type = 'text';
    input.name = inputName;
    input.className = 'w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none';
    container.appendChild(input);
}
</script>
@endpush
