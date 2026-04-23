<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.reports.title') }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ __('scanit.reports.subtitle') }}</p>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            {{-- Facility Filter --}}
            <div class="flex items-center gap-4">
                <select wire:model.live="facilityId" class="rounded-lg border-gray-300 text-sm focus:border-[#97d700] focus:ring-[#97d700]">
                    <option value="">{{ __('scanit.reports.all_facilities') }}</option>
                    @foreach($this->facilities as $facility)
                        <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Period Selector --}}
            <div class="inline-flex rounded-lg bg-gray-100 p-1">
                @foreach(['7d' => '7 dagar', '30d' => '30 dagar', '90d' => '90 dagar', '365d' => '1 år', 'ytd' => 'Hittills i år'] as $key => $label)
                    <button
                        wire:click="setPeriod('{{ $key }}')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === $key ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            {{-- Items --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('scanit.reports.kpi.items') }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#97d700]/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#97d700]" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($this->kpis['items'] ?? 0, 0, ',', ' ') }}</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('scanit.reports.items_label') }}</div>
            </div>

            {{-- CO2 --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">CO<sub>2</sub> {{ __('scanit.reports.kpi.saved') }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#005151] flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format(($this->kpis['co2_savings'] ?? 0) / 1000, 1, ',', ' ') }}</span>
                    <span class="text-lg text-gray-500">ton</span>
                </div>
                <div class="text-sm text-gray-500 mt-1">CO<sub>2</sub> {{ __('scanit.reports.avoided') }}</div>
            </div>

            {{-- Value --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('scanit.reports.kpi.value') }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#97d700]/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-1">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format(($this->kpis['estimated_value'] ?? 0) / 1000, 0, ',', ' ') }}</span>
                    <span class="text-lg text-gray-500">tkr</span>
                </div>
                <div class="text-sm text-gray-500 mt-1">{{ __('scanit.reports.estimated_value') }}</div>
            </div>

            {{-- Sessions --}}
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">{{ __('scanit.reports.kpi.sessions') }}</span>
                    <div class="w-8 h-8 rounded-full bg-[#005151]/20 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($this->kpis['sessions'] ?? 0, 0, ',', ' ') }}</div>
                <div class="text-sm text-gray-500 mt-1">{{ __('scanit.reports.visitors_label') }}</div>
            </div>
        </div>

        {{-- Report Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            {{-- Environment Impact --}}
            <a href="{{ route('reports.environment') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#97d700] transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#97d700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('scanit.reports.cards.environment.title') }}</h3>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.cards.environment.description') }}</p>
            </a>

            {{-- CSRD Report --}}
            <a href="{{ route('reports.csrd') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#97d700] transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#97d700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('scanit.reports.cards.csrd.title') }}</h3>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.cards.csrd.description') }}</p>
            </a>

            {{-- Inventory Analytics --}}
            <a href="{{ route('reports.inventory') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#97d700] transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#97d700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('scanit.reports.cards.inventory.title') }}</h3>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.cards.inventory.description') }}</p>
            </a>

            {{-- Export Center --}}
            <a href="{{ route('reports.exports') }}" class="group bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#97d700] transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-[#97d700] transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('scanit.reports.cards.exports.title') }}</h3>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.cards.exports.description') }}</p>
            </a>
        </div>

        {{-- Period Info --}}
        <div class="text-sm text-gray-500 text-center mb-8">
            {{ __('scanit.reports.showing_data_from') }} {{ $startDate->format('Y-m-d') }} {{ __('scanit.reports.to') }} {{ $endDate->format('Y-m-d') }}
        </div>

        {{-- Sources & Methodology --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Källor & Metodik</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">AI-analys</h4>
                    <ul class="space-y-1 text-gray-600">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#97d700]"></span>
                            Modell: Anthropic Claude (opus-4)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#97d700]"></span>
                            Bildanalys & kategorisering
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#97d700]"></span>
                            Värdering & skickbedömning
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Datakällor</h4>
                    <ul class="space-y-1 text-gray-600">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#005151]"></span>
                            EPA & DEFRA (CO2-data)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#005151]"></span>
                            Water Footprint Network
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#005151]"></span>
                            IEA (energidata)
                        </li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Beräkningsmetoder</h4>
                    <ul class="space-y-1 text-gray-600">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            Livscykelanalys (LCA)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            ISO 14040/14044
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            Kategoribaserade snitt
                        </li>
                    </ul>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-500 italic">
                Alla miljöbesparingar är uppskattningar baserade på AI-analys och vetenskapliga källor.
                Faktiska värden kan variera beroende på produktens ursprung och tillverkningsmetoder.
            </p>
        </div>
    </div>
</div>
