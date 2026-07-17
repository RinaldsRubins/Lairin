<div>
    @if($submitted)
        <div class="text-center py-8">
            <div class="w-16 h-16 mx-auto rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400 mb-4">
                <x-icon name="check" class="w-8 h-8" />
            </div>
            <h3 class="text-xl font-bold text-secondary-900 dark:text-white mb-2">Paldies!</h3>
            <p class="text-secondary-600 dark:text-slate-400">{{ session('contact_success') ?? 'Jūsu ziņa ir nosūtīta.' }}</p>
        </div>
    @else
        <form wire:submit="submit" class="space-y-5">
            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="contact-name" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Vārds *</label>
                    <input type="text" id="contact-name" wire:model="name"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                           placeholder="Jūsu vārds">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact-email" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">E-pasts *</label>
                    <input type="email" id="contact-email" wire:model="email"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                           placeholder="jums@uznemums.lv">
                    @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="contact-phone" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Tālrunis</label>
                    <input type="tel" id="contact-phone" wire:model="phone"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                           placeholder="+371 20000000">
                    @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact-subject" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Temats *</label>
                    <input type="text" id="contact-subject" wire:model="subject"
                           class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                           placeholder="Ziņas temats">
                    @error('subject') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="contact-message" class="block text-sm font-medium text-secondary-700 dark:text-slate-300 mb-1.5">Ziņa *</label>
                <textarea id="contact-message" wire:model="message" rows="5"
                          class="w-full rounded-xl border-secondary-200 dark:border-slate-600 dark:bg-secondary-800 dark:text-white focus:border-primary focus:ring-primary"
                          placeholder="Aprakstiet savu jautājumu vai vajadzību..."></textarea>
                @error('message') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 rounded-xl bg-gradient-to-r from-primary to-accent text-white font-semibold hover:-translate-y-0.5 transition-all disabled:opacity-50"
                    wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="submit">Nosūtīt ziņu</span>
                <span wire:loading wire:target="submit">Nosūta...</span>
            </button>
        </form>
    @endif
</div>
