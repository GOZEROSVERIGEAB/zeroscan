<div>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.customers.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.customers.create_title') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('admin.customers.create_subtitle') }}</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @foreach([
                    ['step' => 1, 'label' => __('admin.wizard.step_basic')],
                    ['step' => 2, 'label' => __('admin.wizard.step_address')],
                    ['step' => 3, 'label' => __('admin.wizard.step_subscription')],
                    ['step' => 4, 'label' => __('admin.wizard.step_limits')],
                ] as $stepInfo)
                    <div class="flex items-center {{ $stepInfo['step'] < $totalSteps ? 'flex-1' : '' }}">
                        <button
                            wire:click="goToStep({{ $stepInfo['step'] }})"
                            @if($stepInfo['step'] > $currentStep) disabled @endif
                            class="flex flex-col items-center {{ $stepInfo['step'] <= $currentStep ? 'cursor-pointer' : 'cursor-not-allowed' }}"
                        >
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-sm font-semibold transition
                                {{ $stepInfo['step'] < $currentStep ? 'bg-[#97d700] text-[#005151]' : '' }}
                                {{ $stepInfo['step'] === $currentStep ? 'bg-[#005151] text-white' : '' }}
                                {{ $stepInfo['step'] > $currentStep ? 'bg-gray-200 text-gray-500' : '' }}
                            ">
                                @if($stepInfo['step'] < $currentStep)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @else
                                    {{ $stepInfo['step'] }}
                                @endif
                            </div>
                            <span class="mt-2 text-xs font-medium {{ $stepInfo['step'] === $currentStep ? 'text-[#005151]' : 'text-gray-500' }}">
                                {{ $stepInfo['label'] }}
                            </span>
                        </button>
                        @if($stepInfo['step'] < $totalSteps)
                            <div class="flex-1 h-0.5 mx-4 {{ $stepInfo['step'] < $currentStep ? 'bg-[#97d700]' : 'bg-gray-200' }}"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <form wire:submit="save">
                <!-- Step 1: Basic Info -->
                @if($currentStep === 1)
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.wizard.basic_info') }}</h2>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.placeholders.company_name') }}"
                            />
                            @error('name') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="org_number" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.org_number') }}
                            </label>
                            <input
                                type="text"
                                id="org_number"
                                wire:model="org_number"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="556123-4567"
                            />
                            @error('org_number') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="email"
                                wire:model="email"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="info@foretag.se"
                            />
                            @error('email') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.phone') }}
                            </label>
                            <input
                                type="tel"
                                id="phone"
                                wire:model="phone"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="+46 70 123 45 67"
                            />
                            @error('phone') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 2: Address -->
                @if($currentStep === 2)
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.wizard.address_info') }}</h2>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.address') }}
                            </label>
                            <input
                                type="text"
                                id="address"
                                wire:model="address"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.placeholders.address') }}"
                            />
                            @error('address') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('admin.fields.postal_code') }}
                                </label>
                                <input
                                    type="text"
                                    id="postal_code"
                                    wire:model="postal_code"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                    placeholder="123 45"
                                />
                                @error('postal_code') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('admin.fields.city') }}
                                </label>
                                <input
                                    type="text"
                                    id="city"
                                    wire:model="city"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                    placeholder="{{ __('admin.placeholders.city') }}"
                                />
                                @error('city') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.country') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="country"
                                wire:model="country"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                            />
                            @error('country') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                <!-- Step 3: Subscription -->
                @if($currentStep === 3)
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.wizard.subscription_info') }}</h2>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                {{ __('admin.fields.subscription_status') }} <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                @foreach(['trial', 'active', 'suspended', 'cancelled'] as $status)
                                    <label class="relative flex items-center p-4 rounded-xl border-2 cursor-pointer transition
                                        {{ $subscription_status === $status ? 'border-[#005151] bg-[#005151]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                        <input
                                            type="radio"
                                            wire:model.live="subscription_status"
                                            value="{{ $status }}"
                                            class="sr-only"
                                        />
                                        <div class="flex items-center gap-3">
                                            <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center
                                                {{ $subscription_status === $status ? 'border-[#005151]' : 'border-gray-300' }}">
                                                @if($subscription_status === $status)
                                                    <div class="w-2 h-2 rounded-full bg-[#005151]"></div>
                                                @endif
                                            </div>
                                            <span class="font-medium text-gray-900">{{ __("admin.status.{$status}") }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        @if($subscription_status === 'trial')
                            <div>
                                <label for="trial_ends_at" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ __('admin.fields.trial_ends_at') }}
                                </label>
                                <input
                                    type="date"
                                    id="trial_ends_at"
                                    wire:model="trial_ends_at"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                />
                                @error('trial_ends_at') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        @endif

                        <div>
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition
                                {{ $is_enterprise ? 'border-[#005151] bg-[#005151]/5' : 'border-gray-200 hover:border-gray-300' }}">
                                <input
                                    type="checkbox"
                                    wire:model.live="is_enterprise"
                                    class="w-5 h-5 rounded border-gray-300 text-[#005151] focus:ring-[#005151]"
                                />
                                <div>
                                    <span class="font-medium text-gray-900">{{ __('admin.fields.is_enterprise') }}</span>
                                    <p class="text-sm text-gray-500">{{ __('admin.fields.is_enterprise_desc') }}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                @endif

                <!-- Step 4: Limits -->
                @if($currentStep === 4)
                    <div class="space-y-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-2">{{ __('admin.wizard.limits_info') }}</h2>
                        <p class="text-sm text-gray-500 mb-6">{{ __('admin.wizard.limits_desc') }}</p>

                        <div>
                            <label for="max_facilities" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_facilities') }}
                            </label>
                            <input
                                type="number"
                                id="max_facilities"
                                wire:model="max_facilities"
                                min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.placeholders.unlimited') }}"
                            />
                            @error('max_facilities') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="max_stations" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_stations') }}
                            </label>
                            <input
                                type="number"
                                id="max_stations"
                                wire:model="max_stations"
                                min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.placeholders.unlimited') }}"
                            />
                            @error('max_stations') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="max_scans_per_month" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_scans_per_month') }}
                            </label>
                            <input
                                type="number"
                                id="max_scans_per_month"
                                wire:model="max_scans_per_month"
                                min="1"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.placeholders.unlimited') }}"
                            />
                            @error('max_scans_per_month') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                @endif

                <!-- Navigation Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-between">
                    @if($currentStep > 1)
                        <button
                            type="button"
                            wire:click="previousStep"
                            class="px-6 py-3 text-gray-600 hover:text-gray-900 font-medium transition"
                        >
                            {{ __('admin.wizard.previous') }}
                        </button>
                    @else
                        <div></div>
                    @endif

                    @if($currentStep < $totalSteps)
                        <button
                            type="button"
                            wire:click="nextStep"
                            class="px-8 py-3 bg-[#005151] hover:bg-[#005151]/90 text-white font-semibold rounded-xl transition"
                        >
                            {{ __('admin.wizard.next') }}
                        </button>
                    @else
                        <button
                            type="submit"
                            class="px-8 py-3 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition"
                        >
                            {{ __('admin.wizard.create_customer') }}
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
