@extends('layouts.public')

@section('content')
<section class="relative py-24 overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-primary/10 via-accent/5 to-transparent"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
        <span class="text-primary font-semibold text-sm uppercase tracking-wider">Kontakti</span>
        <h1 class="text-4xl sm:text-5xl font-bold text-secondary-900 mt-2 mb-6">
            Sazinieties <span class="text-gradient">ar mums</span>
        </h1>
        <p class="text-lg text-secondary-600 max-w-2xl mx-auto">
            Mēs esam gatavi atbildēt uz jūsu jautājumiem un palīdzēt atrast optimālo IT risinājumu.
        </p>
    </div>
</section>

<section class="pb-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12">
            <div class="lg:col-span-2 space-y-6">
                <div class="glass-card">
                    <h2 class="text-xl font-bold text-secondary-900 mb-6">Kontaktinformācija</h2>
                    <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <x-icon name="mail" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="text-sm text-secondary-500">E-pasts</div>
                                <a href="mailto:{{ $company['email'] }}" class="font-semibold text-secondary-900 hover:text-primary transition-colors">{{ $company['email'] }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <x-icon name="phone" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="text-sm text-secondary-500">Tālrunis</div>
                                <a href="tel:{{ str_replace(' ', '', $company['phone']) }}" class="font-semibold text-secondary-900 hover:text-primary transition-colors">{{ $company['phone'] }}</a>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <x-icon name="location" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="text-sm text-secondary-500">Juridiskā adrese</div>
                                <div class="font-semibold text-secondary-900">{{ $company['legal_address'] }}</div>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary shrink-0">
                                <x-icon name="building" class="w-5 h-5" />
                            </div>
                            <div>
                                <div class="text-sm text-secondary-500">Uzņēmums</div>
                                <div class="font-semibold text-secondary-900">{{ $company['legal_name'] }}</div>
                                <div class="text-sm text-secondary-500">Reģ. {{ $company['registration'] }}</div>
                            </div>
                        </li>
                    </ul>
                </div>

                @if($company['vat'] || $company['bank_name'] || $company['bank_account'])
                <div class="glass-card">
                    <h3 class="font-bold text-secondary-900 mb-3">Rekvizīti</h3>
                    <dl class="space-y-2 text-sm">
                        @if($company['vat'])
                        <div class="flex justify-between gap-4"><dt class="text-secondary-500">PVN</dt><dd class="text-secondary-900 font-medium">{{ $company['vat'] }}</dd></div>
                        @endif
                        @if($company['bank_name'])
                        <div class="flex justify-between gap-4"><dt class="text-secondary-500">Banka</dt><dd class="text-secondary-900 font-medium">{{ $company['bank_name'] }}</dd></div>
                        @endif
                        @if($company['bank_account'])
                        <div class="flex justify-between gap-4"><dt class="text-secondary-500">Konts</dt><dd class="text-secondary-900 font-medium text-xs">{{ $company['bank_account'] }}</dd></div>
                        @endif
                        @if($company['bank_swift'])
                        <div class="flex justify-between gap-4"><dt class="text-secondary-500">SWIFT</dt><dd class="text-secondary-900 font-medium">{{ $company['bank_swift'] }}</dd></div>
                        @endif
                    </dl>
                </div>
                @endif

                <a href="{{ route('booking.index') }}" class="block glass-card text-center hover:border-primary/30 transition-colors group">
                    <x-icon name="calendar" class="w-8 h-8 text-primary mx-auto mb-3 group-hover:scale-110 transition-transform" />
                    <h3 class="font-bold text-secondary-900">Vēlaties konsultāciju?</h3>
                    <p class="text-sm text-secondary-500 mt-1">Pieteiciet tiešsaistes tikšanos ar mūsu ekspertu</p>
                </a>
            </div>

            <div class="lg:col-span-3">
                <div class="glass-card">
                    <h2 class="text-xl font-bold text-secondary-900 mb-6">Nosūtiet ziņu</h2>
                    @livewire('contact-form')
                </div>
            </div>
        </div>

        <div class="mt-16">
            <div class="glass-card !p-0 overflow-hidden">
                <iframe
                    src="https://maps.google.com/maps?q={{ urlencode($company['legal_address']) }}&output=embed"
                    width="100%"
                    height="400"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    title="Lairin — {{ $company['legal_address'] }}"
                    class="grayscale hover:grayscale-0 transition-all duration-500">
                </iframe>
            </div>
        </div>
    </div>
</section>
@endsection
