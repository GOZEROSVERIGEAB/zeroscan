<div>
    @if($submitted)
        <div class="bg-white rounded-2xl p-8 text-center">
            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-800 mb-2">Tack för ditt meddelande!</h3>
            <p class="text-gray-600 mb-6">Vi återkommer inom kort.</p>
            <button wire:click="$set('submitted', false)" class="text-[#005151] font-medium hover:underline">
                Skicka ett nytt meddelande
            </button>
        </div>
    @else
        <form wire:submit="submit" class="bg-white rounded-2xl p-8 shadow-xl">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Boka en demo</h3>
                <p class="text-gray-600">Fyll i formuläret så kontaktar vi dig inom 24 timmar.</p>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <!-- Namn -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Namn *</label>
                    <input
                        type="text"
                        id="name"
                        wire:model="name"
                        placeholder="Anna Andersson"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- E-post -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-post *</label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        placeholder="anna@foretag.se"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <!-- Företag -->
                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Företag/Organisation *</label>
                    <input
                        type="text"
                        id="company"
                        wire:model="company"
                        placeholder="Kommun eller företag"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    >
                    @error('company')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telefon -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Telefon</label>
                    <input
                        type="tel"
                        id="phone"
                        wire:model="phone"
                        placeholder="070-123 45 67"
                        class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    >
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Meddelande -->
            <div class="mb-4">
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Meddelande *</label>
                <textarea
                    id="message"
                    wire:model="message"
                    rows="4"
                    placeholder="Berätta lite om era behov och hur många anläggningar ni har..."
                    class="w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors resize-none"
                ></textarea>
                @error('message')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Turnstile -->
            <div class="mb-6">
                <div
                    class="cf-turnstile"
                    data-sitekey="{{ config('turnstile.site_key') }}"
                    data-callback="onTurnstileSuccess"
                    data-theme="light"
                ></div>
                @error('cfTurnstileResponse')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button
                type="submit"
                class="w-full bg-[#97d700] hover:bg-[#85c100] text-[#005151] font-semibold py-4 px-6 rounded-lg transition-colors flex items-center justify-center gap-2"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-70 cursor-wait"
            >
                <span wire:loading.remove>Skicka förfrågan</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Skickar...
                </span>
            </button>

            <p class="text-gray-500 text-xs text-center mt-4">
                Genom att skicka godkänner du vår <a href="{{ route('legal.privacy') }}" class="underline hover:text-gray-700">integritetspolicy</a>.
            </p>
        </form>
    @endif

    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        function onTurnstileSuccess(token) {
            @this.set('cfTurnstileResponse', token);
        }
    </script>
</div>
