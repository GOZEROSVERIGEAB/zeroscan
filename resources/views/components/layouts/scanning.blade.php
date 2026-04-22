<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Skanna och registrera dina saker för återbruk">
    <title>{{ $title ?? 'Skanna' }} | {{ $branding['service_name'] ?? 'Scanit' }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            --pz-green: #97d700;
            --pz-green-dark: #7ab800;
            --pz-green-light: #b8e550;
            --pz-teal: #005151;
            --pz-teal-light: #006666;
            --pz-teal-dark: #003d3d;
            --pz-dark: #1a2634;
        }

        * {
            font-family: 'Inter', system-ui, sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            overscroll-behavior: none;
        }

        .text-pz-teal { color: var(--pz-teal); }
        .text-pz-green { color: var(--pz-green); }
        .bg-pz-green { background-color: var(--pz-green); }
        .bg-pz-teal { background-color: var(--pz-teal); }
        .bg-pz-dark { background-color: var(--pz-dark); }
        .border-pz-green { border-color: var(--pz-green); }
        .border-pz-teal { border-color: var(--pz-teal); }

        .btn-primary {
            background: linear-gradient(135deg, var(--pz-green) 0%, var(--pz-green-dark) 100%);
            color: var(--pz-teal);
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(151, 215, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(151, 215, 0, 0.4);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: white;
            color: var(--pz-teal);
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            border: 2px solid var(--pz-teal);
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background: var(--pz-teal);
            color: white;
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0, 81, 81, 0.08);
            border: 1px solid rgba(0, 81, 81, 0.05);
        }

        .scanning-gradient {
            background: linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);
        }

        .pulse-green {
            animation: pulseGreen 2s ease-in-out infinite;
        }

        @keyframes pulseGreen {
            0%, 100% { box-shadow: 0 0 0 0 rgba(151, 215, 0, 0.4); }
            50% { box-shadow: 0 0 0 20px rgba(151, 215, 0, 0); }
        }

        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .slide-up {
            animation: slideUp 0.4s ease-out;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Safe area for notch devices */
        @supports (padding: env(safe-area-inset-top)) {
            .safe-top { padding-top: env(safe-area-inset-top); }
            .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
        }

        /* Loading spinner */
        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid rgba(0, 81, 81, 0.1);
            border-top-color: var(--pz-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Progress bar */
        .progress-bar {
            height: 4px;
            background: rgba(0, 81, 81, 0.1);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, var(--pz-green) 0%, var(--pz-green-dark) 100%);
            transition: width 0.3s ease;
        }

        /* Focus styles for accessibility */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(151, 215, 0, 0.5);
        }

        /* Input styles */
        input[type="text"],
        input[type="email"] {
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            padding: 1rem;
            font-size: 1rem;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input[type="text"]:focus,
        input[type="email"]:focus {
            border-color: var(--pz-green);
            box-shadow: 0 0 0 3px rgba(151, 215, 0, 0.2);
            outline: none;
        }
    </style>

    @stack('styles')
</head>
<body class="scanning-gradient min-h-screen antialiased safe-top safe-bottom">

    @php
        $branding = $branding ?? (isset($station) ? $station->getEffectiveBranding() : ['has_custom' => false, 'logo_url' => null, 'service_name' => null]);
    @endphp

    <!-- Minimal Header with Branding -->
    <header class="py-4 px-4 sm:py-6">
        <div class="max-w-lg mx-auto flex justify-center">
            <div class="flex items-center gap-3">
                @if($branding['has_custom'] && $branding['logo_url'])
                    <img
                        src="{{ $branding['logo_url'] }}"
                        alt="{{ $branding['service_name'] ?? 'Logo' }}"
                        class="h-10 sm:h-12 max-w-[200px] sm:max-w-[240px] object-contain"
                    >
                @elseif($branding['has_custom'] && $branding['service_name'])
                    <span class="text-xl sm:text-2xl font-semibold text-pz-teal">{{ $branding['service_name'] }}</span>
                @else
                    <img src="/images/prezero-logo.svg" alt="PreZero" class="h-8 sm:h-10">
                    <span class="text-xl sm:text-2xl font-semibold text-pz-teal">
                        Scan<span class="font-normal text-base sm:text-lg">it</span>
                    </span>
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 px-4 pb-8">
        <div class="max-w-lg mx-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- Powered by footer (subtle) -->
    <footer class="py-4 px-4 text-center">
        <p class="text-xs text-gray-400">
            @if(!($branding['has_custom'] ?? false))
                En tjänst från PreZero Sverige
            @else
                Powered by <span class="font-medium">PreZero Sverige</span>
            @endif
        </p>
    </footer>

    @stack('modals')

    @livewireScripts

    @stack('scripts')
</body>
</html>
