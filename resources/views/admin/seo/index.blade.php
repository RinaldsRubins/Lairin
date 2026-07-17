@extends('admin.layout')

@section('page_title', 'SEO iestatījumi')

@section('content')
<div class="mb-6">
    <p class="text-sm text-secondary-500">Rediģējiet meta datus katram vietnes ceļam.</p>
</div>

<form method="POST" action="{{ route('admin.seo.update') }}">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        @foreach($pages as $index => $page)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <input type="hidden" name="pages[{{ $index }}][id]" value="{{ $page->id }}">

                <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-200">
                    <span class="inline-flex px-2.5 py-1 rounded-lg bg-slate-100 text-xs font-mono text-secondary-700">{{ $page->path }}</span>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="pages_{{ $index }}_title" class="block text-sm font-medium text-secondary-700 mb-1">Virsraksts</label>
                        <input type="text" id="pages_{{ $index }}_title" name="pages[{{ $index }}][title]"
                               value="{{ old("pages.{$index}.title", $page->title) }}"
                               class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                        @error("pages.{$index}.title") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="pages_{{ $index }}_description" class="block text-sm font-medium text-secondary-700 mb-1">Apraksts</label>
                        <textarea id="pages_{{ $index }}_description" name="pages[{{ $index }}][description]" rows="2"
                                  class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old("pages.{$index}.description", $page->description) }}</textarea>
                        @error("pages.{$index}.description") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="pages_{{ $index }}_keywords" class="block text-sm font-medium text-secondary-700 mb-1">Atslēgvārdi</label>
                            <input type="text" id="pages_{{ $index }}_keywords" name="pages[{{ $index }}][keywords]"
                                   value="{{ old("pages.{$index}.keywords", $page->keywords) }}"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            @error("pages.{$index}.keywords") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="pages_{{ $index }}_og_image" class="block text-sm font-medium text-secondary-700 mb-1">OG attēls (URL)</label>
                            <input type="text" id="pages_{{ $index }}_og_image" name="pages[{{ $index }}][og_image]"
                                   value="{{ old("pages.{$index}.og_image", $page->og_image) }}"
                                   class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            @error("pages.{$index}.og_image") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    @if($pages->isEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center text-secondary-500">
            Nav SEO lapu. Pievienojiet ierakstus datubāzē.
        </div>
    @else
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                Saglabāt SEO datus
            </button>
        </div>
    @endif
</form>
@endsection
