@extends('admin.layout')

@section('page_title', 'Jauna kategorija')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.service-categories.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
</div>

<form method="POST" action="{{ route('admin.service-categories.store') }}" class="max-w-3xl">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-6">
        <div class="grid sm:grid-cols-2 gap-6">
            <div class="sm:col-span-2">
                <label for="name" class="block text-sm font-medium text-secondary-700 mb-1">Nosaukums *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-secondary-700 mb-1">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="icon" class="block text-sm font-medium text-secondary-700 mb-1">Ikona</label>
                <input type="text" id="icon" name="icon" value="{{ old('icon') }}" placeholder="server, shield, code..."
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('icon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="sort_order" class="block text-sm font-medium text-secondary-700 mb-1">Kārtība</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                @error('sort_order') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3 pt-6">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', true))
                       class="rounded border-slate-300 text-primary focus:ring-primary">
                <label for="is_active" class="text-sm font-medium text-secondary-700">Aktīva</label>
            </div>
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-secondary-700 mb-1">Apraksts</label>
            <textarea id="description" name="description" rows="4"
                      class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('description') }}</textarea>
            @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="border-t border-slate-200 pt-6">
            <h3 class="text-sm font-semibold text-secondary-900 mb-4">SEO</h3>
            <div class="space-y-4">
                <div>
                    <label for="meta_title" class="block text-sm font-medium text-secondary-700 mb-1">Meta virsraksts</label>
                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                    @error('meta_title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="meta_description" class="block text-sm font-medium text-secondary-700 mb-1">Meta apraksts</label>
                    <textarea id="meta_description" name="meta_description" rows="2"
                              class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old('meta_description') }}</textarea>
                    @error('meta_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center gap-3">
        <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
            Saglabāt
        </button>
        <a href="{{ route('admin.service-categories.index') }}" class="text-sm text-secondary-500 hover:text-secondary-700">Atcelt</a>
    </div>
</form>
@endsection
