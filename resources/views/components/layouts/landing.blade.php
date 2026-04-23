<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $description ?? 'PreZero Scanit - Mät och rapportera miljövärdet av återbruk' }}">
    <title>{{ $title ?? 'PreZero Scanit' }} | PreZero Scanit</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        :root {
            /* PreZero Colors */
            --pz-green: #97d700;
            --pz-green-hover: #85c100;
            --pz-teal: #005151;
            --pz-teal-deep: #003d3d;
            --pz-dark: #1a2634;

            /* UI Tokens */
            --bg: #f5f3ee;
            --ink: #1a2634;
            --muted: #6b7280;
            --line: #e5e2db;
            --line-strong: #d1cdc4;
        }

        * {
            font-family: 'Inter', system-ui, sans-serif;
        }

        /* Color utilities */
        .text-green { color: var(--pz-green); }
        .text-green-ink { color: #5a8000; }
        .text-teal { color: var(--pz-teal); }
        .text-teal-deep { color: var(--pz-teal-deep); }
        .text-ink { color: var(--ink); }
        .text-muted { color: var(--muted); }
        .text-bg { color: var(--bg); }

        .bg-green { background-color: var(--pz-green); }
        .bg-green-hover { background-color: var(--pz-green-hover); }
        .bg-teal { background-color: var(--pz-teal); }
        .bg-teal-deep { background-color: var(--pz-teal-deep); }
        .bg-bg { background-color: var(--bg); }

        .border-line { border-color: var(--line); }
        .border-line-strong { border-color: var(--line-strong); }

        /* Font display */
        .font-display {
            font-family: 'Inter', system-ui, sans-serif;
            letter-spacing: -0.02em;
        }

        /* Animations */
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .animate-pulse-dot {
            animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Reveal animation */
        [data-reveal] {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        [data-reveal].revealed {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="antialiased" style="background-color: var(--bg); color: var(--ink);">
    {{ $slot }}

    @livewireScripts

    <script>
        // Simple reveal animation
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('[data-reveal]');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('revealed');
                        }, delay * 100);
                    }
                });
            }, { threshold: 0.1 });
            reveals.forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
