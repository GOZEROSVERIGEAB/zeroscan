@props(['station' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $station->name ?? config('app.name', 'ScanIT') }} - {{ __('scanit.public.title') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50 min-h-screen">
        <div class="min-h-screen flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="max-w-lg mx-auto px-4 py-4 flex items-center justify-center">
                    @if($station && $station->logo_path)
                        <img src="{{ Storage::url($station->logo_path) }}" alt="{{ $station->name }}" class="h-12 object-contain">
                    @else
                        <h1 class="text-xl font-bold text-gray-900">{{ $station->name ?? config('app.name', 'ScanIT') }}</h1>
                    @endif
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 flex flex-col">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4">
                <div class="max-w-lg mx-auto px-4 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} {{ config('app.name', 'ScanIT') }}</p>
                </div>
            </footer>
        </div>

        @livewireScripts

        <script>
            function cameraCapture() {
                return {
                    activeSlot: null,
                    showCamera: false,
                    stream: null,

                    async openCamera(slot) {
                        this.activeSlot = slot;
                        this.showCamera = true;

                        try {
                            this.stream = await navigator.mediaDevices.getUserMedia({
                                video: { facingMode: 'environment' },
                                audio: false
                            });

                            this.$nextTick(() => {
                                const video = this.$refs.video;
                                if (video) {
                                    video.srcObject = this.stream;
                                }
                            });
                        } catch (err) {
                            console.error('Camera access denied:', err);
                            alert('{{ __("scanit.public.camera_access_denied") }}');
                            this.closeCamera();
                        }
                    },

                    capturePhoto() {
                        const video = this.$refs.video;
                        const canvas = this.$refs.canvas;

                        if (video && canvas) {
                            canvas.width = video.videoWidth;
                            canvas.height = video.videoHeight;

                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(video, 0, 0);

                            const imageData = canvas.toDataURL('image/jpeg', 0.8);

                            Livewire.dispatch('imageUploaded', { slot: this.activeSlot, imageData: imageData });

                            this.closeCamera();
                        }
                    },

                    closeCamera() {
                        if (this.stream) {
                            this.stream.getTracks().forEach(track => track.stop());
                            this.stream = null;
                        }
                        this.showCamera = false;
                        this.activeSlot = null;
                    }
                }
            }
        </script>
    </body>
</html>
