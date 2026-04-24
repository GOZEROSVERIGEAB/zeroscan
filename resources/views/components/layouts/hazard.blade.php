<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Scan hazardous product labels for safety information">
    <title>{{ __('hazard.title') }} | PreZero</title>

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
            --hazard-red: #dc2626;
            --hazard-orange: #ea580c;
            --hazard-yellow: #ca8a04;
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

        .hazard-gradient {
            background: linear-gradient(180deg, #fef3c7 0%, #ffffff 100%);
        }

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

        .btn-hazard {
            background: linear-gradient(135deg, var(--hazard-orange) 0%, var(--hazard-red) 100%);
            color: white;
            font-weight: 600;
            padding: 1rem 2rem;
            border-radius: 0.75rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
        }

        .btn-hazard:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        }

        .card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(0, 81, 81, 0.08);
            border: 1px solid rgba(0, 81, 81, 0.05);
        }

        .card-hazard {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 4px 24px rgba(220, 38, 38, 0.1);
            border: 2px solid rgba(220, 38, 38, 0.2);
        }

        .demo-badge {
            background: linear-gradient(135deg, var(--hazard-orange) 0%, var(--hazard-red) 100%);
            color: white;
            font-weight: 700;
            font-size: 0.65rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            letter-spacing: 0.05em;
        }

        .pulse-hazard {
            animation: pulseHazard 2s ease-in-out infinite;
        }

        @keyframes pulseHazard {
            0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.4); }
            50% { box-shadow: 0 0 0 15px rgba(220, 38, 38, 0); }
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
            border: 4px solid rgba(220, 38, 38, 0.1);
            border-top-color: var(--hazard-orange);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* GHS Pictogram styles */
        .ghs-pictogram {
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ghs-pictogram img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        /* Collapsible section styles */
        .collapsible-header {
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .collapsible-header:hover {
            background-color: rgba(0, 81, 81, 0.05);
        }

        .collapsible-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .collapsible-content.expanded {
            max-height: 2000px;
        }

        /* Language switcher */
        .lang-btn {
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .lang-btn.active {
            background: var(--pz-teal);
            color: white;
        }

        .lang-btn:not(.active) {
            background: rgba(0, 81, 81, 0.1);
            color: var(--pz-teal);
        }

        .lang-btn:not(.active):hover {
            background: rgba(0, 81, 81, 0.2);
        }

        /* Signal word badges */
        .signal-danger {
            background: var(--hazard-red);
            color: white;
            font-weight: 700;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        .signal-warning {
            background: var(--hazard-orange);
            color: white;
            font-weight: 700;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }

        /* Focus styles for accessibility */
        .focus-ring:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.5);
        }
    </style>

    @stack('styles')
</head>
<body class="hazard-gradient min-h-screen antialiased safe-top safe-bottom">

    <!-- Header with Branding and Language Switcher -->
    <header class="py-4 px-4 sm:py-6">
        <div class="max-w-2xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <img src="/images/prezero-logo.svg" alt="PreZero" class="h-8 sm:h-10">
                <div class="flex flex-col">
                    <span class="text-lg sm:text-xl font-semibold text-pz-teal">
                        Hazard<span class="font-normal text-sm sm:text-base">Scanner</span>
                    </span>
                </div>
                <span class="demo-badge ml-2">{{ __('hazard.demo_badge') }}</span>
            </div>

        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 px-4 pb-8">
        <div class="max-w-2xl mx-auto">
            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-4 px-4 text-center">
        <p class="text-xs text-gray-500 max-w-md mx-auto">
            {{ __('hazard.ai_disclaimer') }}
        </p>
        <p class="text-xs text-gray-400 mt-2">
            {{ __('hazard.powered_by') }} <span class="font-medium">GoZero</span> a PreZero company
        </p>
    </footer>

    @stack('modals')

    @livewireScripts

    <!-- html5-qrcode library for barcode scanning -->
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    @stack('scripts')
</body>
</html>
