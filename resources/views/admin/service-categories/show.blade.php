@extends('admin.layout')

@section('page_title', $category->name)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.service-categories.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.service-categories.edit', $category) }}"
           class="inline-flex items-center px-4 py-2 bg-white border border-slate-300 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-colors">
            Rediģēt
        </a>
        <form method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" onsubmit="return confirm('Vai tiešām dzēst šo kategoriju?')">
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
            <h2 class="text-lg font-bold text-secondary-900 mb-4">Informācija</h2>
            <dl class="grid sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Nosaukums</dt>
                    <dd class="font-semibold text-secondary-900 mt-1">{{ $category->name }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Slug</dt>
                    <dd class="font-semibold text-secondary-900 mt-1">{{ $category->slug }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Ikona</dt>
                    <dd class="font-semibold text-secondary-900 mt-1">{{ $category->icon ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Kārtība</dt>
                    <dd class="font-semibold text-secondary-900 mt-1">{{ $category->sort_order }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Statuss</dt>
                    <dd class="mt-1">
                        @if($category->is_active)
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktīva</span>
                        @else
                            <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Neaktīva</span>
                        @endif
                    </dd>
                </div>
            </dl>
            @if($category->description)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <dt class="text-sm text-secondary-500 mb-2">Apraksts</dt>
                    <dd class="text-sm text-secondary-800 whitespace-pre-line">{{ $category->description }}</dd>
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200">
                <h2 class="font-bold text-secondary-900">Pakalpojumi ({{ $category->services->count() }})</h2>
            </div>
            <div class="divide-y divide-slate-100">
                @forelse($category->services as $service)
                    <div class="px-6 py-4 flex items-center justify-between">
                        <div>
                            <div class="font-semibold text-secondary-900 text-sm">{{ $service->name }}</div>
                            <div class="text-xs text-secondary-500">{{ $service->slug }}</div>
                        </div>
                        <div class="flex items-center gap-2 text-xs">
                            @if($service->is_bookable)
                                <span class="px-2 py-0.5 rounded-full bg-primary/10 text-primary font-medium">Rezervējams</span>
                            @endif
                            @if($service->is_active)
                                <span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-medium">Aktīvs</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-medium">Neaktīvs</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="px-6 py-8 text-center text-secondary-500 text-sm">Nav pakalpojumu</div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-sm font-bold text-secondary-900 mb-4">SEO</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-secondary-500">Meta virsraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $category->meta_title ?: '—' }}</dd>
                </div>
                <div>
                    <dt class="text-secondary-500">Meta apraksts</dt>
                    <dd class="text-secondary-900 mt-1">{{ $category->meta_description ?: '—' }}</dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
