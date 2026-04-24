<div
    x-data="{
        imagePreview: null,
        isScanning: false,
        currentStep: 0,
        scanLineY: 0,
        scanDirection: 1,
        stepInterval: null,
        scanInterval: null,
        locale: @entangle('locale'),

        labels: {
            en: {
                instructions_title: 'How to Use',
                instruction_1: 'Scan the barcode on the product for instant lookup',
                instruction_2: 'Or take a photo of the product label for AI analysis',
                instruction_3: 'View complete safety and handling information',
                scan_barcode: 'Scan Barcode',
                take_photo: 'Take Photo',
                upload_image: 'Upload Image',
                scanning_barcode: 'Point camera at barcode...',
                cancel: 'Cancel',
                scan_another: 'Scan Another Product',
                step_1: 'Detecting product...',
                step_2: 'Analyzing hazards...',
                step_3: 'Extracting safety data...',
                step_4: 'Analysis complete!',
                step_1_short: 'Detect',
                step_2_short: 'Analyze',
                step_3_short: 'Extract',
                step_4_short: 'Done',
                error_title: 'Analysis Error',
                reset: 'Reset',
                ghs_pictograms: 'GHS Pictograms',
                hazard_statements: 'Hazard Statements (H)',
                precautionary_statements: 'Precautionary Statements (P)',
                prevention: 'Prevention',
                response: 'Response',
                storage: 'Storage',
                disposal: 'Disposal',
                handling: 'Handling Instructions',
                ppe_required: 'PPE Required',
                ventilation: 'Ventilation',
                temperature: 'Temperature Requirements',
                emergency: 'Emergency Information',
                fire_fighting: 'Fire Fighting',
                spill_response: 'Spill Response',
                first_aid: 'First Aid',
                inhalation: 'Inhalation',
                skin_contact: 'Skin Contact',
                eye_contact: 'Eye Contact',
                ingestion: 'Ingestion',
                disposal_info: 'Disposal Information',
                transport: 'Transport',
                waste_code: 'Waste Code',
                disposal_method: 'Disposal Method',
                adr_class: 'ADR Class',
                confidence: 'Confidence'
            },
            de: {
                instructions_title: 'Anleitung',
                instruction_1: 'Scannen Sie den Barcode auf dem Produkt für sofortige Abfrage',
                instruction_2: 'Oder fotografieren Sie das Produktetikett für KI-Analyse',
                instruction_3: 'Sehen Sie vollständige Sicherheits- und Handhabungsinformationen',
                scan_barcode: 'Barcode scannen',
                take_photo: 'Foto aufnehmen',
                upload_image: 'Bild hochladen',
                scanning_barcode: 'Kamera auf Barcode richten...',
                cancel: 'Abbrechen',
                scan_another: 'Weiteres Produkt scannen',
                step_1: 'Produkt wird erkannt...',
                step_2: 'Gefahren werden analysiert...',
                step_3: 'Sicherheitsdaten werden extrahiert...',
                step_4: 'Analyse abgeschlossen!',
                step_1_short: 'Erkennen',
                step_2_short: 'Analysieren',
                step_3_short: 'Extrahieren',
                step_4_short: 'Fertig',
                error_title: 'Analysefehler',
                reset: 'Zurücksetzen',
                ghs_pictograms: 'GHS-Piktogramme',
                hazard_statements: 'Gefahrenhinweise (H)',
                precautionary_statements: 'Sicherheitshinweise (P)',
                prevention: 'Prävention',
                response: 'Reaktion',
                storage: 'Lagerung',
                disposal: 'Entsorgung',
                handling: 'Handhabungshinweise',
                ppe_required: 'Erforderliche PSA',
                ventilation: 'Belüftung',
                temperature: 'Temperaturanforderungen',
                emergency: 'Notfallinformationen',
                fire_fighting: 'Brandbekämpfung',
                spill_response: 'Maßnahmen bei Verschütten',
                first_aid: 'Erste Hilfe',
                inhalation: 'Einatmen',
                skin_contact: 'Hautkontakt',
                eye_contact: 'Augenkontakt',
                ingestion: 'Verschlucken',
                disposal_info: 'Entsorgungsinformationen',
                transport: 'Transport',
                waste_code: 'Abfallschlüssel',
                disposal_method: 'Entsorgungsmethode',
                adr_class: 'ADR-Klasse',
                confidence: 'Konfidenz'
            }
        },

        t(key) {
            return this.labels[this.locale]?.[key] || this.labels['en'][key] || key;
        },

        startScanning(imageData) {
            this.imagePreview = imageData;
            this.isScanning = true;
            this.currentStep = 1;
            this.scanLineY = 0;
            this.scanDirection = 1;

            // Animate scan line
            this.scanInterval = setInterval(() => {
                this.scanLineY += this.scanDirection * 2;
                if (this.scanLineY >= 100) this.scanDirection = -1;
                if (this.scanLineY <= 0) this.scanDirection = 1;
            }, 40);

            // Progress through steps - SLOWER timing for AI processing
            let stepCount = 0;
            this.stepInterval = setInterval(() => {
                stepCount++;
                // Step 1 -> 2 after 3 seconds
                // Step 2 -> 3 after 7 seconds
                // Stay on step 3 until AI completes
                if (stepCount === 3 && this.currentStep === 1) {
                    this.currentStep = 2;
                } else if (stepCount === 7 && this.currentStep === 2) {
                    this.currentStep = 3;
                }
            }, 1000);

            // Call Livewire to process
            $wire.dispatch('process-image', { imageData: imageData });
        },

        stopScanning() {
            if (this.stepInterval) { clearInterval(this.stepInterval); this.stepInterval = null; }
            if (this.scanInterval) { clearInterval(this.scanInterval); this.scanInterval = null; }
            this.currentStep = 4;
            setTimeout(() => {
                this.isScanning = false;
                this.currentStep = 0;
            }, 800);
        },

        reset() {
            this.imagePreview = null;
            this.isScanning = false;
            this.currentStep = 0;
            if (this.stepInterval) clearInterval(this.stepInterval);
            if (this.scanInterval) clearInterval(this.scanInterval);
        }
    }"
    x-init="
        $watch('$wire.result', value => { if (value) stopScanning(); });
        $watch('$wire.error', value => { if (value) stopScanning(); });
    "
    class="relative"
>
    {{-- Language Switcher --}}
    <div class="absolute -top-16 right-0 flex items-center gap-1 z-10">
        <button
            wire:click="setLocale('en')"
            class="lang-btn"
            :class="locale === 'en' ? 'active' : ''"
            title="English"
        >EN</button>
        <button
            wire:click="setLocale('de')"
            class="lang-btn"
            :class="locale === 'de' ? 'active' : ''"
            title="Deutsch"
        >DE</button>
    </div>

    <div class="space-y-6">

        {{-- Error Display --}}
        @if($error)
            <div class="card-hazard p-4 fade-in">
                <div class="flex items-start gap-3">
                    <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div>
                        <h3 class="font-semibold text-red-800" x-text="t('error_title')"></h3>
                        <p class="text-red-700 text-sm mt-1">{{ $error }}</p>
                    </div>
                </div>
                <button wire:click="resetScan" @click="reset()" class="mt-4 btn-secondary w-full" x-text="t('reset')"></button>
            </div>
        @endif

        {{-- Scanning Animation --}}
        <div x-show="isScanning" x-cloak class="space-y-4 fade-in">
            <div class="card overflow-hidden">
                {{-- Small image with scanning effect --}}
                <div class="p-4 flex justify-center bg-gray-900">
                    <div class="relative w-48 h-48 rounded-lg overflow-hidden">
                        <img :src="imagePreview" alt="Scanning..." class="w-full h-full object-cover">
                        {{-- Scan overlay --}}
                        <div class="absolute inset-0 pointer-events-none">
                            <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/20"></div>
                            {{-- Scan line --}}
                            <div class="absolute left-0 right-0 h-0.5 bg-red-500 shadow-lg shadow-red-500/50" :style="'top: ' + scanLineY + '%'">
                                <div class="absolute inset-x-0 h-6 -top-3 bg-gradient-to-b from-red-500/30 to-transparent"></div>
                            </div>
                            {{-- Corners --}}
                            <div class="absolute top-2 left-2 w-5 h-5 border-l-2 border-t-2 border-red-500"></div>
                            <div class="absolute top-2 right-2 w-5 h-5 border-r-2 border-t-2 border-red-500"></div>
                            <div class="absolute bottom-2 left-2 w-5 h-5 border-l-2 border-b-2 border-red-500"></div>
                            <div class="absolute bottom-2 right-2 w-5 h-5 border-r-2 border-b-2 border-red-500"></div>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="p-3 bg-gray-800 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-white text-sm font-medium" x-text="t('step_' + currentStep)"></span>
                    </div>
                </div>

                {{-- Progress Steps --}}
                <div class="p-4 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <template x-for="step in [1, 2, 3, 4]" :key="step">
                            <div class="flex items-center" :class="step < 4 ? 'flex-1' : ''">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-300"
                                     :class="{
                                         'bg-green-500 text-white': currentStep > step,
                                         'bg-red-500 text-white animate-pulse ring-4 ring-red-500/30': currentStep === step,
                                         'bg-gray-200 text-gray-400': currentStep < step
                                     }">
                                    <svg x-show="currentStep > step" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span x-show="currentStep <= step" x-text="step"></span>
                                </div>
                                <div x-show="step < 4" class="flex-1 h-1 mx-2 rounded transition-all duration-500"
                                     :class="currentStep > step ? 'bg-green-500' : 'bg-gray-200'"></div>
                            </div>
                        </template>
                    </div>
                    <div class="flex justify-between mt-2 px-1">
                        <span class="text-xs" :class="currentStep >= 1 ? 'text-gray-700 font-medium' : 'text-gray-400'" x-text="t('step_1_short')"></span>
                        <span class="text-xs" :class="currentStep >= 2 ? 'text-gray-700 font-medium' : 'text-gray-400'" x-text="t('step_2_short')"></span>
                        <span class="text-xs" :class="currentStep >= 3 ? 'text-gray-700 font-medium' : 'text-gray-400'" x-text="t('step_3_short')"></span>
                        <span class="text-xs" :class="currentStep >= 4 ? 'text-gray-700 font-medium' : 'text-gray-400'" x-text="t('step_4_short')"></span>
                    </div>
                </div>
            </div>
            <button wire:click="resetScan" @click="reset()" class="btn-secondary w-full" x-text="t('cancel')"></button>
        </div>

        {{-- Result Display --}}
        @if($result)
            <div x-show="!isScanning" class="space-y-4 slide-up">
                {{-- Product Header with Image --}}
                <div class="card-hazard p-5">
                    <div class="flex gap-4">
                        @if($scannedImage)
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-red-200 shadow-sm">
                                    <img src="{{ $scannedImage }}" alt="Scanned product" class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-2">
                                <h2 class="text-lg font-bold text-gray-900 leading-tight">{{ $result['product_name'] }}</h2>
                                @if(isset($result['hazard_classification']['signal_word']) && $result['hazard_classification']['signal_word'] !== 'none')
                                    <span class="flex-shrink-0 {{ $result['hazard_classification']['danger_level'] === 'danger' ? 'signal-danger' : 'signal-warning' }} text-xs">
                                        {{ $result['hazard_classification']['signal_word'] }}
                                    </span>
                                @endif
                            </div>
                            @if($result['manufacturer'])
                                <p class="text-gray-600 text-sm mt-1">{{ $result['manufacturer'] }}</p>
                            @endif
                            <div class="flex flex-wrap gap-2 mt-2">
                                @if($result['un_number'])
                                    <span class="bg-amber-100 text-amber-800 px-2 py-0.5 rounded text-xs font-medium">{{ $result['un_number'] }}</span>
                                @endif
                                @if($result['cas_number'])
                                    <span class="bg-gray-100 text-gray-600 px-2 py-0.5 rounded text-xs">CAS: {{ $result['cas_number'] }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- GHS Pictograms --}}
                @if(!empty($result['ghs_pictograms']))
                    <div class="card p-4">
                        <h3 class="font-semibold text-gray-900 mb-3 text-sm" x-text="t('ghs_pictograms')"></h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($result['ghs_pictograms'] as $pictogram)
                                <div class="w-12 h-12">
                                    <img src="/images/ghs/{{ strtolower($pictogram) }}.svg" alt="{{ $pictogram }}" class="w-full h-full">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Hazard Statements --}}
                @if(!empty($result['hazard_statements']))
                    <div class="card overflow-hidden" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                            <h3 class="font-semibold text-gray-900 text-sm" x-text="t('hazard_statements')"></h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="px-4 pb-4 space-y-1.5">
                            @foreach($result['hazard_statements'] as $statement)
                                <div class="flex gap-2 text-sm">
                                    <span class="font-mono font-semibold text-red-600 flex-shrink-0 text-xs">{{ $statement['code'] }}</span>
                                    <span class="text-gray-700">{{ $statement['text'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Precautionary Statements --}}
                @if(!empty($result['precautionary_statements']))
                    <div class="card overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                            <h3 class="font-semibold text-gray-900 text-sm" x-text="t('precautionary_statements')"></h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="px-4 pb-4">
                            @foreach(['prevention', 'response', 'storage', 'disposal'] as $key)
                                @if(!empty($result['precautionary_statements'][$key]))
                                    <div class="mb-3">
                                        <h4 class="text-xs font-medium text-pz-teal mb-1.5" x-text="t('{{ $key }}')"></h4>
                                        @foreach($result['precautionary_statements'][$key] as $statement)
                                            <div class="flex gap-2 text-sm mb-1">
                                                <span class="font-mono font-semibold text-blue-600 text-xs">{{ $statement['code'] }}</span>
                                                <span class="text-gray-700 text-xs">{{ $statement['text'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Handling Instructions --}}
                @if(!empty($result['handling_instructions']))
                    <div class="card overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                            <h3 class="font-semibold text-gray-900 text-sm" x-text="t('handling')"></h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">
                            @if(!empty($result['handling_instructions']['ppe_required']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-1" x-text="t('ppe_required')"></h4>
                                    <ul class="list-disc list-inside text-xs text-gray-700 space-y-0.5">
                                        @foreach($result['handling_instructions']['ppe_required'] as $ppe)
                                            <li>{{ $ppe }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(!empty($result['handling_instructions']['ventilation']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-0.5" x-text="t('ventilation')"></h4>
                                    <p class="text-xs text-gray-700">{{ $result['handling_instructions']['ventilation'] }}</p>
                                </div>
                            @endif
                            @if(!empty($result['handling_instructions']['temperature']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-0.5" x-text="t('temperature')"></h4>
                                    <p class="text-xs text-gray-700">{{ $result['handling_instructions']['temperature'] }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Emergency Information --}}
                @if(!empty($result['emergency_info']))
                    <div class="card-hazard overflow-hidden" x-data="{ open: true }">
                        <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-red-50/50 transition-colors">
                            <h3 class="font-semibold text-red-800 text-sm" x-text="t('emergency')"></h3>
                            <svg class="w-5 h-5 text-red-600 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">
                            @if(!empty($result['emergency_info']['fire_fighting']))
                                <div>
                                    <h4 class="text-xs font-medium text-red-700 mb-0.5" x-text="t('fire_fighting')"></h4>
                                    <p class="text-xs text-gray-700">{{ $result['emergency_info']['fire_fighting'] }}</p>
                                </div>
                            @endif
                            @if(!empty($result['emergency_info']['spill_response']))
                                <div>
                                    <h4 class="text-xs font-medium text-red-700 mb-0.5" x-text="t('spill_response')"></h4>
                                    <p class="text-xs text-gray-700">{{ $result['emergency_info']['spill_response'] }}</p>
                                </div>
                            @endif
                            @if(!empty($result['emergency_info']['first_aid']))
                                <div>
                                    <h4 class="text-xs font-medium text-red-700 mb-1.5" x-text="t('first_aid')"></h4>
                                    <div class="space-y-1.5">
                                        @foreach(['inhalation', 'skin_contact', 'eye_contact', 'ingestion'] as $type)
                                            @if(!empty($result['emergency_info']['first_aid'][$type]))
                                                <div class="bg-red-50 rounded p-2">
                                                    <span class="font-medium text-red-800 text-xs" x-text="t('{{ $type }}') + ':'"></span>
                                                    <p class="text-xs text-gray-700 mt-0.5">{{ $result['emergency_info']['first_aid'][$type] }}</p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Disposal & Transport --}}
                @if((!empty($result['disposal']) && (!empty($result['disposal']['waste_code']) || !empty($result['disposal']['method']))) || (!empty($result['transport']) && !empty($result['transport']['adr_class'])))
                    <div class="card overflow-hidden" x-data="{ open: false }">
                        <button @click="open = !open" class="w-full p-4 flex items-center justify-between text-left hover:bg-gray-50 transition-colors">
                            <h3 class="font-semibold text-gray-900 text-sm"><span x-text="t('disposal_info')"></span> & <span x-text="t('transport')"></span></h3>
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" x-collapse class="px-4 pb-4 space-y-3">
                            @if(!empty($result['disposal']['waste_code']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-0.5" x-text="t('waste_code')"></h4>
                                    <span class="font-mono bg-gray-100 px-1.5 py-0.5 rounded text-xs">{{ $result['disposal']['waste_code'] }}</span>
                                </div>
                            @endif
                            @if(!empty($result['disposal']['method']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-0.5" x-text="t('disposal_method')"></h4>
                                    <p class="text-xs text-gray-700">{{ $result['disposal']['method'] }}</p>
                                </div>
                            @endif
                            @if(!empty($result['transport']['adr_class']))
                                <div>
                                    <h4 class="text-xs font-medium text-pz-teal mb-0.5" x-text="t('adr_class')"></h4>
                                    <span class="bg-amber-100 text-amber-800 px-1.5 py-0.5 rounded text-xs font-medium">{{ $result['transport']['adr_class'] }}</span>
                                    @if(!empty($result['transport']['packing_group']))
                                        <span class="text-xs text-gray-600 ml-2">PG: {{ $result['transport']['packing_group'] }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- Confidence --}}
                @if(isset($result['confidence']))
                    <div class="text-center text-xs text-gray-500">
                        <span x-text="t('confidence')"></span>:
                        @if($result['confidence'] >= 0.8)
                            <span class="text-green-600 font-medium">{{ number_format($result['confidence'] * 100) }}%</span>
                        @elseif($result['confidence'] >= 0.5)
                            <span class="text-amber-600 font-medium">{{ number_format($result['confidence'] * 100) }}%</span>
                        @else
                            <span class="text-red-600 font-medium">{{ number_format($result['confidence'] * 100) }}%</span>
                        @endif
                    </div>
                @endif

                {{-- Scan Another --}}
                <button wire:click="resetScan" @click="reset()" class="btn-primary w-full" x-text="t('scan_another')"></button>
            </div>
        @endif

        {{-- Scanner Interface --}}
        @if(!$result && !$error)
            <div x-show="!isScanning" class="space-y-6">
                {{-- Instructions --}}
                <div class="card p-5">
                    <h2 class="text-lg font-semibold text-pz-teal mb-3" x-text="t('instructions_title')"></h2>
                    <ol class="space-y-2 text-sm text-gray-700">
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-pz-teal text-white flex items-center justify-center text-xs font-bold">1</span>
                            <span x-text="t('instruction_1')"></span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-pz-teal text-white flex items-center justify-center text-xs font-bold">2</span>
                            <span x-text="t('instruction_2')"></span>
                        </li>
                        <li class="flex gap-3">
                            <span class="flex-shrink-0 w-6 h-6 rounded-full bg-pz-teal text-white flex items-center justify-center text-xs font-bold">3</span>
                            <span x-text="t('instruction_3')"></span>
                        </li>
                    </ol>
                </div>

                @if($showScanner)
                    <div class="card p-5 fade-in">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-semibold text-gray-900" x-text="t('scanning_barcode')"></h3>
                            <button wire:click="stopScanner" class="text-gray-500 hover:text-gray-700">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div id="barcode-reader" class="rounded-lg overflow-hidden"></div>
                    </div>
                @else
                    <div class="grid grid-cols-1 gap-4">
                        <button wire:click="startScanner" class="btn-hazard flex items-center justify-center gap-3 pulse-hazard">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h2M4 12h2m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                            </svg>
                            <span x-text="t('scan_barcode')"></span>
                        </button>

                        <button onclick="document.getElementById('camera-input').click()" class="btn-secondary flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span x-text="t('take_photo')"></span>
                        </button>
                        <input type="file" id="camera-input" accept="image/*" capture="environment" class="hidden" onchange="handleImageCapture(this)">

                        <label class="btn-secondary flex items-center justify-center gap-3 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="t('upload_image')"></span>
                            <input type="file" accept="image/*" class="hidden" onchange="handleImageCapture(this)">
                        </label>
                    </div>
                @endif
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        let html5QrCode = null;

        const observer = new MutationObserver(() => {
            const el = document.getElementById('barcode-reader');
            if (el && !html5QrCode) initBarcodeScanner();
            else if (!el && html5QrCode) stopBarcodeScanner();
        });
        observer.observe(document.body, { childList: true, subtree: true });

        function initBarcodeScanner() {
            const el = document.getElementById('barcode-reader');
            if (!el) return;
            html5QrCode = new Html5Qrcode("barcode-reader");
            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: { width: 250, height: 150 }, formatsToSupport: [
                    Html5QrcodeSupportedFormats.EAN_13, Html5QrcodeSupportedFormats.EAN_8,
                    Html5QrcodeSupportedFormats.UPC_A, Html5QrcodeSupportedFormats.CODE_128,
                    Html5QrcodeSupportedFormats.QR_CODE
                ]},
                (text) => { stopBarcodeScanner(); @this.processBarcode(text); },
                () => {}
            ).catch(console.error);
        }

        function stopBarcodeScanner() {
            if (html5QrCode) {
                html5QrCode.stop().then(() => { html5QrCode.clear(); html5QrCode = null; }).catch(console.error);
            }
        }

        function handleImageCapture(input) {
            if (!input.files?.[0]) return;
            const reader = new FileReader();
            reader.onload = (e) => {
                const component = Alpine.$data(document.querySelector('[x-data]'));
                if (component) component.startScanning(e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
            input.value = '';
        }

        window.addEventListener('beforeunload', stopBarcodeScanner);
    </script>
    @endpush
</div>
