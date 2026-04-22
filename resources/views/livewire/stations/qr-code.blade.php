<div>
<div class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 print:hidden">
            <a href="{{ route('stations.index') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-gray-700 mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('scanit.actions.back') }}
            </a>
            <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.stations.qr_code') }}</h1>
            <p class="text-gray-500 mt-1">{{ $station->name }} - {{ $station->facility?->name }}</p>
        </div>

        {{-- QR Code Card --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden print:shadow-none print:border-0">
            {{-- Controls (hidden when printing) --}}
            <div class="p-6 border-b border-gray-100 print:hidden">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Storlek</label>
                        <div class="inline-flex rounded-lg border border-gray-200 p-1 bg-gray-50">
                            <button
                                wire:click="$set('size', 'small')"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-colors min-w-[70px] {{ $size === 'small' ? 'bg-[#005151] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
                            >
                                Liten
                            </button>
                            <button
                                wire:click="$set('size', 'medium')"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-colors min-w-[70px] {{ $size === 'medium' ? 'bg-[#005151] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
                            >
                                Medium
                            </button>
                            <button
                                wire:click="$set('size', 'large')"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-colors min-w-[70px] {{ $size === 'large' ? 'bg-[#005151] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
                            >
                                Stor
                            </button>
                            <button
                                wire:click="$set('size', 'xlarge')"
                                class="px-4 py-2 text-sm font-medium rounded-md transition-colors min-w-[70px] {{ $size === 'xlarge' ? 'bg-[#005151] text-white shadow-sm' : 'text-gray-700 hover:bg-gray-100' }}"
                            >
                                XL
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button
                            onclick="window.print()"
                            class="inline-flex items-center gap-2 px-4 py-2 bg-[#97d700] text-[#005151] text-sm font-medium rounded-lg hover:bg-[#85c100] transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Skriv ut
                        </button>
                        <a
                            href="{{ route('public.scan.qr', $station->public_uuid) }}"
                            download="qr-{{ $station->public_uuid }}.svg"
                            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Ladda ner
                        </a>
                    </div>
                </div>
            </div>

            {{-- QR Code Display --}}
            <div class="p-12 print:p-0" id="qr-print-area">
                <div class="text-center">
                    {{-- Logo --}}
                    <div class="flex items-center justify-center gap-3 mb-8">
                        @if($branding['has_custom'] && $branding['logo_url'])
                            <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['service_name'] ?? '' }}" class="h-12 print:h-10 max-w-[200px] object-contain">
                            @if($branding['service_name'])
                                <span class="text-2xl font-semibold text-[#005151] print:text-xl">{{ $branding['service_name'] }}</span>
                            @endif
                        @else
                            <img src="/images/prezero-logo.svg" alt="PreZero" class="h-10 print:h-8">
                            <span class="text-2xl font-semibold text-[#005151] print:text-xl">Scan<span class="font-normal text-lg print:text-base">it</span></span>
                        @endif
                    </div>

                    {{-- QR Code --}}
                    <div class="flex justify-center mb-8">
                        <div class="bg-white p-6 rounded-2xl border-4 border-[#005151] inline-block print:border-2">
                            <img
                                src="{{ route('public.scan.qr', $station->public_uuid) }}?size={{ $sizePixels }}"
                                alt="QR Code"
                                style="width: {{ $sizePixels }}px; height: {{ $sizePixels }}px;"
                                class="print:w-64 print:h-64"
                            />
                        </div>
                    </div>

                    {{-- Station Info --}}
                    <div class="max-w-md mx-auto">
                        <h2 class="text-2xl font-bold text-[#005151] mb-2 print:text-xl">{{ $station->name }}</h2>
                        <p class="text-gray-600 mb-4 print:text-sm">{{ $station->facility?->name }}</p>

                        @if($station->location_description)
                            <p class="text-gray-500 text-sm mb-6 print:text-xs">{{ $station->location_description }}</p>
                        @endif

                        <div class="bg-[#005151]/5 rounded-xl p-6 print:p-4">
                            <p class="text-[#005151] font-medium mb-2 print:text-sm">Skanna QR-koden för att registrera dina föremål</p>
                            <p class="text-gray-500 text-sm print:text-xs">Ta bilder av föremålen du hämtar och få en miljörapport</p>
                        </div>
                    </div>

                    {{-- URL (hidden when printing) --}}
                    <div class="mt-8 pt-6 border-t border-gray-200 print:hidden">
                        <p class="text-xs text-gray-400 break-all">{{ $qrUrl }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instructions (hidden when printing) --}}
        <div class="mt-8 bg-blue-50 rounded-xl p-6 print:hidden">
            <div class="flex gap-4">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-2">Tips för utskrift</h3>
                    <ul class="text-sm text-blue-800 space-y-1">
                        <li>• Använd tjockare papper eller laminera QR-koden för bättre hållbarhet</li>
                        <li>• Placera QR-koden på en synlig plats där besökare enkelt kan skanna</li>
                        <li>• Testa att skanna koden med din mobil innan du sätter upp den</li>
                        <li>• Storlek "Stor" eller "Extra stor" rekommenderas för bättre läsbarhet</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #qr-print-area, #qr-print-area * {
            visibility: visible;
        }
        #qr-print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        @page {
            margin: 2cm;
        }
    }
</style>
</div>
