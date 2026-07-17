@extends('admin.layout')

@section('page_title', 'Pakalpojumu kategorijas')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-secondary-500">Pārvaldiet pakalpojumu kategorijas un to pakalpojumus.</p>
    <a href="{{ route('admin.service-categories.create') }}"
       class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
        + Jauna kategorija
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Nosaukums</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Slug</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Pakalpojumi</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Kārtība</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Statuss</th>
                    <th class="text-right px-6 py-3 font-semibold text-secondary-700">Darbības</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-secondary-900">{{ $category->name }}</div>
                            @if($category->icon)
                                <div class="text-xs text-secondary-500 mt-0.5">{{ $category->icon }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-secondary-600">{{ $category->slug }}</td>
                        <td class="px-6 py-4 text-secondary-600">{{ $category->services_count }}</td>
                        <td class="px-6 py-4 text-secondary-600">{{ $category->sort_order }}</td>
                        <td class="px-6 py-4">
                            @if($category->is_active)
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktīva</span>
                            @else
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">Neaktīva</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.service-categories.show', $category) }}" class="text-secondary-500 hover:text-primary text-xs font-medium">Skatīt</a>
                                <a href="{{ route('admin.service-categories.edit', $category) }}" class="text-primary hover:underline text-xs font-medium">Rediģēt</a>
                                <form method="POST" action="{{ route('admin.service-categories.destroy', $category) }}" onsubmit="return confirm('Vai tiešām dzēst šo kategoriju?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Dzēst</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-secondary-500">Nav kategoriju</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
