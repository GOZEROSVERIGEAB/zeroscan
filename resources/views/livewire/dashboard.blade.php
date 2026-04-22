<div class="space-y-6">
    {{-- Period Selector --}}
    <div class="flex justify-end">
        <div class="inline-flex rounded-lg bg-gray-100 p-1">
            <button
                wire:click="setPeriod('7')"
                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === '7' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
            >
                7 dagar
            </button>
            <button
                wire:click="setPeriod('30')"
                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === '30' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
            >
                30 dagar
            </button>
            <button
                wire:click="setPeriod('90')"
                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === '90' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
            >
                90 dagar
            </button>
            <button
                wire:click="setPeriod('365')"
                class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === '365' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
            >
                1 år
            </button>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Items --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Hämtade</span>
                <div class="text-[#97d700]">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($this->stats['items']['value'], 0, ',', ' ') }}</div>
            <div class="flex items-center text-sm {{ $this->stats['items']['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4 mr-1 {{ $this->stats['items']['change'] >= 0 ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ abs($this->stats['items']['change']) }}%
            </div>
        </div>

        {{-- CO2 Saved --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">CO<sub>2</sub> Sparat</span>
                <div class="w-8 h-8 rounded-full bg-[#005151] flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($this->stats['co2']['value'], 1, ',', ' ') }}</span>
                <span class="text-lg text-gray-500">ton</span>
            </div>
            <div class="flex items-center text-sm {{ $this->stats['co2']['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4 mr-1 {{ $this->stats['co2']['change'] >= 0 ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ abs($this->stats['co2']['change']) }}%
            </div>
        </div>

        {{-- Value --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Värde</span>
                <div class="w-8 h-8 rounded-full bg-[#97d700]/20 flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="flex items-baseline gap-1">
                <span class="text-3xl font-bold text-gray-900">{{ number_format($this->stats['value']['value'], 0, ',', ' ') }}</span>
                <span class="text-lg text-gray-500">tkr</span>
            </div>
            <div class="flex items-center text-sm {{ $this->stats['value']['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4 mr-1 {{ $this->stats['value']['change'] >= 0 ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ abs($this->stats['value']['change']) }}%
            </div>
        </div>

        {{-- Visitors --}}
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-gray-500 uppercase tracking-wide">Besökare</span>
                <div class="text-[#005151]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($this->stats['visitors']['value'], 0, ',', ' ') }}</div>
            <div class="flex items-center text-sm {{ $this->stats['visitors']['change'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                <svg class="w-4 h-4 mr-1 {{ $this->stats['visitors']['change'] >= 0 ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                {{ abs($this->stats['visitors']['change']) }}%
            </div>
        </div>
    </div>

    {{-- Charts and Categories Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Chart --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Hämtade föremål</h3>
                    <p class="text-sm text-gray-500">Senaste {{ $period }} dagarna</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-xs font-medium rounded-md bg-gray-900 text-white">V</button>
                    <button class="px-3 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-600">D</button>
                </div>
            </div>
            <div class="h-48" wire:ignore x-data="chartComponent(@js($this->chartData))" x-init="initChart()">
                <canvas x-ref="chart"></canvas>
            </div>
        </div>

        {{-- Categories --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">Kategorier</h3>
            <div class="space-y-4">
                @forelse($this->categories as $category)
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                            @switch($category['name'])
                                @case('Möbler')
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    @break
                                @case('Kläder')
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    @break
                                @case('Elektronik')
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    @break
                                @case('Sport')
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    @break
                                @default
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                            @endswitch
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm font-medium text-gray-900">{{ $category['name'] }}</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $category['percentage'] }}%</span>
                            </div>
                            <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-[#97d700] rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-8">Ingen data för vald period</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Stations and Activity Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Stations --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Stationer</h3>
                <span class="text-sm text-gray-500">{{ $this->activeStationsCount }} aktiva</span>
            </div>
            <div class="space-y-3">
                @forelse($this->stations as $station)
                    <div class="flex items-center justify-between py-2">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-2 rounded-full {{ $station['is_active'] ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                            <span class="text-sm font-medium text-gray-900">{{ $station['name'] }}</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-600">{{ number_format($station['count'], 0, ',', ' ') }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-8">Inga stationer</p>
                @endforelse
            </div>
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">Senaste aktivitet</h3>
                <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
            </div>
            <div class="space-y-4">
                @forelse($this->recentActivity as $item)
                    <div class="flex items-center gap-4">
                        @if($item['image_url'])
                            <img src="{{ $item['image_url'] }}" alt="{{ $item['name'] }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0">
                        @else
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $item['station'] }} • {{ $item['time_ago'] }}</p>
                        </div>
                        <div class="text-sm font-semibold text-[#97d700]">+{{ $item['co2_savings'] }}kg</div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-8">Ingen aktivitet än</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Facilities Row --}}
    @if(count($this->facilities) > 0)
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Anläggningar</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($this->facilities as $facility)
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <div class="text-2xl font-bold text-gray-900">{{ number_format($facility['count'], 0, ',', ' ') }}</div>
                    <div class="text-sm text-gray-500 truncate">{{ $facility['name'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@script
<script>
    Alpine.data('chartComponent', (initialData) => ({
        chart: null,
        chartData: initialData,
        initChart() {
            const ctx = this.$refs.chart.getContext('2d');

            this.chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: this.chartData.labels,
                    datasets: [{
                        data: this.chartData.data,
                        backgroundColor: '#97d700',
                        borderRadius: 6,
                        barThickness: 20,
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

            Livewire.on('chartDataUpdated', (data) => {
                this.chart.data.labels = data[0].labels;
                this.chart.data.datasets[0].data = data[0].data;
                this.chart.update();
            });
        }
    }));
</script>
@endscript
