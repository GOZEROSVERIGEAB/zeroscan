<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('scanit.actions.back') }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Varumärke</h1>
            <p class="text-gray-500 mt-1">Anpassa logotyp och tjänstnamn som visas för besökare</p>
        </div>

        {{-- Flash Messages --}}
        @if(session('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                {{ session('message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                {{ session('error') }}
            </div>
        @endif

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            {{-- Logo --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Logotyp</h2>

                <div class="space-y-4">
                    {{-- Current Logo Preview --}}
                    @if($currentLogoUrl || $logo)
                        <div class="flex items-center gap-4">
                            <div class="w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                @if($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" alt="Förhandsvisning" class="max-w-full max-h-full object-contain">
                                @elseif($currentLogoUrl)
                                    <img src="{{ $currentLogoUrl }}" alt="Nuvarande logotyp" class="max-w-full max-h-full object-contain">
                                @endif
                            </div>
                            <div>
                                @if($currentLogoUrl && !$logo)
                                    <p class="text-sm text-gray-600 mb-2">Nuvarande logotyp</p>
                                    <button
                                        type="button"
                                        wire:click="removeLogo"
                                        wire:confirm="Är du säker på att du vill ta bort logotypen?"
                                        class="text-sm text-red-600 hover:text-red-700"
                                    >
                                        Ta bort logotyp
                                    </button>
                                @else
                                    <p class="text-sm text-gray-600">Ny logotyp (inte sparad än)</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- Upload --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $currentLogoUrl ? 'Byt logotyp' : 'Ladda upp logotyp' }}
                        </label>
                        <input
                            type="file"
                            wire:model="logo"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#005151] file:text-white hover:file:bg-[#006666] file:cursor-pointer"
                        />
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG eller SVG. Max 2MB.</p>
                        @error('logo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Service Name --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Tjänstnamn</h2>

                <div>
                    <label for="service_name" class="block text-sm font-medium text-gray-700 mb-1">
                        Namn på tjänsten
                    </label>
                    <input
                        type="text"
                        id="service_name"
                        wire:model="service_name"
                        placeholder="t.ex. Återbruksportalen"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    />
                    <p class="mt-2 text-xs text-gray-500">
                        Lämna tomt för att använda "Scanit" som standardnamn.
                    </p>
                    @error('service_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Preview --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-lg font-semibold text-gray-900">Förhandsvisning</h2>
                    @if($previewStation)
                        <a
                            href="{{ route('public.scan', $previewStation->public_uuid) }}"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-[#005151] bg-[#005151]/10 rounded-lg hover:bg-[#005151]/20 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                            </svg>
                            Öppna kundvy
                        </a>
                    @endif
                </div>

                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-xs text-gray-500 mb-4">Så här kommer logotypen se ut på QR-koder och besökarsidor:</p>
                    <div class="flex items-center justify-center gap-3 py-4">
                        @if($logo)
                            <img src="{{ $logo->temporaryUrl() }}" alt="Förhandsvisning" class="h-12 max-w-[200px] object-contain">
                            @if($service_name)
                                <span class="text-2xl font-semibold text-[#005151]">{{ $service_name }}</span>
                            @endif
                        @elseif($currentLogoUrl)
                            <img src="{{ $currentLogoUrl }}" alt="Logotyp" class="h-12 max-w-[200px] object-contain">
                            @if($service_name)
                                <span class="text-2xl font-semibold text-[#005151]">{{ $service_name }}</span>
                            @endif
                        @else
                            <img src="/images/prezero-logo.svg" alt="PreZero" class="h-10">
                            <span class="text-2xl font-semibold text-[#005151]">Scan<span class="font-normal text-lg">it</span></span>
                        @endif
                    </div>
                </div>

                @if(!$previewStation)
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex gap-3">
                            <svg class="w-5 h-5 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="text-sm text-amber-800 font-medium">Ingen station tillgänglig för förhandsvisning</p>
                                <p class="text-sm text-amber-700 mt-1">Skapa en station först för att kunna förhandsgranska kundvyn.</p>
                                <a href="{{ route('stations.create') }}" class="inline-flex items-center gap-1 text-sm text-amber-800 font-medium hover:underline mt-2">
                                    Skapa station →
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="px-6 py-3 text-gray-700 font-medium hover:bg-gray-100 rounded-xl transition-colors">
                    {{ __('scanit.actions.cancel') }}
                </a>
                <button
                    type="submit"
                    class="px-8 py-3 bg-[#97d700] text-[#005151] font-semibold rounded-xl hover:bg-[#85c100] transition-colors flex items-center gap-2"
                    wire:loading.attr="disabled"
                    wire:loading.class="opacity-70 cursor-wait"
                >
                    <span wire:loading.remove>{{ __('scanit.actions.save') }}</span>
                    <span wire:loading>{{ __('scanit.loading') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
