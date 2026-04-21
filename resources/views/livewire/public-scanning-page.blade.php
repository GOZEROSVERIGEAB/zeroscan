<div class="max-w-lg mx-auto px-4 py-6 flex-1 flex flex-col" x-data="cameraCapture()">

    {{-- Info Step --}}
    @if($currentStep === 'info')
        <div class="flex-1 flex flex-col justify-center">
            <div class="text-center mb-8">
                @if($station->logo_path)
                    <img src="{{ Storage::url($station->logo_path) }}" alt="{{ $station->name }}" class="h-24 mx-auto mb-6 object-contain">
                @endif

                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('scanit.public.welcome_title') }}</h2>

                <div class="prose prose-gray mx-auto text-gray-600">
                    @if($station->info_page_text)
                        {!! nl2br(e($station->info_page_text)) !!}
                    @else
                        <p>{{ __('scanit.public.default_info_text') }}</p>
                    @endif
                </div>
            </div>

            <div class="mt-auto">
                <button
                    wire:click="startCapture"
                    class="w-full text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-lg"
                    style="background-color: {{ $station->primary_color ?? '#65a30d' }};"
                >
                    {{ __('scanit.public.start_scanning') }}
                </button>
            </div>
        </div>
    @endif

    {{-- Capture Step --}}
    @if($currentStep === 'capture')
        <div class="flex-1 flex flex-col">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ __('scanit.public.capture_title') }}</h2>
                <p class="text-gray-600">{{ __('scanit.public.capture_description') }}</p>
            </div>

            {{-- Progress --}}
            <div class="mb-4 text-sm text-gray-600">
                {{ __('scanit.public.images_taken', ['count' => count($images) + count($tempImages), 'max' => $this->maxImages]) }}
            </div>

            {{-- Image Grid --}}
            <div class="grid grid-cols-2 gap-4 mb-6">
                @for($slot = 1; $slot <= $this->maxImages; $slot++)
                    <div class="relative aspect-square bg-gray-100 rounded-lg border-2 border-dashed border-gray-300 overflow-hidden
                        {{ $slot === $this->maxImages && $this->maxImages % 2 === 1 ? 'col-span-2 aspect-video' : '' }}">

                        @if(isset($images[$slot]) || isset($tempImages[$slot]))
                            {{-- Image Preview --}}
                            <img
                                src="{{ isset($images[$slot]) ? Storage::url($images[$slot]) : $tempImages[$slot] }}"
                                alt="Image {{ $slot }}"
                                class="w-full h-full object-cover"
                            >
                            <button
                                wire:click="removeImage({{ $slot }})"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-2 shadow-lg"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        @else
                            {{-- Empty Slot --}}
                            <button
                                @click="openCamera({{ $slot }})"
                                class="w-full h-full flex flex-col items-center justify-center text-gray-400 hover:text-lime-600 hover:border-lime-600 transition-colors duration-200"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ __('scanit.public.add_image') }}</span>
                            </button>
                        @endif
                    </div>
                @endfor
            </div>

            @error('images')
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm">
                    {{ $message }}
                </div>
            @enderror

            <div class="mt-auto">
                <button
                    wire:click="proceedToEmail"
                    wire:loading.attr="disabled"
                    class="w-full disabled:bg-gray-400 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-lg"
                    style="background-color: {{ $station->primary_color ?? '#65a30d' }};"
                >
                    <span wire:loading.remove>{{ __('scanit.public.done_proceed') }}</span>
                    <span wire:loading>{{ __('scanit.public.processing') }}</span>
                </button>
            </div>
        </div>

        {{-- Camera Modal --}}
        <div
            x-show="showCamera"
            x-cloak
            class="fixed inset-0 z-50 bg-black flex flex-col"
        >
            <div class="flex-1 relative">
                <video x-ref="video" autoplay playsinline class="w-full h-full object-cover"></video>
                <canvas x-ref="canvas" class="hidden"></canvas>
            </div>

            <div class="bg-black p-6 flex items-center justify-center gap-6">
                <button
                    @click="closeCamera()"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 px-6 rounded-lg"
                >
                    {{ __('scanit.public.cancel') }}
                </button>
                <button
                    @click="capturePhoto()"
                    class="text-white font-semibold py-4 px-8 rounded-full"
                    style="background-color: {{ $station->primary_color ?? '#65a30d' }};"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>
            </div>
        </div>
    @endif

    {{-- Email Step --}}
    @if($currentStep === 'email')
        <div class="flex-1 flex flex-col">
            <div class="mb-6">
                <h2 class="text-xl font-bold text-gray-900 mb-2">{{ __('scanit.public.email_title') }}</h2>
                <p class="text-gray-600">{{ __('scanit.public.email_description') }}</p>
            </div>

            <div class="space-y-4 mb-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('scanit.public.email_label') }}
                    </label>
                    <input
                        type="email"
                        id="email"
                        wire:model="email"
                        placeholder="{{ __('scanit.public.email_placeholder') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-lime-500 focus:border-lime-500 transition-colors duration-200"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-start">
                    <input
                        type="checkbox"
                        id="gdpr"
                        wire:model="gdprAccepted"
                        class="mt-1 h-5 w-5 text-lime-600 focus:ring-lime-500 border-gray-300 rounded"
                    >
                    <label for="gdpr" class="ml-3 text-sm text-gray-600">
                        {{ __('scanit.public.gdpr_text') }}
                        @if($station->gdpr_url)
                            <a href="{{ $station->gdpr_url }}" target="_blank" class="text-lime-600 hover:text-lime-700 underline">
                                {{ __('scanit.public.privacy_policy_link') }}
                            </a>
                        @else
                            <a href="{{ route('policy.show') }}" target="_blank" class="text-lime-600 hover:text-lime-700 underline">
                                {{ __('scanit.public.privacy_policy_link') }}
                            </a>
                        @endif
                    </label>
                </div>
                @error('gdpr')
                    <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-auto space-y-3">
                <button
                    wire:click="completeScan"
                    wire:loading.attr="disabled"
                    class="w-full disabled:bg-gray-400 text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-lg"
                    style="background-color: {{ $station->primary_color ?? '#65a30d' }};"
                >
                    <span wire:loading.remove>{{ __('scanit.public.submit') }}</span>
                    <span wire:loading>{{ __('scanit.public.processing') }}</span>
                </button>

                @if(!$station->require_email)
                    <button
                        wire:click="skipEmail"
                        class="w-full text-gray-600 hover:text-gray-800 font-medium py-2 underline"
                    >
                        {{ __('scanit.public.skip_email') }}
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- Thank You Step --}}
    @if($currentStep === 'thankyou')
        <div class="flex-1 flex flex-col justify-center">
            <div class="text-center mb-8">
                <div class="mx-auto w-16 h-16 rounded-full flex items-center justify-center mb-6" style="background-color: {{ $station->primary_color ?? '#65a30d' }}20;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" style="color: {{ $station->primary_color ?? '#65a30d' }};" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ __('scanit.public.thankyou_title') }}</h2>

                @if($station->thank_you_text)
                    <p class="text-gray-600 mb-4">{!! nl2br(e($station->thank_you_text)) !!}</p>
                @else
                    <p class="text-gray-600 mb-4">{{ __('scanit.public.thankyou_message') }}</p>
                @endif

                @if($email)
                    <p class="text-sm text-gray-500">
                        {{ __('scanit.public.report_will_be_sent', ['email' => $email]) }}
                    </p>
                @endif
            </div>

            <div class="mt-auto">
                <button
                    wire:click="scanMore"
                    class="w-full text-white font-semibold py-4 px-6 rounded-lg transition-colors duration-200 text-lg"
                    style="background-color: {{ $station->primary_color ?? '#65a30d' }};"
                >
                    {{ __('scanit.public.scan_more') }}
                </button>
            </div>
        </div>
    @endif
</div>
