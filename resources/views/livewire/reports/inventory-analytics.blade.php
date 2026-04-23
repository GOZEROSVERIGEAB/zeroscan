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
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.reports.inventory.title') }}</h1>
                </div>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.inventory.subtitle') }}</p>
            </div>
            <a href="{{ route('reports.export', ['type' => 'inventory', 'format' => 'excel', 'period' => $period, 'facility_id' => $facilityId]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#97d700] text-white rounded-lg hover:bg-[#7ab300] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                {{ __('scanit.reports.export_excel') }}
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
                @foreach(['7d' => '7 dagar', '30d' => '30 dagar', '90d' => '90 dagar', '365d' => '1 år', 'all_time' => 'Alla'] as $key => $label)
                    <button
                        wire:click="setPeriod('{{ $key }}')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === $key ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- KPI Cards --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">{{ __('scanit.reports.inventory.total_items') }}</div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($this->kpis['items'] ?? 0, 0, ',', ' ') }}</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">{{ __('scanit.reports.inventory.avg_value') }}</div>
                <div class="text-3xl font-bold text-gray-900">{{ number_format($this->kpis['avg_value'] ?? 0, 0, ',', ' ') }} kr</div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">{{ __('scanit.reports.inventory.avg_condition') }}</div>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($this->kpis['avg_condition'] ?? 0, 1, ',', ' ') }}</span>
                    <span class="text-gray-400">/5</span>
                </div>
            </div>
            <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                <div class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">{{ __('scanit.reports.inventory.categories') }}</div>
                <div class="text-3xl font-bold text-gray-900">{{ count($this->categoryBreakdown) }}</div>
            </div>
        </div>

        {{-- Charts Row 1 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Category Breakdown --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.category_breakdown') }}</h3>
                <div class="space-y-4">
                    @forelse($this->categoryBreakdown as $category)
                        <button
                            wire:click="setCategory('{{ $category['name'] }}')"
                            class="w-full flex items-center gap-4 p-2 rounded-lg hover:bg-gray-50 transition-colors {{ $this->category === $category['name'] ? 'bg-gray-50 ring-2 ring-[#97d700]' : '' }}"
                        >
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900">{{ $category['name'] }}</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $category['count'] }}</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#97d700] rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                </div>
                            </div>
                        </button>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('scanit.reports.no_data') }}</p>
                    @endforelse
                </div>
                @if($category)
                    <button wire:click="setCategory(null)" class="mt-4 text-sm text-[#97d700] hover:underline">
                        {{ __('scanit.reports.inventory.clear_filter') }}
                    </button>
                @endif
            </div>

            {{-- Brand Distribution --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.top_brands') }}</h3>
                <div class="space-y-4">
                    @forelse($this->brandDistribution as $brand)
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-900">{{ $brand['name'] ?: __('scanit.reports.inventory.unknown_brand') }}</span>
                            <div class="flex items-center gap-3">
                                <div class="w-24 h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#005151] rounded-full" style="width: {{ $brand['percentage'] }}%"></div>
                                </div>
                                <span class="text-sm text-gray-500 w-12 text-right">{{ $brand['count'] }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('scanit.reports.no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Charts Row 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Condition Distribution --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.condition_dist') }}</h3>
                <div class="space-y-4">
                    @foreach($this->conditionDistribution as $condition)
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-1 w-24">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $condition['rating'] ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <div class="flex-1">
                                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $condition['percentage'] }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 w-16 text-right">{{ $condition['count'] }} ({{ number_format($condition['percentage'], 0) }}%)</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- AI Confidence --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.ai_confidence') }}</h3>
                <div class="space-y-4">
                    @foreach($this->aiConfidenceDistribution as $confidence)
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-900 w-20">{{ $confidence['range'] }}</span>
                            <div class="flex-1">
                                <div class="h-3 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#97d700] rounded-full" style="width: {{ $confidence['percentage'] }}%"></div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 w-16 text-right">{{ $confidence['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Time Patterns --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Hourly Distribution --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.hourly_dist') }}</h3>
                <div class="h-48" wire:ignore x-data="hourlyChart(@js($this->hourlyDistribution))" x-init="initChart()">
                    <canvas x-ref="chart"></canvas>
                </div>
            </div>

            {{-- Weekday Distribution --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.weekday_dist') }}</h3>
                <div class="h-48" wire:ignore x-data="weekdayChart(@js($this->weekdayDistribution))" x-init="initChart()">
                    <canvas x-ref="chart"></canvas>
                </div>
            </div>
        </div>

        {{-- Facility Comparison --}}
        @if(count($this->facilityComparison) > 1)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.inventory.facility_comparison') }}</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                @foreach($this->facilityComparison as $facility)
                    <div class="text-center p-4 rounded-xl bg-gray-50">
                        <div class="text-2xl font-bold text-gray-900">{{ number_format($facility['items'], 0, ',', ' ') }}</div>
                        <div class="text-sm text-gray-500 truncate">{{ $facility['name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Sources & Methodology --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Källor & Metodik - Inventarieanalys</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
                <div class="bg-purple-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">AI-driven analys</h4>
                    <p class="text-gray-600 text-xs mb-2">Alla föremål analyseras med AI för automatisk:</p>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Kategorisering & identifiering</li>
                        <li>• Varumärkes-igenkänning</li>
                        <li>• Skickbedömning (1-5)</li>
                        <li>• Värdeuppskattning (SEK)</li>
                    </ul>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">AI-modell</h4>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Modell:</strong> Anthropic Claude (opus-4)</p>
                        <p><strong>Leverantör:</strong> Anthropic</p>
                        <p><strong>Konfidens:</strong> Rapporteras per föremål</p>
                        <p><strong>Uppdaterad:</strong> Senaste versionen</p>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-2">Datakällor</h4>
                    <ul class="text-xs text-gray-600 space-y-1">
                        <li>• Prisdata: Marknadsanalyser</li>
                        <li>• Kategorier: Standardiserade</li>
                        <li>• Miljödata: EPA, DEFRA, IEA</li>
                        <li>• Varumärken: Produktdatabaser</li>
                    </ul>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-500 italic">
                Alla värderingar och kategoriseringar är AI-baserade uppskattningar.
                Faktiska värden kan variera beroende på marknad, skick och efterfrågan.
            </p>
        </div>
    </div>
</div>

@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

@script
<script>
    Alpine.data('hourlyChart', (data) => ({
        chart: null,
        initChart() {
            const ctx = this.$refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => d.hour + ':00'),
                    datasets: [{
                        data: data.map(d => d.count),
                        backgroundColor: '#97d700',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#9ca3af' } },
                        y: { grid: { color: '#f3f4f6' }, ticks: { color: '#9ca3af' }, beginAtZero: true }
                    }
                }
            });
        }
    }));

    Alpine.data('weekdayChart', (data) => ({
        chart: null,
        initChart() {
            const days = ['Mån', 'Tis', 'Ons', 'Tor', 'Fre', 'Lör', 'Sön'];
            const ctx = this.$refs.chart.getContext('2d');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.map(d => days[d.day - 1] || d.day),
                    datasets: [{
                        data: data.map(d => d.count),
                        backgroundColor: '#005151',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#9ca3af' } },
                        y: { grid: { color: '#f3f4f6' }, ticks: { color: '#9ca3af' }, beginAtZero: true }
                    }
                }
            });
        }
    }));
</script>
@endscript
