@extends('admin.layout')

@section('page_title', 'Bloga raksti')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-secondary-500">Pārvaldiet bloga rakstus un publicēšanu.</p>
    <a href="{{ route('admin.blog-posts.create') }}"
       class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
        + Jauns raksts
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Virsraksts</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Autors</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Publicēts</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Datums</th>
                    <th class="text-right px-6 py-3 font-semibold text-secondary-700">Darbības</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($posts as $post)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-secondary-900">{{ $post->title }}</div>
                            <div class="text-xs text-secondary-500 mt-0.5">{{ $post->slug }}</div>
                        </td>
                        <td class="px-6 py-4 text-secondary-600">{{ $post->author?->name ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($post->is_published)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Publicēts</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Melnraksts</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-secondary-600">
                            {{ $post->published_at?->format('d.m.Y') ?? $post->created_at->format('d.m.Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.blog-posts.show', $post) }}" class="text-secondary-500 hover:text-primary text-xs font-medium">Skatīt</a>
                                <a href="{{ route('admin.blog-posts.edit', $post) }}" class="text-primary hover:underline text-xs font-medium">Rediģēt</a>
                                <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}" onsubmit="return confirm('Vai tiešām dzēst šo rakstu?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Dzēst</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-secondary-500">Nav rakstu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $posts->links() }}</div>
    @endif
</div>
@endsection
