<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('stations.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('scanit.actions.back') }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $isEdit ? __('scanit.stations.edit') : __('scanit.stations.create') }}
            </h1>
        </div>

        {{-- Form --}}
        <form wire:submit="save" class="space-y-6">
            {{-- Basic Info --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.stations.title') }}</h2>

                <div class="space-y-5">
                    {{-- Facility --}}
                    <div>
                        <label for="facility_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.facility') }} <span class="text-red-500">*</span>
                        </label>
                        <select
                            id="facility_id"
                            wire:model="facility_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        >
                            <option value="">{{ __('scanit.stations.select_facility') }}</option>
                            @foreach($facilities as $facility)
                                <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                            @endforeach
                        </select>
                        @error('facility_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.name') }} <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            wire:model="name"
                            placeholder="{{ __('scanit.stations.name_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        />
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.description') }}
                        </label>
                        <textarea
                            id="description"
                            wire:model="description"
                            rows="2"
                            placeholder="{{ __('scanit.stations.description_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors resize-none"
                        ></textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Location Description --}}
                    <div>
                        <label for="location_description" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.location_description') }}
                        </label>
                        <input
                            type="text"
                            id="location_description"
                            wire:model="location_description"
                            placeholder="{{ __('scanit.stations.location_description_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                        />
                        @error('location_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Innehåll för besökare</h2>

                <div class="space-y-5">
                    {{-- Info Page Text --}}
                    <div>
                        <label for="info_page_text" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.info_page_text') }}
                        </label>
                        <textarea
                            id="info_page_text"
                            wire:model="info_page_text"
                            rows="4"
                            placeholder="{{ __('scanit.stations.info_page_text_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors resize-none"
                        ></textarea>
                        @error('info_page_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Thank You Text --}}
                    <div>
                        <label for="thank_you_text" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('scanit.stations.thank_you_text') }}
                        </label>
                        <textarea
                            id="thank_you_text"
                            wire:model="thank_you_text"
                            rows="2"
                            placeholder="{{ __('scanit.stations.thank_you_text_placeholder') }}"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors resize-none"
                        ></textarea>
                        @error('thank_you_text')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Branding Override --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Varumärke</h2>
                <p class="text-sm text-gray-500 mb-6">Stationen använder anläggningens varumärke som standard. Aktivera anpassat varumärke för att använda ett annat.</p>

                {{-- Show facility branding info --}}
                @if($selectedFacility && $selectedFacility->hasCustomBranding())
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-blue-800">Anläggningen har varumärke:</span>
                                @if($selectedFacility->branding_logo_url)
                                    <img src="{{ $selectedFacility->branding_logo_url }}" alt="" class="h-6 max-w-[100px] object-contain">
                                @endif
                                @if($selectedFacility->branding_service_name)
                                    <span class="font-medium text-blue-900">{{ $selectedFacility->branding_service_name }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Custom branding toggle --}}
                <label class="flex items-center gap-3 cursor-pointer mb-6">
                    <input
                        type="checkbox"
                        wire:model.live="use_custom_branding"
                        class="w-5 h-5 rounded border-gray-300 text-[#97d700] focus:ring-[#97d700]"
                    />
                    <span class="text-gray-700 font-medium">Använd anpassat varumärke för denna station</span>
                </label>

                @if($use_custom_branding)
                    <div class="space-y-5 pt-4 border-t border-gray-100">
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
                                            <p class="text-sm text-gray-600">Ny logotyp</p>
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
                                    <span class="text-gray-400 text-sm">Ladda upp en logotyp för att se förhandsvisning</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Settings --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Inställningar</h2>

                <div class="space-y-5">
                    <div class="grid md:grid-cols-2 gap-5">
                        {{-- Max Images --}}
                        <div>
                            <label for="max_images" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.stations.max_images') }}
                            </label>
                            <select
                                id="max_images"
                                wire:model="max_images"
                                class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                            >
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- Primary Color --}}
                        <div>
                            <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('scanit.stations.primary_color') }}
                            </label>
                            <div class="flex items-center gap-3">
                                <input
                                    type="color"
                                    id="primary_color"
                                    wire:model="primary_color"
                                    class="w-12 h-12 rounded-lg border border-gray-200 cursor-pointer"
                                />
                                <input
                                    type="text"
                                    wire:model="primary_color"
                                    class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                                />
                            </div>
                        </div>
                    </div>

                    {{-- Toggles --}}
                    <div class="space-y-4 pt-4">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="is_active"
                                class="w-5 h-5 rounded border-gray-300 text-[#97d700] focus:ring-[#97d700]"
                            />
                            <span class="text-gray-700">{{ __('scanit.stations.is_active') }}</span>
                        </label>

                        <label class="flex items-center gap-3 cursor-pointer">
                            <input
                                type="checkbox"
                                wire:model="require_email"
                                class="w-5 h-5 rounded border-gray-300 text-[#97d700] focus:ring-[#97d700]"
                            />
                            <span class="text-gray-700">{{ __('scanit.stations.require_email') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('stations.index') }}" class="px-6 py-3 text-gray-700 font-medium hover:bg-gray-100 rounded-xl transition-colors">
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
