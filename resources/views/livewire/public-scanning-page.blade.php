<div class="fade-in">
    {{-- Progress Bar --}}
    @if($step > 1 && $step < 4)
        <div class="mb-6">
            <div class="progress-bar">
                <div class="progress-bar-fill" style="width: {{ $this->progress }}%"></div>
            </div>
            <p class="text-center text-sm text-gray-500 mt-2">Steg {{ $step }} av 3</p>
        </div>
    @endif

    {{-- Step 1: Welcome --}}
    @if($step === 1)
        <div class="slide-up">
            {{-- Hero Icon --}}
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-3xl bg-gradient-to-br from-[#97d700] to-[#7ab800] shadow-xl pulse-green">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Station Info --}}
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-[#005151] mb-2">{{ $station->name }}</h1>
                @if($station->facility)
                    <p class="text-gray-600">{{ $station->facility->name }}</p>
                @endif
            </div>

            {{-- Info Card --}}
            <div class="card p-6 mb-8">
                @if($station->info_page_text)
                    <div class="text-gray-600 text-center mb-6 prose prose-sm max-w-none">
                        {!! nl2br(e($station->info_page_text)) !!}
                    </div>
                @else
                    <p class="text-gray-600 text-center mb-6">
                        Fotografera föremålen du tar med dig så beräknar vi miljöbesparingen!
                    </p>
                @endif

                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-[#005151]/10 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500">Ta bilder</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-[#005151]/10 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500">AI analyserar</p>
                    </div>
                    <div>
                        <div class="w-12 h-12 rounded-xl bg-[#005151]/10 flex items-center justify-center mx-auto mb-2">
                            <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500">Få rapport</p>
                    </div>
                </div>
            </div>

            {{-- CTA Button --}}
            <button
                wire:click="startScanning"
                class="btn-primary w-full text-lg flex items-center justify-center gap-3"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                </svg>
                Börja skanna
            </button>

            {{-- Max images info --}}
            <p class="text-center text-sm text-gray-400 mt-4">
                Du kan fotografera upp till {{ $maxImages }} föremål
            </p>
        </div>
    @endif

    {{-- Step 2: Photo Capture --}}
    @if($step === 2)
        <div class="slide-up">
            <div class="text-center mb-6">
                <h2 class="text-xl font-bold text-[#005151] mb-2">Ta bilder på föremålen</h2>
                <p class="text-gray-500 text-sm">{{ count($uploadedPhotos) }} av {{ $maxImages }} bilder</p>
            </div>

            {{-- Upload Area --}}
            @if(count($uploadedPhotos) < $maxImages)
                <div class="mb-6">
                    <label class="block">
                        <div class="card border-2 border-dashed border-[#97d700] hover:border-[#7ab800] transition-colors cursor-pointer p-8 text-center">
                            <input
                                type="file"
                                wire:model="photos"
                                accept="image/*"
                                capture="environment"
                                multiple
                                class="hidden"
                            >
                            <div class="w-16 h-16 rounded-2xl bg-[#97d700]/20 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                            </div>
                            <p class="text-[#005151] font-medium mb-1">Tryck för att ta bild</p>
                            <p class="text-gray-400 text-sm">eller välj från biblioteket</p>
                        </div>
                    </label>

                    {{-- Loading state --}}
                    <div wire:loading wire:target="photos" class="mt-4 text-center">
                        <div class="spinner mx-auto mb-2"></div>
                        <p class="text-sm text-gray-500">Laddar upp...</p>
                    </div>
                </div>
            @endif

            {{-- Photo Grid --}}
            @if(count($uploadedPhotos) > 0)
                <div class="grid grid-cols-2 gap-4 mb-6">
                    @foreach($uploadedPhotos as $index => $photo)
                        <div class="relative rounded-xl overflow-hidden shadow-md fade-in">
                            <img
                                src="{{ $photo['url'] }}"
                                alt="Foto {{ $index + 1 }}"
                                class="w-full h-32 object-cover"
                            >
                            <button
                                wire:click="removePhoto({{ $index }})"
                                class="absolute top-2 right-2 w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full flex items-center justify-center shadow-lg transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                            <div class="absolute bottom-2 left-2 bg-black/50 text-white text-xs px-2 py-1 rounded-full">
                                {{ $index + 1 }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Error --}}
            @error('photos')
                <p class="text-red-500 text-sm text-center mb-4">{{ $message }}</p>
            @enderror

            {{-- Continue Button --}}
            <button
                wire:click="goToContactStep"
                @if(count($uploadedPhotos) === 0) disabled @endif
                class="btn-primary w-full flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
            >
                Fortsätt
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- Step 3: Contact Info --}}
    @if($step === 3)
        <div class="slide-up">
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-2xl bg-[#005151]/10 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-[#005151] mb-2">Vill du ha en miljörapport?</h2>
                <p class="text-gray-500 text-sm">Vi analyserar dina bilder och skickar en detaljerad rapport</p>
            </div>

            {{-- Toggle --}}
            <div class="card p-6 mb-6">
                <button
                    wire:click="toggleWantsReport"
                    class="w-full flex items-center justify-between"
                >
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl {{ $wantsReport ? 'bg-[#97d700]' : 'bg-gray-100' }} flex items-center justify-center transition-colors">
                            <svg class="w-6 h-6 {{ $wantsReport ? 'text-white' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-[#005151]">Skicka rapport via e-post</p>
                            <p class="text-sm text-gray-500">Få din miljöbesparing</p>
                        </div>
                    </div>
                    <div class="w-12 h-7 rounded-full {{ $wantsReport ? 'bg-[#97d700]' : 'bg-gray-200' }} relative transition-colors">
                        <div class="w-5 h-5 rounded-full bg-white shadow absolute top-1 transition-all {{ $wantsReport ? 'right-1' : 'left-1' }}"></div>
                    </div>
                </button>

                {{-- Contact Fields --}}
                @if($wantsReport)
                    <div class="mt-6 space-y-4 fade-in">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Namn (valfritt)</label>
                            <input
                                type="text"
                                wire:model="visitorName"
                                placeholder="Ditt namn"
                                class="w-full"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">E-post <span class="text-red-500">*</span></label>
                            <input
                                type="email"
                                wire:model="visitorEmail"
                                placeholder="din@epost.se"
                                class="w-full"
                            >
                            @error('visitorEmail')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- GDPR Consent --}}
                        <div class="pt-4 border-t border-gray-100">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input
                                    type="checkbox"
                                    wire:model="gdprConsent"
                                    class="mt-1 w-5 h-5 rounded border-gray-300 text-[#97d700] focus:ring-[#97d700]"
                                >
                                <span class="text-sm text-gray-600">
                                    Jag godkänner att mina personuppgifter (namn och e-post) lagras i upp till 365 dagar för att skicka miljörapporten och förbättra tjänsten.
                                    @if($station->gdpr_url)
                                        <a href="{{ $station->gdpr_url }}" target="_blank" class="text-[#005151] underline hover:no-underline">Läs vår integritetspolicy</a>
                                    @else
                                        <a href="{{ route('legal.privacy') }}" target="_blank" class="text-[#005151] underline hover:no-underline">Läs vår integritetspolicy</a>
                                    @endif
                                </span>
                            </label>
                            @error('gdprConsent')
                                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endif
            </div>

            {{-- Summary --}}
            <div class="card p-4 mb-6 bg-[#005151]/5">
                <div class="flex items-center gap-4">
                    <div class="flex -space-x-2">
                        @foreach(array_slice($uploadedPhotos, 0, 3) as $photo)
                            <img src="{{ $photo['url'] }}" class="w-10 h-10 rounded-lg object-cover border-2 border-white">
                        @endforeach
                        @if(count($uploadedPhotos) > 3)
                            <div class="w-10 h-10 rounded-lg bg-[#005151] text-white text-xs font-bold flex items-center justify-center border-2 border-white">
                                +{{ count($uploadedPhotos) - 3 }}
                            </div>
                        @endif
                    </div>
                    <div>
                        <p class="font-medium text-[#005151]">{{ count($uploadedPhotos) }} föremål</p>
                        <p class="text-sm text-gray-500">Redo för analys</p>
                    </div>
                </div>
            </div>

            {{-- Submit Button --}}
            <button
                wire:click="submitScan"
                wire:loading.attr="disabled"
                class="btn-primary w-full flex items-center justify-center gap-2"
            >
                <span wire:loading.remove wire:target="submitScan">
                    {{ $wantsReport ? 'Skicka och få rapport' : 'Slutför' }}
                </span>
                <span wire:loading wire:target="submitScan" class="flex items-center gap-2">
                    <div class="w-5 h-5 border-2 border-white/30 border-t-white rounded-full animate-spin"></div>
                    Skickar...
                </span>
            </button>

            {{-- Back link --}}
            <button
                wire:click="$set('step', 2)"
                class="w-full text-center text-gray-500 hover:text-[#005151] mt-4 py-2 transition-colors"
            >
                ← Tillbaka till bilderna
            </button>
        </div>
    @endif

    {{-- Step 4: Thank You --}}
    @if($step === 4)
        <div class="slide-up text-center">
            {{-- Success Icon --}}
            <div class="mb-8">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-[#97d700] shadow-xl">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>

            {{-- Message --}}
            <h2 class="text-2xl font-bold text-[#005151] mb-3">Tack för ditt bidrag!</h2>
            <p class="text-gray-600 mb-8">
                @if($wantsReport && $visitorEmail)
                    Vi analyserar dina bilder och skickar en miljörapport till <strong>{{ $visitorEmail }}</strong>
                @else
                    Dina bilder analyseras och bidrar till miljöstatistiken.
                @endif
            </p>

            {{-- Info Card --}}
            <div class="card p-6 mb-8 text-left">
                <h3 class="font-semibold text-[#005151] mb-4">Vad händer nu?</h3>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-[#97d700]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-600">AI analyserar varje föremål</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="w-6 h-6 rounded-full bg-[#97d700]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span class="text-gray-600">Beräknar CO₂, vatten och energibesparing</span>
                    </li>
                    @if($wantsReport && $visitorEmail)
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full bg-[#97d700]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <span class="text-gray-600">Skickar din personliga miljörapport</span>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Environmental Message --}}
            <div class="p-6 rounded-2xl bg-gradient-to-br from-[#005151] to-[#006666] text-white">
                <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <p class="text-white/90 text-sm">
                    Genom att välja återbruk istället för nytt bidrar du till en mer hållbar framtid. Varje föremål som återanvänds sparar resurser och minskar utsläpp.
                </p>
            </div>
        </div>
    @endif
</div>
