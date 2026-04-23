<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.reports.environment.title') }}</h1>
                </div>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.environment.subtitle') }}</p>
            </div>
            <a href="{{ route('reports.export', ['type' => 'environmental', 'format' => 'pdf', 'period' => $period, 'facility_id' => $facilityId]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#97d700] text-white rounded-lg hover:bg-[#7ab300] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('scanit.reports.export_pdf') }}
            </a>
        </div>

        {{-- Filters --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex items-center gap-4">
                <select wire:model.live="facilityId" class="rounded-lg border-gray-300 text-sm focus:border-[#97d700] focus:ring-[#97d700]">
                    <option value="">{{ __('scanit.reports.all_facilities') }}</option>
                    @foreach($this->facilities as $facility)
                        <option value="{{ $facility->id }}">{{ $facility->name }}</option>
                    @endforeach
                </select>
                @if($facilityId)
                    <select wire:model.live="stationId" class="rounded-lg border-gray-300 text-sm focus:border-[#97d700] focus:ring-[#97d700]">
                        <option value="">{{ __('scanit.reports.all_stations') }}</option>
                        @foreach($this->stations as $station)
                            <option value="{{ $station->id }}">{{ $station->name }}</option>
                        @endforeach
                    </select>
                @endif
            </div>

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

        {{-- Impact Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- CO2 Saved --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <span class="text-white/80 font-medium">CO<sub>2</sub> {{ __('scanit.reports.environment.co2_title') }}</span>
                </div>
                <div class="text-4xl font-bold mb-2" x-data="{ count: 0 }" x-init="setTimeout(() => { count = {{ $this->impact['co2_savings'] ?? 0 }} }, 100)" x-text="count.toLocaleString('sv-SE', { minimumFractionDigits: 1, maximumFractionDigits: 1 }) + ' kg'">
                    0 kg
                </div>
                <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.co2_subtitle') }}</div>
            </div>

            {{-- Water Saved --}}
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <span class="text-white/80 font-medium">{{ __('scanit.reports.environment.water_title') }}</span>
                </div>
                <div class="text-4xl font-bold mb-2">
                    {{ number_format(($this->impact['water_savings'] ?? 0) / 1000, 1, ',', ' ') }} m<sup>3</sup>
                </div>
                <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.water_subtitle') }}</div>
            </div>

            {{-- Energy Saved --}}
            <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-2xl p-6 text-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-white/80 font-medium">{{ __('scanit.reports.environment.energy_title') }}</span>
                </div>
                <div class="text-4xl font-bold mb-2">
                    {{ number_format($this->impact['energy_savings'] ?? 0, 0, ',', ' ') }} kWh
                </div>
                <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.energy_subtitle') }}</div>
            </div>
        </div>

        {{-- Equivalents --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.environment.equivalents_title') }}</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                @php
                    $equivalents = $this->impact['equivalents'] ?? [
                        'trees' => 0,
                        'car_km' => 0,
                        'showers' => 0,
                        'phone_charges' => 0,
                        'flights' => 0
                    ];
                @endphp

                {{-- Trees --}}
                <div class="text-center">
                    <div class="text-4xl mb-2">&#127794;</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($equivalents['trees'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.environment.eq_trees') }}</div>
                </div>

                {{-- Car KM --}}
                <div class="text-center">
                    <div class="text-4xl mb-2">&#128663;</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($equivalents['car_km'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.environment.eq_car_km') }}</div>
                </div>

                {{-- Showers --}}
                <div class="text-center">
                    <div class="text-4xl mb-2">&#128703;</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($equivalents['showers'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.environment.eq_showers') }}</div>
                </div>

                {{-- Phone Charges --}}
                <div class="text-center">
                    <div class="text-4xl mb-2">&#128241;</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($equivalents['phone_charges'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.environment.eq_phones') }}</div>
                </div>

                {{-- Flights --}}
                <div class="text-center">
                    <div class="text-4xl mb-2">&#9992;&#65039;</div>
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($equivalents['flights'] ?? 0, 1, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.environment.eq_flights') }}</div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Trend Chart --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.environment.trend_title') }}</h3>
                <div class="h-64" wire:ignore x-data="trendChart(@js($this->timeSeries))" x-init="initChart()">
                    <canvas x-ref="chart"></canvas>
                </div>
            </div>

            {{-- Category Breakdown --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.environment.category_title') }}</h3>
                <div class="space-y-4">
                    @forelse($this->categoryBreakdown as $category)
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900">{{ $category['name'] }}</span>
                                    <span class="text-sm text-gray-500">{{ number_format($category['co2_savings'], 1, ',', ' ') }} kg CO<sub>2</sub></span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#97d700] rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('scanit.reports.no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Lifetime Impact --}}
        <div class="bg-gradient-to-r from-[#005151] to-[#007070] rounded-2xl p-8 text-white">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold mb-2">{{ __('scanit.reports.environment.lifetime_title') }}</h3>
                <p class="text-white/70">{{ __('scanit.reports.environment.lifetime_subtitle') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ number_format($this->lifetime['items'] ?? 0, 0, ',', ' ') }}</div>
                    <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.lifetime_items') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ number_format(($this->lifetime['co2'] ?? 0) / 1000, 1, ',', ' ') }} ton</div>
                    <div class="text-white/70 text-sm">CO<sub>2</sub> {{ __('scanit.reports.environment.lifetime_co2') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ number_format(($this->lifetime['water'] ?? 0) / 1000, 0, ',', ' ') }} m<sup>3</sup></div>
                    <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.lifetime_water') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ number_format(($this->lifetime['value'] ?? 0) / 1000, 0, ',', ' ') }} tkr</div>
                    <div class="text-white/70 text-sm">{{ __('scanit.reports.environment.lifetime_value') }}</div>
                </div>
            </div>
        </div>

        {{-- Sources & Methodology --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mt-8">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Källor & Metodik</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 mb-3 text-sm">AI-analys</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-sm">
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Modell:</span>
                            <span class="font-medium text-gray-900">Anthropic Claude (opus-4)</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-gray-600">Leverantör:</span>
                            <span class="font-medium text-gray-900">Anthropic</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Användning:</span>
                            <span class="font-medium text-gray-900">Bildanalys, kategorisering, värdering</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-3 text-sm">Miljöekvivalenter - Referenser</h4>
                    <div class="bg-gray-50 rounded-lg p-4 text-sm space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🌳</span>
                            <span class="text-gray-600">1 träd = 21 kg CO₂/år (EPA)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🚗</span>
                            <span class="text-gray-600">1 km bil = 0.12 kg CO₂ (Naturvårdsverket)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">🚿</span>
                            <span class="text-gray-600">1 dusch = 65 liter (Svenskt Vatten)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">📱</span>
                            <span class="text-gray-600">1 laddning = 0.012 kWh (IEA)</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-lg">✈️</span>
                            <span class="text-gray-600">Sthlm-NYC = 1000 kg CO₂ (ICAO)</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-4 border-t border-gray-100">
                <h4 class="font-medium text-gray-900 mb-2 text-sm">Datakällor för miljöberäkningar</h4>
                <p class="text-xs text-gray-500">
                    CO₂-data: EPA (Environmental Protection Agency), DEFRA (UK Department for Environment) |
                    Vattenförbrukning: Water Footprint Network |
                    Energiförbrukning: IEA (International Energy Agency) |
                    Beräkningsmetod: Livscykelanalys (LCA) enligt ISO 14040/14044
                </p>
            </div>

            <p class="mt-4 text-xs text-gray-500 italic">
                Alla miljöbesparingar är uppskattningar baserade på AI-analys och vetenskapliga källor.
                Faktiska värden kan variera beroende på produktens ursprung och tillverkningsmetoder.
            </p>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    Alpine.data('trendChart', (initialData) => ({
        chart: null,
        initChart() {
            const ctx = this.$refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: initialData.labels || [],
                    datasets: [{
                        label: 'CO2 besparat (kg)',
                        data: initialData.data || [],
                        borderColor: '#97d700',
                        backgroundColor: 'rgba(151, 215, 0, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { color: '#9ca3af' }
                        },
                        y: {
                            grid: { color: '#f3f4f6' },
                            ticks: { color: '#9ca3af' },
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    }));
</script>
@endscript
