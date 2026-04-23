<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('reports.index') }}" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.reports.exports.title') }}</h1>
            </div>
            <p class="text-sm text-gray-500">{{ __('scanit.reports.exports.subtitle') }}</p>
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
                @foreach(['7d' => '7 dagar', '30d' => '30 dagar', '90d' => '90 dagar', '365d' => '1 år', 'ytd' => 'Hittills i år'] as $key => $label)
                    <button
                        wire:click="$set('period', '{{ $key }}')"
                        class="px-3 py-1.5 text-sm font-medium rounded-md transition-colors {{ $period === $key ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}"
                    >
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Export Types Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($exportTypes as $type => $config)
                <div
                    wire:click="setExportType('{{ $type }}')"
                    class="bg-white rounded-2xl p-6 shadow-sm border-2 cursor-pointer transition-all {{ $exportType === $type ? 'border-[#97d700] ring-2 ring-[#97d700]/20' : 'border-gray-100 hover:border-gray-200' }}"
                >
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center
                            @switch($type)
                                @case('executive') bg-blue-100 @break
                                @case('environmental') bg-green-100 @break
                                @case('csrd') bg-purple-100 @break
                                @case('inventory') bg-orange-100 @break
                                @case('certificate') bg-pink-100 @break
                            @endswitch
                        ">
                            @switch($type)
                                @case('executive')
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    @break
                                @case('environmental')
                                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                                    </svg>
                                    @break
                                @case('csrd')
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    @break
                                @case('inventory')
                                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    @break
                                @case('certificate')
                                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    @break
                            @endswitch
                        </div>
                        @if($exportType === $type)
                            <div class="w-6 h-6 rounded-full bg-[#97d700] flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $config['label'] }}</h3>
                    <p class="text-sm text-gray-500 mb-4">{{ $config['description'] }}</p>
                    <div class="flex gap-2">
                        @foreach($config['formats'] as $format)
                            <span class="px-2 py-1 text-xs font-medium rounded bg-gray-100 text-gray-600 uppercase">{{ $format }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Export Configuration --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.exports.config_title') }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Selected Report Type --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('scanit.reports.exports.report_type') }}</label>
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="font-medium text-gray-900">{{ $exportTypes[$exportType]['label'] }}</div>
                        <div class="text-sm text-gray-500">{{ $exportTypes[$exportType]['description'] }}</div>
                    </div>
                </div>

                {{-- Format Selection --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">{{ __('scanit.reports.exports.format') }}</label>
                    <div class="flex gap-4">
                        @foreach($exportTypes[$exportType]['formats'] as $format)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input
                                    type="radio"
                                    wire:model="exportFormat"
                                    value="{{ $format }}"
                                    class="text-[#97d700] focus:ring-[#97d700]"
                                >
                                <span class="text-sm font-medium text-gray-900 uppercase">{{ $format }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Summary --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-500">{{ __('scanit.reports.exports.period') }}</div>
                        <div class="font-medium text-gray-900">{{ $startDate->format('Y-m-d') }} - {{ $endDate->format('Y-m-d') }}</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">{{ __('scanit.reports.exports.items_in_period') }}</div>
                        <div class="font-medium text-gray-900">{{ number_format($this->kpis['items'] ?? 0, 0, ',', ' ') }} {{ __('scanit.reports.items_unit') }}</div>
                    </div>
                </div>
            </div>

            {{-- Export Button --}}
            <div class="mt-6 flex justify-end">
                <button
                    wire:click="export"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-[#97d700] text-white font-medium rounded-lg hover:bg-[#7ab300] transition-colors"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ __('scanit.reports.exports.download') }} {{ strtoupper($exportFormat) }}
                </button>
            </div>
        </div>

        {{-- Quick Exports --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">{{ __('scanit.reports.exports.quick_exports') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="{{ route('reports.export', ['type' => 'executive', 'format' => 'pdf', 'period' => '30d']) }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ __('scanit.reports.exports.quick_summary') }}</div>
                        <div class="text-sm text-gray-500">PDF - 30 dagar</div>
                    </div>
                </a>

                <a href="{{ route('reports.export', ['type' => 'environmental', 'format' => 'pdf', 'period' => '30d']) }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ __('scanit.reports.exports.quick_environment') }}</div>
                        <div class="text-sm text-gray-500">PDF - 30 dagar</div>
                    </div>
                </a>

                <a href="{{ route('reports.export', ['type' => 'inventory', 'format' => 'excel', 'period' => '30d']) }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-700" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ __('scanit.reports.exports.quick_inventory') }}</div>
                        <div class="text-sm text-gray-500">Excel - 30 dagar</div>
                    </div>
                </a>

                <a href="{{ route('reports.export', ['type' => 'csrd', 'format' => 'pdf', 'period' => 'ytd']) }}" class="flex items-center gap-3 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ __('scanit.reports.exports.quick_csrd') }}</div>
                        <div class="text-sm text-gray-500">PDF - Hittills i år</div>
                    </div>
                </a>
            </div>
        </div>

        {{-- Sources & Methodology Note --}}
        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
            <div class="flex items-start gap-3">
                <svg class="w-6 h-6 text-[#005151] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Om våra rapporter & källor</h4>
                    <p class="text-sm text-gray-600 mb-3">
                        Alla rapporter inkluderar fullständig källhänvisning och metodikbeskrivning. Data analyseras med AI-stöd från Anthropic Claude.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
                        <div>
                            <span class="font-medium text-gray-900">AI-analys:</span>
                            <span class="text-gray-600">Anthropic Claude (opus-4)</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-900">Miljödata:</span>
                            <span class="text-gray-600">EPA, DEFRA, IEA, Naturvårdsverket</span>
                        </div>
                        <div>
                            <span class="font-medium text-gray-900">Metod:</span>
                            <span class="text-gray-600">LCA enligt ISO 14040/14044</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
