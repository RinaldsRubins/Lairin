@extends('admin.layout')

@section('page_title', $message->subject)

@section('content')
<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('admin.contact-messages.index') }}" class="text-sm text-secondary-500 hover:text-primary">← Atpakaļ uz sarakstu</a>
    <form method="POST" action="{{ route('admin.contact-messages.destroy', $message) }}" onsubmit="return confirm('Vai tiešām dzēst šo ziņu?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 text-red-700 text-sm font-semibold rounded-lg hover:bg-red-100 transition-colors">
            Dzēst
        </button>
    </form>
</div>

<div class="max-w-3xl">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <h2 class="text-xl font-bold text-secondary-900">{{ $message->subject }}</h2>
            @if(!$message->is_read)
                <span class="shrink-0 inline-flex px-2 py-0.5 rounded-full text-xs font-medium bg-primary/10 text-primary">Jauns</span>
            @endif
        </div>

        <dl class="grid sm:grid-cols-2 gap-4 text-sm mb-6 pb-6 border-b border-slate-200">
            <div>
                <dt class="text-secondary-500">Vārds</dt>
                <dd class="font-medium text-secondary-900 mt-1">{{ $message->name }}</dd>
            </div>
            <div>
                <dt class="text-secondary-500">E-pasts</dt>
                <dd class="font-medium text-secondary-900 mt-1">
                    <a href="mailto:{{ $message->email }}" class="text-primary hover:underline">{{ $message->email }}</a>
                </dd>
            </div>
            @if($message->phone)
                <div>
                    <dt class="text-secondary-500">Tālrunis</dt>
                    <dd class="font-medium text-secondary-900 mt-1">
                        <a href="tel:{{ $message->phone }}" class="text-primary hover:underline">{{ $message->phone }}</a>
                    </dd>
                </div>
            @endif
            <div>
                <dt class="text-secondary-500">Saņemts</dt>
                <dd class="font-medium text-secondary-900 mt-1">{{ $message->created_at->format('d.m.Y H:i') }}</dd>
            </div>
        </dl>

        <div>
            <h3 class="text-sm font-semibold text-secondary-700 mb-2">Ziņojums</h3>
            <div class="text-sm text-secondary-800 whitespace-pre-line leading-relaxed">{{ $message->message }}</div>
        </div>

        <div class="mt-6 pt-6 border-t border-slate-200">
            <a href="mailto:{{ $message->email }}?subject=Re: {{ rawurlencode($message->subject) }}"
               class="inline-flex items-center px-4 py-2 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                Atbildēt e-pastā
            </a>
        </div>
    </div>
</div>
@endsection
