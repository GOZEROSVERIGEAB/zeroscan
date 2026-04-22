<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'Scanit - Mät miljövärdet av återbruk' }}">
    <title>{{ $title ?? 'Scanit' }} | Scanit</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --pz-green: #97d700;
            --pz-green-dark: #7ab800;
            --pz-teal: #005151;
            --pz-teal-light: #006666;
            --pz-dark: #1a2634;
        }

        * {
            font-family: 'Inter', system-ui, sans-serif;
        }

        .text-pz-teal { color: var(--pz-teal); }
        .text-pz-green { color: var(--pz-green); }
        .bg-pz-green { background-color: var(--pz-green); }
        .bg-pz-teal { background-color: var(--pz-teal); }
        .bg-pz-dark { background-color: var(--pz-dark); }

        .prose h2 { color: #005151; margin-top: 2rem; margin-bottom: 1rem; font-size: 1.25rem; font-weight: 600; }
        .prose h3 { color: #005151; margin-top: 1.5rem; margin-bottom: 0.75rem; font-size: 1.125rem; font-weight: 500; }
        .prose p, .prose li { color: #4b5563; line-height: 1.75; }
        .prose ul { list-style-type: disc; padding-left: 1.5rem; margin: 1rem 0; }
        .prose li { margin: 0.5rem 0; }
        .prose table { width: 100%; margin: 1rem 0; border-collapse: collapse; }
        .prose th, .prose td { padding: 0.75rem; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 0.875rem; }
        .prose th { background: #f9fafb; font-weight: 600; color: #005151; }
        .prose code { background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 4px; font-size: 0.875rem; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    @php
        $branding = isset($station) ? $station->getEffectiveBranding() : ['has_custom' => false, 'logo_url' => null, 'service_name' => null];
    @endphp

    <!-- Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-4">
                    @if($branding['has_custom'] && $branding['logo_url'])
                        <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['service_name'] ?? '' }}" class="h-10 max-w-[180px] object-contain">
                        @if($branding['service_name'])
                            <span class="text-2xl font-semibold text-pz-teal">{{ $branding['service_name'] }}</span>
                        @endif
                    @else
                        <img src="/images/prezero-logo.svg" alt="PreZero" class="h-10">
                        <span class="text-2xl font-semibold text-pz-teal">Scan<span class="font-normal text-lg">it</span></span>
                    @endif
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="/#om" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Om Scanit</a>
                    <a href="/#funktioner" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Funktioner</a>
                    <a href="/#hur-det-fungerar" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Hur det fungerar</a>
                    <a href="/#kontakt" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Kontakt</a>
                </nav>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-[#97d700] hover:bg-[#85c100] text-[#005151] font-semibold px-5 py-2.5 rounded transition-colors">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-pz-teal font-medium hover:underline hidden sm:block">Logga in</a>
                        <a href="/#kontakt" class="bg-[#97d700] hover:bg-[#85c100] text-[#005151] font-semibold px-5 py-2.5 rounded transition-colors">Boka demo</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="py-16">
        <div class="max-w-4xl mx-auto px-6 lg:px-8">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-pz-dark py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-4 mb-6">
                        @if($branding['has_custom'] && $branding['logo_url'])
                            <img src="{{ $branding['logo_url'] }}" alt="{{ $branding['service_name'] ?? '' }}" class="h-10 max-w-[180px] object-contain brightness-0 invert">
                            @if($branding['service_name'])
                                <span class="text-2xl font-semibold text-white">{{ $branding['service_name'] }}</span>
                            @endif
                        @else
                            <img src="/images/prezero-logo-white.svg" alt="PreZero" class="h-10">
                            <span class="text-2xl font-semibold text-white">Scan<span class="font-normal text-lg">it</span></span>
                        @endif
                    </div>
                    <p class="text-gray-400 max-w-sm">
                        @if($branding['has_custom'] && $branding['service_name'])
                            {{ $branding['service_name'] }} - Mät miljövärdet av återanvändning.
                        @else
                            Scanit är en tjänst från PreZero Sverige för att mäta och kommunicera miljövärdet av återanvändning.
                        @endif
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Tjänster</h4>
                    <ul class="space-y-3">
                        <li><a href="/#om" class="text-gray-400 hover:text-white transition-colors">Om Scanit</a></li>
                        <li><a href="/#funktioner" class="text-gray-400 hover:text-white transition-colors">Funktioner</a></li>
                        <li><a href="/#hur-det-fungerar" class="text-gray-400 hover:text-white transition-colors">Hur det fungerar</a></li>
                        <li><a href="/#kontakt" class="text-gray-400 hover:text-white transition-colors">Kontakt</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Juridiskt</h4>
                    <ul class="space-y-3">
                        <li><a href="{{ route('legal.privacy') }}" class="text-gray-400 hover:text-white transition-colors">Integritetspolicy</a></li>
                        <li><a href="{{ route('legal.terms') }}" class="text-gray-400 hover:text-white transition-colors">Användarvillkor</a></li>
                        <li><a href="{{ route('legal.cookies') }}" class="text-gray-400 hover:text-white transition-colors">Cookie-policy</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-4">
                    <a href="https://www.prezero.se" target="_blank" class="text-gray-400 hover:text-white transition-colors text-sm">
                        PreZero Sverige
                    </a>
                </div>
                <p class="text-gray-500 text-sm">
                    &copy; {{ date('Y') }} GoZero Sverige AB. Alla rättigheter förbehållna.
                </p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
