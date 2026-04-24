<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.customers.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-[#005151]/10 rounded-xl flex items-center justify-center text-[#005151] font-bold text-lg">
                        {{ strtoupper(substr($customer->name, 0, 2)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h1>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $customer->subscription_status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $customer->subscription_status === 'trial' ? 'bg-amber-100 text-amber-800' : '' }}
                                {{ $customer->subscription_status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $customer->subscription_status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ __("admin.status.{$customer->subscription_status}") }}
                            </span>
                            @if($customer->is_enterprise)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    Enterprise
                                </span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500">{{ $customer->org_number ?: '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @if($customer->subscription_status === 'trial')
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
                <a href="{{ route('admin.customers.edit', $customer) }}"
                   class="px-4 py-2 text-sm font-medium text-white bg-[#005151] hover:bg-[#005151]/90 rounded-xl transition">
                    {{ __('admin.actions.edit') }}
                </a>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $customer->facilities_count }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.stats.facilities') }}</p>
                </div>
            </div>
            @if($customer->max_facilities)
                <div class="mt-3 text-xs text-gray-500">
                    {{ __('admin.stats.limit') }}: {{ $customer->max_facilities }}
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $stationsCount }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.stats.stations') }}</p>
                </div>
            </div>
            @if($customer->max_stations)
                <div class="mt-3 text-xs text-gray-500">
                    {{ __('admin.stats.limit') }}: {{ $customer->max_stations }}
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#97d700]/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($customer->getCurrentMonthScans()) }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.stats.scans_month') }}</p>
                </div>
            </div>
            @if($customer->max_scans_per_month)
                <div class="mt-3 text-xs text-gray-500">
                    {{ __('admin.stats.limit') }}: {{ number_format($customer->max_scans_per_month) }}
                </div>
            @endif
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#005151]/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $customer->users_count }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.stats.users') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.details') }}</h3>

            <dl class="space-y-4">
                <div>
                    <dt class="text-sm text-gray-500">{{ __('admin.fields.email') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900">{{ $customer->email }}</dd>
                </div>
                @if($customer->phone)
                    <div>
                        <dt class="text-sm text-gray-500">{{ __('admin.fields.phone') }}</dt>
                        <dd class="mt-1 font-medium text-gray-900">{{ $customer->phone }}</dd>
                    </div>
                @endif
                @if($customer->address)
                    <div>
                        <dt class="text-sm text-gray-500">{{ __('admin.fields.address') }}</dt>
                        <dd class="mt-1 font-medium text-gray-900">
                            {{ $customer->address }}<br>
                            {{ $customer->postal_code }} {{ $customer->city }}<br>
                            {{ $customer->country }}
                        </dd>
                    </div>
                @endif
                <div class="pt-4 border-t border-gray-100">
                    <dt class="text-sm text-gray-500">{{ __('admin.fields.created_at') }}</dt>
                    <dd class="mt-1 font-medium text-gray-900">{{ $customer->created_at->format('j M Y H:i') }}</dd>
                </div>
                @if($customer->subscription_status === 'trial' && $customer->trial_ends_at)
                    <div>
                        <dt class="text-sm text-gray-500">{{ __('admin.fields.trial_ends_at') }}</dt>
                        <dd class="mt-1 font-medium {{ $customer->isTrialExpired() ? 'text-red-600' : 'text-amber-600' }}">
                            {{ $customer->trial_ends_at->format('j M Y') }}
                            @if(!$customer->isTrialExpired())
                                ({{ $customer->getDaysUntilTrialEnds() }} {{ __('admin.days_left') }})
                            @else
                                ({{ __('admin.expired') }})
                            @endif
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        <!-- Facilities -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.facilities') }}</h3>

            @if($customer->facilities->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">{{ __('admin.facilities.none') }}</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($customer->facilities as $facility)
                        <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $facility->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $facility->city }}</p>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $facility->stations_count }} {{ __('admin.stations') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Users -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.sections.users') }}</h3>

            @if($customer->users->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
                    </svg>
                    <p class="text-gray-500 text-sm">{{ __('admin.users.none') }}</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($customer->users as $user)
                        <div class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 rounded-full bg-[#005151]/10 flex items-center justify-center text-[#005151] font-semibold text-sm">
                                {{ strtoupper(substr($user->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <span class="px-2 py-1 rounded-lg text-xs font-medium
                                {{ $user->role === 'super_admin' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $user->role === 'user' ? 'bg-gray-100 text-gray-800' : '' }}
                            ">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
