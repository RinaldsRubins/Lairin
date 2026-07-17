@extends('admin.layout')

@section('page_title', 'Projekti')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-secondary-500">Pārvaldiet realizētos projektus un portfolio.</p>
    <a href="{{ route('admin.projects.create') }}"
       class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
        + Jauns projekts
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Projekts</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Klients</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Nozare</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Statuss</th>
                    <th class="text-right px-6 py-3 font-semibold text-secondary-700">Darbības</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($projects as $project)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-secondary-900">{{ $project->title }}</div>
                            <div class="text-xs text-secondary-500 mt-0.5">{{ $project->slug }}</div>
                        </td>
                        <td class="px-6 py-4 text-secondary-600">{{ $project->client ?: '—' }}</td>
                        <td class="px-6 py-4 text-secondary-600">{{ $project->industry ?: '—' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @if($project->is_published)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Publicēts</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Melnraksts</span>
                                @endif
                                @if($project->is_featured)
                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">Izcelts</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.projects.show', $project) }}" class="text-secondary-500 hover:text-primary text-xs font-medium">Skatīt</a>
                                <a href="{{ route('admin.projects.edit', $project) }}" class="text-primary hover:underline text-xs font-medium">Rediģēt</a>
                                <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" onsubmit="return confirm('Vai tiešām dzēst šo projektu?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Dzēst</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-secondary-500">Nav projektu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($projects->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $projects->links() }}</div>
    @endif
</div>
@endsection
