<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.customers.title') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('admin.customers.subtitle') }}</p>
            </div>
            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('admin.customers.create') }}
            </a>
        </div>
    </x-slot>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-6">
        <div class="flex flex-col lg:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('admin.customers.search_placeholder') }}"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                    />
                </div>
            </div>

            <!-- Status Filter -->
            <div class="flex flex-wrap gap-2">
                <button
                    wire:click="$set('status', '')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $status === '' ? 'bg-[#005151] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                >
                    {{ __('admin.filters.all') }} ({{ $statusCounts['all'] }})
                </button>
                <button
                    wire:click="$set('status', 'trial')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $status === 'trial' ? 'bg-amber-500 text-white' : 'bg-amber-50 text-amber-700 hover:bg-amber-100' }}"
                >
                    {{ __('admin.status.trial') }} ({{ $statusCounts['trial'] }})
                </button>
                <button
                    wire:click="$set('status', 'active')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $status === 'active' ? 'bg-green-500 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100' }}"
                >
                    {{ __('admin.status.active') }} ({{ $statusCounts['active'] }})
                </button>
                <button
                    wire:click="$set('status', 'suspended')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $status === 'suspended' ? 'bg-red-500 text-white' : 'bg-red-50 text-red-700 hover:bg-red-100' }}"
                >
                    {{ __('admin.status.suspended') }} ({{ $statusCounts['suspended'] }})
                </button>
                <button
                    wire:click="$set('status', 'cancelled')"
                    class="px-4 py-2 rounded-xl text-sm font-medium transition {{ $status === 'cancelled' ? 'bg-gray-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                >
                    {{ __('admin.status.cancelled') }} ({{ $statusCounts['cancelled'] }})
                </button>
            </div>
        </div>
    </div>

    <!-- Customer Grid -->
    @if($customers->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('admin.customers.no_customers') }}</h3>
            <p class="text-gray-500 mb-6">{{ __('admin.customers.no_customers_desc') }}</p>
            <a href="{{ route('admin.customers.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('admin.customers.create_first') }}
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($customers as $customer)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <!-- Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-[#005151]/10 rounded-xl flex items-center justify-center text-[#005151] font-bold">
                                    {{ strtoupper(substr($customer->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $customer->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $customer->org_number ?: '-' }}</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $customer->subscription_status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $customer->subscription_status === 'trial' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $customer->subscription_status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $customer->subscription_status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ __("admin.status.{$customer->subscription_status}") }}
                            </span>
                        </div>

                        <div class="mt-4 text-sm text-gray-500">
                            <p>{{ $customer->email }}</p>
                        </div>

                        @if($customer->subscription_status === 'trial' && $customer->trial_ends_at)
                            <div class="mt-3 flex items-center gap-2 text-sm">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-amber-600">
                                    {{ __('admin.customers.trial_ends', ['days' => $customer->getDaysUntilTrialEnds()]) }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Stats -->
                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                        <div class="grid grid-cols-3 gap-4 text-center">
                            <div>
                                <p class="text-lg font-semibold text-gray-900">{{ $customer->facilities_count }}</p>
                                <p class="text-xs text-gray-500">{{ __('admin.customers.facilities') }}</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900">{{ $customer->stations_count }}</p>
                                <p class="text-xs text-gray-500">{{ __('admin.customers.stations') }}</p>
                            </div>
                            <div>
                                <p class="text-lg font-semibold text-gray-900">{{ $customer->users_count }}</p>
                                <p class="text-xs text-gray-500">{{ __('admin.customers.users') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            @if($customer->subscription_status === 'trial')
                                <button
                                    wire:click="activate({{ $customer->id }})"
                                    wire:confirm="{{ __('admin.customers.confirm_activate') }}"
                                    class="text-xs px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition"
                                >
                                    {{ __('admin.actions.activate') }}
                                </button>
                            @elseif($customer->subscription_status === 'active')
                                <button
                                    wire:click="suspend({{ $customer->id }})"
                                    wire:confirm="{{ __('admin.customers.confirm_suspend') }}"
                                    class="text-xs px-3 py-1.5 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition"
                                >
                                    {{ __('admin.actions.suspend') }}
                                </button>
                            @elseif($customer->subscription_status === 'suspended')
                                <button
                                    wire:click="activate({{ $customer->id }})"
                                    wire:confirm="{{ __('admin.customers.confirm_reactivate') }}"
                                    class="text-xs px-3 py-1.5 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition"
                                >
                                    {{ __('admin.actions.reactivate') }}
                                </button>
                            @endif
                        </div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="text-[#005151] hover:text-[#005151]/80 text-sm font-medium">
                                {{ __('admin.actions.view') }}
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="text-gray-500 hover:text-gray-700 text-sm font-medium">
                                {{ __('admin.actions.edit') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $customers->links() }}
        </div>
    @endif
</div>
