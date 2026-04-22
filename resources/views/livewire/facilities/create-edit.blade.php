<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('facilities.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('scanit.actions.back') }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $isEdit ? __('scanit.facilities.edit') : __('scanit.facilities.create') }}
            </h1>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.facilities.title') }}</h2>

                <div class="space-y-5">
                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.facilities.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            placeholder="{{ __('scanit.facilities.name_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.facilities.description') }}
                        </label>
                        <textarea
                            id="description"
                            wire:model="description"
                            rows="3"
                            placeholder="{{ __('scanit.facilities.description_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors resize-none"
                        ></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div class="grid md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.facilities.address') }}
                            </label>
                            <input
                                type="text"
                                id="address"
                                wire:model="address"
                                placeholder="{{ __('scanit.facilities.address_placeholder') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            />
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.facilities.postal_code') }}
                            </label>
                            <input
                                type="text"
                                id="postal_code"
                                wire:model="postal_code"
                                placeholder="{{ __('scanit.facilities.postal_code_placeholder') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            />
                            @error('postal_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.facilities.city') }}
                            </label>
                            <input
                                type="text"
                                id="city"
                                wire:model="city"
                                placeholder="{{ __('scanit.facilities.city_placeholder') }}"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            />
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Kontaktuppgifter</h2>

                <div class="space-y-5">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.facilities.contact_name') }}
                        </label>
                        <input
                            type="text"
                            id="contact_name"
                            wire:model="contact_name"
                            placeholder="{{ __('scanit.facilities.contact_name_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        />
                        @error('contact_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-5">
                        <div>
                            <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.facilities.contact_email') }}
                            </label>
                            <input
                                type="email"
                                id="contact_email"
                                wire:model="contact_email"
                                placeholder="kontakt@foretag.se"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            />
                            @error('contact_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.facilities.contact_phone') }}
                            </label>
                            <input
                                type="tel"
                                id="contact_phone"
                                wire:model="contact_phone"
                                placeholder="070-123 45 67"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            />
                            @error('contact_phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Branding --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Varumärke</h2>
                <p class="text-sm text-gray-500 mb-6">Anpassa logotyp och tjänstnamn som visas för besökare på alla stationer under denna anläggning.</p>

                <div class="space-y-5">
                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Logotyp</label>

                        @if($currentLogoUrl || $branding_logo)
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-32 h-20 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if($branding_logo)
                                        <img src="{{ $branding_logo->temporaryUrl() }}" alt="Förhandsvisning" class="max-w-full max-h-full object-contain">
                                    @elseif($currentLogoUrl)
                                        <img src="{{ $currentLogoUrl }}" alt="Nuvarande logotyp" class="max-w-full max-h-full object-contain">
                                    @endif
                                </div>
                                <div>
                                    @if($currentLogoUrl && !$branding_logo)
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
                                        <p class="text-sm text-gray-600">Ny logotyp (sparas när du klickar Spara)</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <input
                            type="file"
                            wire:model="branding_logo"
                            accept="image/*"
                            class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-[#005151] file:text-white hover:file:bg-[#006666] file:cursor-pointer"
                        />
                        <p class="mt-2 text-xs text-gray-500">PNG, JPG eller SVG. Max 2MB.</p>
                        @error('branding_logo')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Service Name --}}
                    <div>
                        <label for="branding_service_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Tjänstnamn
                        </label>
                        <input
                            type="text"
                            id="branding_service_name"
                            wire:model="branding_service_name"
                            placeholder="t.ex. Återbruksportalen"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        />
                        <p class="mt-2 text-xs text-gray-500">
                            Lämna tomt för att använda "Scanit" som standardnamn.
                        </p>
                        @error('branding_service_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview --}}
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs text-gray-500 mb-3">Förhandsvisning:</p>
                        <div class="flex items-center justify-center gap-3 py-2">
                            @if($branding_logo)
                                <img src="{{ $branding_logo->temporaryUrl() }}" alt="Förhandsvisning" class="h-10 max-w-[160px] object-contain">
                                @if($branding_service_name)
                                    <span class="text-xl font-semibold text-[#005151]">{{ $branding_service_name }}</span>
                                @endif
                            @elseif($currentLogoUrl)
                                <img src="{{ $currentLogoUrl }}" alt="Logotyp" class="h-10 max-w-[160px] object-contain">
                                @if($branding_service_name)
                                    <span class="text-xl font-semibold text-[#005151]">{{ $branding_service_name }}</span>
                                @endif
                            @else
                                <img src="/images/prezero-logo.svg" alt="PreZero" class="h-8">
                                <span class="text-xl font-semibold text-[#005151]">Scan<span class="font-normal text-base">it</span></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Settings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Inställningar</h2>

                <label class="flex items-center gap-3 cursor-pointer">
                    <input
                        type="checkbox"
                        wire:model="is_active"
                        class="w-5 h-5 rounded border-gray-300 text-[#97d700] focus:ring-[#97d700]"
                    />
                    <span class="text-gray-700">{{ __('scanit.facilities.is_active') }}</span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('facilities.index') }}" class="px-6 py-3 text-gray-700 font-medium hover:bg-gray-100 rounded-xl transition-colors">
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
