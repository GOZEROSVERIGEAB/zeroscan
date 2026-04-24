<div>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.dashboard.title') }}</h1>
        <p class="mt-1 text-sm text-gray-500">{{ __('admin.dashboard.subtitle') }}</p>
    </x-slot>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Customers -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#005151]/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_customers']) }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.total_customers') }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="text-[#97d700] font-medium">{{ $stats['active_customers'] }}</span>
                <span class="text-gray-400">{{ __('admin.dashboard.active') }}</span>
                <span class="text-gray-300">|</span>
                <span class="text-amber-500 font-medium">{{ $stats['trial_customers'] }}</span>
                <span class="text-gray-400">{{ __('admin.dashboard.on_trial') }}</span>
            </div>
        </div>

        <!-- Facilities -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_facilities']) }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.total_facilities') }}</p>
                </div>
            </div>
        </div>

        <!-- Stations -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-purple-50 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_stations']) }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.total_stations') }}</p>
                </div>
            </div>
        </div>

        <!-- Scans -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-[#97d700]/20 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_scans']) }}</p>
                    <p class="text-sm text-gray-500">{{ __('admin.dashboard.total_scans') }}</p>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="text-[#005151] font-medium">{{ number_format($stats['scans_this_month']) }}</span>
                <span class="text-gray-400">{{ __('admin.dashboard.this_month') }}</span>
                <span class="text-gray-300">|</span>
                <span class="text-[#97d700] font-medium">{{ number_format($stats['scans_today']) }}</span>
                <span class="text-gray-400">{{ __('admin.dashboard.today') }}</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Customers -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.recent_customers') }}</h2>
                <a href="{{ route('admin.customers.index') }}" class="text-sm text-[#005151] hover:text-[#005151]/80 font-medium">
                    {{ __('admin.dashboard.view_all') }}
                </a>
            </div>
            @if($recentCustomers->isEmpty())
                <p class="text-gray-500 text-sm">{{ __('admin.dashboard.no_recent_customers') }}</p>
            @else
                <div class="space-y-4">
                    @foreach($recentCustomers as $customer)
                        <a href="{{ route('admin.customers.show', $customer) }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 transition">
                            <div class="w-10 h-10 bg-[#005151]/10 rounded-lg flex items-center justify-center text-[#005151] font-semibold text-sm">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                                <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $customer->subscription_status === 'trial' ? 'bg-amber-100 text-amber-800' : 'bg-green-100 text-green-800' }}">
                                    {{ __("admin.status.{$customer->subscription_status}") }}
                                </span>
                                <p class="text-xs text-gray-400 mt-1">{{ $customer->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Expiring Trials -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.dashboard.expiring_trials') }}</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                    {{ $expiringTrials->count() }} {{ __('admin.dashboard.upcoming') }}
                </span>
            </div>
            @if($expiringTrials->isEmpty())
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500 text-sm">{{ __('admin.dashboard.no_expiring_trials') }}</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($expiringTrials as $customer)
                        <a href="{{ route('admin.customers.edit', $customer) }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-amber-50 transition border border-amber-100">
                            <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center text-amber-700 font-semibold text-sm">
                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                                <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-amber-700">
                                    {{ $customer->getDaysUntilTrialEnds() }} {{ __('admin.dashboard.days_left') }}
                                </p>
                                <p class="text-xs text-gray-400">{{ $customer->trial_ends_at->format('j M Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Top Customers -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">{{ __('admin.dashboard.top_customers') }}</h2>
            @if($topCustomers->isEmpty())
                <p class="text-gray-500 text-sm">{{ __('admin.dashboard.no_customers') }}</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left text-sm text-gray-500 border-b border-gray-100">
                                <th class="pb-3 font-medium">{{ __('admin.table.customer') }}</th>
                                <th class="pb-3 font-medium">{{ __('admin.table.status') }}</th>
                                <th class="pb-3 font-medium text-center">{{ __('admin.table.facilities') }}</th>
                                <th class="pb-3 font-medium text-center">{{ __('admin.table.stations') }}</th>
                                <th class="pb-3 font-medium text-center">{{ __('admin.table.users') }}</th>
                                <th class="pb-3 font-medium text-right">{{ __('admin.table.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($topCustomers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 bg-[#005151]/10 rounded-lg flex items-center justify-center text-[#005151] font-semibold text-xs">
                                                {{ strtoupper(substr($customer->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $customer->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $customer->org_number }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $customer->subscription_status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $customer->subscription_status === 'trial' ? 'bg-amber-100 text-amber-800' : '' }}
                                            {{ $customer->subscription_status === 'suspended' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $customer->subscription_status === 'cancelled' ? 'bg-gray-100 text-gray-800' : '' }}
                                        ">
                                            {{ __("admin.status.{$customer->subscription_status}") }}
                                        </span>
                                    </td>
                                    <td class="py-4 text-center font-medium">{{ $customer->facilities_count }}</td>
                                    <td class="py-4 text-center font-medium">{{ $customer->stations_count }}</td>
                                    <td class="py-4 text-center font-medium">{{ $customer->users_count }}</td>
                                    <td class="py-4 text-right">
                                        <a href="{{ route('admin.customers.show', $customer) }}" class="text-[#005151] hover:text-[#005151]/80 text-sm font-medium">
                                            {{ __('admin.actions.view') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
