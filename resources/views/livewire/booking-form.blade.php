<div>
    @if($submitted)
        <div class="text-center py-8">
            <div class="w-16 h-16 mx-auto rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                <x-icon name="check" class="w-8 h-8" />
            </div>
            <h3 class="text-xl font-bold text-secondary-900 dark:text-white mb-2">Rezervācija saņemta!</h3>
            <p class="text-secondary-600 dark:text-slate-400">{{ session('booking_success') ?? 'Apstiprinājumu nosūtīsim uz jūsu e-pastu.' }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking-first-name" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Vārds *</label>
                    <input type="text" id="booking-first-name" wire:model="first_name"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    @error('first_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="booking-last-name" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Uzvārds *</label>
                    <input type="text" id="booking-last-name" wire:model="last_name"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    @error('last_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking-company" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Uzņēmums</label>
                    <input type="text" id="booking-company" wire:model="company"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    @error('company') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="booking-email" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">E-pasts *</label>
                    <input type="email" id="booking-email" wire:model="email"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="booking-phone" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Tālrunis *</label>
                <input type="tel" id="booking-phone" wire:model="phone"
                       class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="booking-service" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Pakalpojums *</label>
                <select id="booking-service" wire:model.live="service_id"
                        class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    <option value="">Izvēlieties pakalpojumu</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}@if($service->duration_minutes) ({{ $service->duration_minutes }} min)@endif</option>
                    @endforeach
                </select>
                @error('service_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-2">Tikšanās veids *</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="meeting_type" value="online" class="text-primary focus:ring-primary">
                        <span class="text-sm text-secondary-700 dark:text-slate-300">Tiešsaistē</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" wire:model="meeting_type" value="onsite" class="text-primary focus:ring-primary">
                        <span class="text-sm text-secondary-700 dark:text-slate-300">Klātienē</span>
                    </label>
                </div>
                @error('meeting_type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="booking-date" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Datums *</label>
                    <input type="date" id="booking-date" wire:model.live="date" min="{{ $minDate }}"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary">
                    @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="booking-time" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Laiks *</label>
                    <select id="booking-time" wire:model="time"
                            class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                            @if(empty($availableTimes)) disabled @endif>
                        <option value="">Izvēlieties laiku</option>
                        @foreach($availableTimes as $slot)
                            <option value="{{ $slot }}">{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    @if(empty($availableTimes) && $date)
                        <p class="mt-1 text-sm text-amber-600 dark:text-amber-400">Šajā dienā nav brīvu laiku.</p>
                    @endif
                </div>
            </div>

            <div>
                <label for="booking-comments" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Komentāri</label>
                <textarea id="booking-comments" wire:model="comments" rows="3"
                          class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                          placeholder="Papildu informācija par konsultāciju..."></textarea>
                @error('comments') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-0.5 transition-all disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">Pieteikt konsultāciju</span>
                <span wire:loading wire:target="submit">Apstrādā...</span>
            </button>
        </form>
    @endif
</div>
