<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h1>
                    <p class="mt-1 text-sm text-gray-500">{{ __('admin.customers.edit_subtitle') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($customer->subscription_status === 'trial')
                    <button
                        wire:click="extendTrial(14)"
                        class="px-4 py-2 text-sm font-medium text-amber-700 bg-amber-100 hover:bg-amber-200 rounded-xl transition"
                    >
                        {{ __('admin.actions.extend_trial') }}
                    </button>
                    <button
                        wire:click="activate"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-xl transition"
                    >
                        {{ __('admin.actions.activate') }}
                    </button>
                @elseif($customer->subscription_status === 'active')
                    <button
                        wire:click="suspend"
                        wire:confirm="{{ __('admin.customers.confirm_suspend') }}"
                        class="px-4 py-2 text-sm font-medium text-red-700 bg-red-100 hover:bg-red-200 rounded-xl transition"
                    >
                        {{ __('admin.actions.suspend') }}
                    </button>
                @elseif($customer->subscription_status === 'suspended')
                    <button
                        wire:click="activate"
                        class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-xl transition"
                    >
                        {{ __('admin.actions.reactivate') }}
                    </button>
                @endif
                <a href="{{ route('admin.customers.show', $customer) }}"
                   class="px-4 py-2 text-sm font-medium text-[#005151] bg-gray-100 hover:bg-gray-200 rounded-xl transition">
                    {{ __('admin.actions.view_details') }}
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
            <p class="text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex gap-8">
            <button
                wire:click="setTab('basic')"
                class="pb-4 px-1 text-sm font-medium border-b-2 transition
                    {{ $activeTab === 'basic' ? 'border-[#005151] text-[#005151]' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
            >
                {{ __('admin.tabs.basic_info') }}
            </button>
            <button
                wire:click="setTab('subscription')"
                class="pb-4 px-1 text-sm font-medium border-b-2 transition
                    {{ $activeTab === 'subscription' ? 'border-[#005151] text-[#005151]' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
            >
                {{ __('admin.tabs.subscription') }}
            </button>
            <button
                wire:click="setTab('usage')"
                class="pb-4 px-1 text-sm font-medium border-b-2 transition
                    {{ $activeTab === 'usage' ? 'border-[#005151] text-[#005151]' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
            >
                {{ __('admin.tabs.usage') }}
            </button>
            <button
                wire:click="setTab('users')"
                class="pb-4 px-1 text-sm font-medium border-b-2 transition
                    {{ $activeTab === 'users' ? 'border-[#005151] text-[#005151]' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
            >
                {{ __('admin.tabs.users') }}
                <span class="ml-2 px-2 py-0.5 text-xs bg-gray-100 text-gray-600 rounded-full">{{ $customer->users_count ?? $customer->users->count() }}</span>
            </button>
        </nav>
    </div>

    <form wire:submit="save">
        <!-- Basic Info Tab -->
        @if($activeTab === 'basic')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Company Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.company_info') }}</h3>

                    <div class="space-y-5">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="name"
                                wire:model="name"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
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
                            />
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
                            />
                        </div>
                    </div>
                </div>

                <!-- Address -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.address') }}</h3>

                    <div class="space-y-5">
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.address') }}
                            </label>
                            <input
                                type="text"
                                id="address"
                                wire:model="address"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                            />
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
                                />
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
                                />
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
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Subscription Tab -->
        @if($activeTab === 'subscription')
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Status & Subscription -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.subscription_status') }}</h3>

                    <div class="space-y-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                {{ __('admin.fields.subscription_status') }}
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
                            </div>
                        @endif

                        <div class="pt-4 border-t border-gray-100">
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

                        <div>
                            <label class="flex items-center gap-3 p-4 rounded-xl border-2 cursor-pointer transition
                                {{ $is_active ? 'border-green-500 bg-green-50' : 'border-gray-200 hover:border-gray-300' }}">
                                <input
                                    type="checkbox"
                                    wire:model.live="is_active"
                                    class="w-5 h-5 rounded border-gray-300 text-green-600 focus:ring-green-500"
                                />
                                <div>
                                    <span class="font-medium text-gray-900">{{ __('admin.fields.is_active') }}</span>
                                    <p class="text-sm text-gray-500">{{ __('admin.fields.is_active_desc') }}</p>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Limits -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('admin.sections.limits') }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ __('admin.sections.limits_desc') }}</p>

                    <div class="space-y-5">
                        <div>
                            <label for="max_facilities" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_facilities') }}
                            </label>
                            <div class="flex items-center gap-3">
                                <input
                                    type="number"
                                    id="max_facilities"
                                    wire:model="max_facilities"
                                    min="1"
                                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                    placeholder="{{ __('admin.placeholders.unlimited') }}"
                                />
                                <span class="text-sm text-gray-500">{{ __('admin.current') }}: {{ $customer->facilities_count }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="max_stations" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_stations') }}
                            </label>
                            <div class="flex items-center gap-3">
                                <input
                                    type="number"
                                    id="max_stations"
                                    wire:model="max_stations"
                                    min="1"
                                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                    placeholder="{{ __('admin.placeholders.unlimited') }}"
                                />
                                <span class="text-sm text-gray-500">{{ __('admin.current') }}: {{ $stationsCount }}</span>
                            </div>
                        </div>

                        <div>
                            <label for="max_scans_per_month" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.fields.max_scans_per_month') }}
                            </label>
                            <div class="flex items-center gap-3">
                                <input
                                    type="number"
                                    id="max_scans_per_month"
                                    wire:model="max_scans_per_month"
                                    min="1"
                                    class="flex-1 px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                    placeholder="{{ __('admin.placeholders.unlimited') }}"
                                />
                                <span class="text-sm text-gray-500">{{ __('admin.current') }}: {{ $customer->getCurrentMonthScans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Usage Tab -->
        @if($activeTab === 'usage')
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.usage_history') }}</h3>

                @if($usageStats->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="text-gray-500">{{ __('admin.usage.no_data') }}</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                                    <th class="pb-3 font-medium">{{ __('admin.usage.period') }}</th>
                                    <th class="pb-3 font-medium text-right">{{ __('admin.usage.scans') }}</th>
                                    <th class="pb-3 font-medium text-right">{{ __('admin.usage.limit') }}</th>
                                    <th class="pb-3 font-medium text-right">{{ __('admin.usage.usage_percent') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($usageStats as $usage)
                                    @php
                                        $limit = $customer->max_scans_per_month;
                                        $percent = $limit ? round(($usage->scan_count / $limit) * 100) : null;
                                    @endphp
                                    <tr>
                                        <td class="py-4 font-medium text-gray-900">
                                            {{ \Carbon\Carbon::create($usage->year, $usage->month)->translatedFormat('F Y') }}
                                        </td>
                                        <td class="py-4 text-right">{{ number_format($usage->scan_count) }}</td>
                                        <td class="py-4 text-right text-gray-500">
                                            {{ $limit ? number_format($limit) : __('admin.unlimited') }}
                                        </td>
                                        <td class="py-4 text-right">
                                            @if($percent !== null)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $percent >= 90 ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $percent >= 70 && $percent < 90 ? 'bg-amber-100 text-amber-800' : '' }}
                                                    {{ $percent < 70 ? 'bg-green-100 text-green-800' : '' }}
                                                ">
                                                    {{ $percent }}%
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        @endif

        <!-- Users Tab -->
        @if($activeTab === 'users')
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Add New User Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('admin.users.add_user') }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ __('admin.users.add_user_desc') }}</p>

                    <div class="space-y-4">
                        <div>
                            <label for="newUserName" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.users.name') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="newUserName"
                                wire:model="newUserName"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.users.name_placeholder') }}"
                            />
                            @error('newUserName') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="newUserEmail" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.users.email') }} <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                id="newUserEmail"
                                wire:model="newUserEmail"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                                placeholder="{{ __('admin.users.email_placeholder') }}"
                            />
                            @error('newUserEmail') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="newUserRole" class="block text-sm font-medium text-gray-700 mb-2">
                                {{ __('admin.users.role') }}
                            </label>
                            <select
                                id="newUserRole"
                                wire:model="newUserRole"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                            >
                                <option value="admin">{{ __('admin.users.role_admin') }}</option>
                                <option value="editor">{{ __('admin.users.role_editor') }}</option>
                                <option value="user">{{ __('admin.users.role_user') }}</option>
                            </select>
                        </div>

                        <div class="pt-2">
                            <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 cursor-pointer hover:bg-gray-50 transition">
                                <input
                                    type="checkbox"
                                    wire:model="sendWelcomeEmail"
                                    class="w-5 h-5 rounded border-gray-300 text-[#005151] focus:ring-[#005151]"
                                />
                                <div>
                                    <span class="font-medium text-gray-900 text-sm">{{ __('admin.users.send_welcome_email') }}</span>
                                    <p class="text-xs text-gray-500">{{ __('admin.users.send_welcome_email_desc') }}</p>
                                </div>
                            </label>
                        </div>

                        <div class="flex gap-3 pt-4">
                            <button
                                type="button"
                                wire:click="addUser"
                                class="flex-1 px-4 py-3 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition"
                            >
                                {{ __('admin.users.add_button') }}
                            </button>
                        </div>

                        <div class="pt-4 border-t border-gray-100">
                            <button
                                type="button"
                                wire:click="sendTestEmail"
                                class="w-full px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition flex items-center justify-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ __('admin.users.test_email') }}
                            </button>
                            <p class="mt-2 text-xs text-gray-500 text-center">{{ __('admin.users.test_email_hint') }}</p>
                        </div>
                    </div>
                </div>

                <!-- User List -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.users.existing_users') }}</h3>

                    @if($customer->users->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <p class="text-gray-500">{{ __('admin.users.no_users') }}</p>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                                        <th class="pb-3 font-medium">{{ __('admin.users.name') }}</th>
                                        <th class="pb-3 font-medium">{{ __('admin.users.email') }}</th>
                                        <th class="pb-3 font-medium">{{ __('admin.users.role') }}</th>
                                        <th class="pb-3 font-medium text-right">{{ __('admin.users.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($customer->users as $user)
                                        <tr>
                                            <td class="py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-9 h-9 rounded-full bg-[#005151] flex items-center justify-center text-white font-semibold text-sm">
                                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                                    </div>
                                                    <span class="font-medium text-gray-900">{{ $user->name }}</span>
                                                </div>
                                            </td>
                                            <td class="py-4 text-gray-600">{{ $user->email }}</td>
                                            <td class="py-4">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $user->role === 'editor' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $user->role === 'user' ? 'bg-gray-100 text-gray-800' : '' }}
                                                    {{ $user->role === 'super_admin' ? 'bg-red-100 text-red-800' : '' }}
                                                ">
                                                    @if($user->role === 'admin')
                                                        {{ __('admin.users.role_admin') }}
                                                    @elseif($user->role === 'editor')
                                                        {{ __('admin.users.role_editor') }}
                                                    @elseif($user->role === 'super_admin')
                                                        {{ __('admin.users.role_super_admin') }}
                                                    @else
                                                        {{ __('admin.users.role_user') }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button
                                                        type="button"
                                                        wire:click="resendWelcomeEmail({{ $user->id }})"
                                                        class="p-2 text-gray-400 hover:text-[#005151] hover:bg-gray-100 rounded-lg transition"
                                                        title="{{ __('admin.users.resend_welcome') }}"
                                                    >
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                        </svg>
                                                    </button>
                                                    @if($user->role !== 'super_admin')
                                                        <button
                                                            type="button"
                                                            wire:click="removeUser({{ $user->id }})"
                                                            wire:confirm="{{ __('admin.users.confirm_remove') }}"
                                                            class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition"
                                                            title="{{ __('admin.users.remove') }}"
                                                        >
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Save Button -->
        @if($activeTab !== 'usage' && $activeTab !== 'users')
            <div class="mt-6 flex justify-end">
                <button
                    type="submit"
                    class="px-8 py-3 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition"
                >
                    {{ __('admin.actions.save_changes') }}
                </button>
            </div>
        @endif
    </form>
</div>
