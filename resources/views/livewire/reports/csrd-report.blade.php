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
                    <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.reports.csrd.title') }}</h1>
                </div>
                <p class="text-sm text-gray-500">{{ __('scanit.reports.csrd.subtitle') }}</p>
            </div>
            <a href="{{ route('reports.export', ['type' => 'csrd', 'format' => 'pdf', 'period' => $period, 'facility_id' => $facilityId]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#97d700] text-white rounded-lg hover:bg-[#7ab300] transition-colors">
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
            </div>

            <div class="inline-flex rounded-lg bg-gray-100 p-1">
                @foreach(['q1' => 'Q1', 'q2' => 'Q2', 'q3' => 'Q3', 'q4' => 'Q4', 'ytd' => 'Hittills i år'] as $key => $label)
                    <button
                        wire:click="setPeriod('{{ $key }}')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === $key ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- ESRS E5 Compliance Badge --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-1">ESRS E5 - {{ __('scanit.reports.csrd.esrs_title') }}</h3>
                    <p class="text-sm text-blue-700">{{ __('scanit.reports.csrd.esrs_description') }}</p>
                </div>
            </div>
        </div>

        {{-- CSRD Metrics Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @php $metrics = $this->csrdMetrics; @endphp

            {{-- E5-4: Material Inflows --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded">E5-4</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.material_inflows') }}</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($metrics['material_inflows'] ?? 0, 0, ',', ' ') }} kg</div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.total_weight') }}</div>
            </div>

            {{-- E5-2: Reuse Rate --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-medium rounded">E5-2</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.reuse_rate') }}</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($metrics['reuse_rate'] ?? 0, 1, ',', ' ') }}%</div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.diverted_landfill') }}</div>
            </div>

            {{-- E5-3: Product Quality --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-medium rounded">E5-3</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.product_quality') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="text-3xl font-bold text-gray-900">{{ number_format($metrics['avg_condition'] ?? 0, 1, ',', ' ') }}</div>
                    <div class="flex text-yellow-400">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-5 h-5 {{ $i <= round($metrics['avg_condition'] ?? 0) ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        @endfor
                    </div>
                </div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.avg_condition') }}</div>
            </div>

            {{-- E5-4: Waste Prevented --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs font-medium rounded">E5-4</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.waste_prevented') }}</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($metrics['waste_prevented'] ?? 0, 0, ',', ' ') }} kg</div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.estimated_waste') }}</div>
            </div>

            {{-- E5-5: Circular Value --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-teal-100 text-teal-700 text-xs font-medium rounded">E5-5</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.circular_value') }}</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($metrics['circular_value'] ?? 0, 0, ',', ' ') }} kr</div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.economic_value') }}</div>
            </div>

            {{-- Items Processed --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">KPI</span>
                    <span class="text-sm text-gray-500">{{ __('scanit.reports.csrd.items_processed') }}</span>
                </div>
                <div class="text-3xl font-bold text-gray-900 mb-1">{{ number_format($metrics['items_count'] ?? 0, 0, ',', ' ') }}</div>
                <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.total_items') }}</div>
            </div>
        </div>

        {{-- Category & Material Breakdown --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            {{-- Category Breakdown --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.csrd.category_breakdown') }}</h3>
                <div class="space-y-4">
                    @forelse($this->categoryBreakdown as $category)
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900">{{ $category['name'] }}</span>
                                    <span class="text-sm text-gray-500">{{ $category['count'] }} {{ __('scanit.reports.items_unit') }}</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#005151] rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('scanit.reports.no_data') }}</p>
                    @endforelse
                </div>
            </div>

            {{-- Material Flow --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.csrd.material_flow') }}</h3>
                <div class="space-y-4">
                    @forelse($this->materialBreakdown as $material)
                        <div class="flex items-center gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-900">{{ $material['name'] }}</span>
                                    <span class="text-sm text-gray-500">{{ number_format($material['weight'], 1, ',', ' ') }} kg</span>
                                </div>
                                <div class="h-2 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-[#97d700] rounded-full" style="width: {{ $material['percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm text-center py-8">{{ __('scanit.reports.no_data') }}</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Period Comparison --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-gray-900">{{ __('scanit.reports.csrd.comparison_title') }}</h3>
                <div class="inline-flex rounded-lg bg-gray-100 p-1">
                    <button
                        wire:click="setComparisonType('yoy')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $comparisonType === 'yoy' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ __('scanit.reports.csrd.yoy') }}
                    </button>
                    <button
                        wire:click="setComparisonType('qoq')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $comparisonType === 'qoq' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ __('scanit.reports.csrd.qoq') }}
                    </button>
                </div>
            </div>

            @php $comparison = $this->comparison; @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <div class="text-2xl font-bold {{ ($comparison['items_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($comparison['items_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['items_change'] ?? 0, 1) }}%
                    </div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.items_change') }}</div>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <div class="text-2xl font-bold {{ ($comparison['co2_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($comparison['co2_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['co2_change'] ?? 0, 1) }}%
                    </div>
                    <div class="text-sm text-gray-500">CO<sub>2</sub> {{ __('scanit.reports.csrd.change') }}</div>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <div class="text-2xl font-bold {{ ($comparison['value_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($comparison['value_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['value_change'] ?? 0, 1) }}%
                    </div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.value_change') }}</div>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50">
                    <div class="text-2xl font-bold {{ ($comparison['weight_change'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ ($comparison['weight_change'] ?? 0) >= 0 ? '+' : '' }}{{ number_format($comparison['weight_change'] ?? 0, 1) }}%
                    </div>
                    <div class="text-sm text-gray-500">{{ __('scanit.reports.csrd.weight_change') }}</div>
                </div>
            </div>
        </div>

        {{-- Facility Comparison --}}
        @if(count($this->facilityComparison) > 1)
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.csrd.facility_comparison') }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 text-sm font-medium text-gray-500">{{ __('scanit.reports.csrd.facility') }}</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-gray-500">{{ __('scanit.reports.csrd.items') }}</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-gray-500">CO<sub>2</sub> (kg)</th>
                            <th class="text-right py-3 px-4 text-sm font-medium text-gray-500">{{ __('scanit.reports.csrd.value') }} (kr)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->facilityComparison as $facility)
                            <tr class="border-b border-gray-50 hover:bg-gray-50">
                                <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $facility['name'] }}</td>
                                <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ number_format($facility['items'], 0, ',', ' ') }}</td>
                                <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ number_format($facility['co2'], 1, ',', ' ') }}</td>
                                <td class="py-3 px-4 text-sm text-gray-600 text-right">{{ number_format($facility['value'], 0, ',', ' ') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Sources & Methodology for CSRD --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Källor & Metodik - ESRS E5 Compliance</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2 text-sm">AI-analys</h4>
                    <div class="bg-blue-50 rounded-lg p-3 text-sm">
                        <p class="text-gray-700 mb-1"><strong>Modell:</strong> Anthropic Claude (opus-4)</p>
                        <p class="text-gray-700 mb-1"><strong>Leverantör:</strong> Anthropic</p>
                        <p class="text-gray-700"><strong>Uppgift:</strong> Bildanalys, kategorisering, värdering, skickbedömning</p>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2 text-sm">ESRS E5 Standarder</h4>
                    <div class="bg-blue-50 rounded-lg p-3 text-xs">
                        <ul class="space-y-1 text-gray-600">
                            <li><strong>E5-1:</strong> Policyer för resursanvändning</li>
                            <li><strong>E5-2:</strong> Åtgärder och resurser</li>
                            <li><strong>E5-3:</strong> Mål för resursanvändning</li>
                            <li><strong>E5-4:</strong> Resursflöden (in/ut)</li>
                            <li><strong>E5-5:</strong> Avfallshantering</li>
                        </ul>
                    </div>
                </div>

                <div>
                    <h4 class="font-medium text-gray-900 mb-2 text-sm">Datakällor</h4>
                    <div class="bg-blue-50 rounded-lg p-3 text-xs">
                        <ul class="space-y-1 text-gray-600">
                            <li>EPA - Environmental Protection Agency</li>
                            <li>DEFRA - UK Department for Environment</li>
                            <li>Naturvårdsverket</li>
                            <li>IPCC - Climate Change Data</li>
                            <li>ISO 14040/14044 - LCA</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-3 bg-amber-50 rounded-lg border border-amber-200">
                <p class="text-xs text-amber-800">
                    <strong>Metodologisk not:</strong> Denna rapport är avsedd som underlag för CSRD-hållbarhetsredovisning enligt ESRS E5.
                    Materialinflöden baseras på genomsnittsvikter per produktkategori. CO₂-besparingar baseras på livscykelanalyser.
                    Verifiera data med revisor vid extern rapportering.
                </p>
            </div>
        </div>
    </div>
</div>
