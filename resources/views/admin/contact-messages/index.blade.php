@extends('admin.layout')

@section('page_title', 'Kontaktu ziņas')

@section('content')
<div class="mb-6">
    <p class="text-sm text-secondary-500">Saņemtās ziņas no kontaktu formas.</p>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700 w-8"></th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Temats</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Sūtītājs</th>
                    <th class="text-left px-6 py-3 font-semibold text-secondary-700">Datums</th>
                    <th class="text-right px-6 py-3 font-semibold text-secondary-700">Darbības</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($messages as $message)
                    <tr class="hover:bg-slate-50 {{ !$message->is_read ? 'bg-primary/5' : '' }}">
                        <td class="px-6 py-4">
                            @if(!$message->is_read)
                                <span class="inline-block w-2 h-2 rounded-full bg-primary" title="Nelasīts"></span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-secondary-900">{{ $message->subject }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-secondary-900">{{ $message->name }}</div>
                            <div class="text-xs text-secondary-500">{{ $message->email }}</div>
                        </td>
                        <td class="px-6 py-4 text-secondary-600">{{ $message->created_at->format('d.m.Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contact-messages.show', $message) }}" class="text-primary hover:underline text-xs font-medium">Skatīt</a>
                                <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Vai tiešām dzēst šo ziņu?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline text-xs font-medium">Dzēst</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-secondary-500">Nav ziņu</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($messages->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">{{ $messages->links() }}</div>
    @endif
</div>
@endsection
