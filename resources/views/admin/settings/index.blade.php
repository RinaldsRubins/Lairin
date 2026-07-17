@extends('admin.layout')

@section('page_title', 'Vietnes iestatījumi')

@section('content')
@php
    $groupLabels = [
        'general' => 'Vispārīgie',
        'contact' => 'Kontaktinformācija',
        'analytics' => 'Analītika',
    ];
    $keyLabels = [
        'company_name' => 'Uzņēmuma nosaukums',
        'legal_name' => 'Juridiskais nosaukums',
        'reg_number' => 'Reģistrācijas numurs',
        'vat_number' => 'PVN numurs',
        'legal_address' => 'Juridiskā adrese',
        'bank_details' => 'Bankas rekvizīti',
        'email' => 'E-pasts',
        'phone' => 'Tālrunis',
        'address' => 'Adrese',
        'maps_lat' => 'Platums (latitude)',
        'maps_lng' => 'Garums (longitude)',
        'ga_id' => 'Google Analytics ID',
        'gsc_verification' => 'Google Search Console verifikācija',
    ];
@endphp

<div class="mb-6">
    <p class="text-sm text-secondary-500">Pārvaldiet vietnes pamata informāciju un kontaktus.</p>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" class="max-w-3xl">
    @csrf
    @method('PUT')

    <div class="space-y-6">
        @php $index = 0; @endphp
        @forelse($settings as $group => $groupSettings)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                <h2 class="text-sm font-bold text-secondary-900 mb-4">{{ $groupLabels[$group] ?? ucfirst($group) }}</h2>
                <div class="space-y-4">
                    @foreach($groupSettings as $setting)
                        <div>
                            <label for="setting_{{ $setting->id }}" class="block text-sm font-medium text-secondary-700 mb-1">
                                {{ $keyLabels[$setting->key] ?? str_replace('_', ' ', ucfirst($setting->key)) }}
                            </label>
                            <input type="hidden" name="settings[{{ $index }}][id]" value="{{ $setting->id }}">
                            @if(in_array($setting->key, ['legal_address', 'bank_details'], true))
                                <textarea id="setting_{{ $setting->id }}" name="settings[{{ $index }}][value]" rows="3"
                                          class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">{{ old("settings.{$index}.value", $setting->value) }}</textarea>
                            @else
                                <input type="text" id="setting_{{ $setting->id }}" name="settings[{{ $index }}][value]"
                                       value="{{ old("settings.{$index}.value", $setting->value) }}"
                                       class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none">
                            @endif
                            @error("settings.{$index}.value") <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                        @php $index++; @endphp
                    @endforeach
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center text-secondary-500">
                Nav iestatījumu. Pievienojiet ierakstus datubāzē.
            </div>
        @endforelse
    </div>

    @if($settings->isNotEmpty())
        <div class="mt-6">
            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors">
                Saglabāt iestatījumus
            </button>
        </div>
    @endif
</form>
@endsection
