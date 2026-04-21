<!DOCTYPE html>
<html lang="sv" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ScanIT - Låt kunder registrera föremål de hämtar och köper. Samla in statistik om återanvändning och visa er miljöpåverkan.">
    <title>ScanIT | Miljöskanning för Återvinningscentraler & Kommuner</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --pz-green: #00D26A;
            --pz-green-dark: #00A854;
            --pz-dark: #0A0A0B;
        }

        * { font-family: 'Outfit', system-ui, sans-serif; }

        .hero-gradient {
            background: linear-gradient(135deg, #0A0A0B 0%, #0d1f12 50%, #0A0A0B 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-gradient::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(ellipse at center, rgba(0, 210, 106, 0.15) 0%, transparent 50%);
            animation: pulse-glow 8s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { transform: translate(0, 0) scale(1); opacity: 0.5; }
            50% { transform: translate(-10%, -10%) scale(1.2); opacity: 0.8; }
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            animation: float-orb 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(0, 210, 106, 0.3) 0%, transparent 70%);
            top: -200px; right: -200px;
        }

        .orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(0, 168, 84, 0.2) 0%, transparent 70%);
            bottom: -100px; left: -100px;
            animation-delay: -5s;
        }

        @keyframes float-orb {
            0%, 100% { transform: translate(0, 0); }
            50% { transform: translate(-20px, 20px); }
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(255,255,255,0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.02) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        .glow-text {
            text-shadow: 0 0 80px rgba(0, 210, 106, 0.5);
        }

        .btn-glow {
            box-shadow: 0 0 40px rgba(0, 210, 106, 0.4), inset 0 1px 0 rgba(255,255,255,0.1);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 60px rgba(0, 210, 106, 0.6), inset 0 1px 0 rgba(255,255,255,0.2);
            transform: translateY(-2px);
        }

        .reveal {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .feature-card {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 210, 106, 0.3);
            box-shadow: 0 20px 40px rgba(0, 210, 106, 0.1);
        }

        .stat-gradient {
            background: linear-gradient(180deg, #fff 0%, rgba(255,255,255,0.6) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-mockup {
            transform: perspective(2000px) rotateX(10deg) rotateY(-5deg);
            transition: transform 0.5s ease;
        }
        .dashboard-mockup:hover {
            transform: perspective(2000px) rotateX(5deg) rotateY(-2deg);
        }
    </style>
</head>
<body class="bg-[#0A0A0B] text-white antialiased">

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 border-b border-white/5" style="background: rgba(10,10,11,0.8); backdrop-filter: blur(20px);">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#00D26A] to-[#00A854] flex items-center justify-center shadow-lg shadow-green-500/20 group-hover:shadow-green-500/40 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Scan<span class="text-[#00D26A]">IT</span></span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#platform" class="text-white/60 hover:text-white transition-colors text-sm font-medium">Plattformen</a>
                    <a href="#features" class="text-white/60 hover:text-white transition-colors text-sm font-medium">Funktioner</a>
                    <a href="#pricing" class="text-white/60 hover:text-white transition-colors text-sm font-medium">Priser</a>
                    <a href="#contact" class="text-white/60 hover:text-white transition-colors text-sm font-medium">Kontakt</a>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-[#00D26A] hover:bg-[#00A854] text-black font-semibold px-5 py-2.5 rounded-full btn-glow text-sm">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white/60 hover:text-white transition-colors text-sm font-medium hidden sm:block">Logga in</a>
                        <a href="{{ route('login') }}" class="bg-[#00D26A] hover:bg-[#00A854] text-black font-semibold px-5 py-2.5 rounded-full btn-glow text-sm">
                            Boka demo
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center pt-20 relative">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="absolute inset-0 grid-pattern"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-sm text-white/70 mb-8">
                        <span class="w-2 h-2 bg-[#00D26A] rounded-full animate-pulse"></span>
                        Från PreZero Sverige
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-[1.1] tracking-tight mb-6">
                        <span class="text-white">Engagera era besökare.</span><br/>
                        <span class="text-[#00D26A] glow-text">Mät miljöpåverkan.</span>
                    </h1>

                    <p class="text-xl text-white/60 leading-relaxed mb-8 max-w-lg">
                        ScanIT låter era kunder skanna och fotografera föremål de hämtar, köper eller tar med sig – ni samlar in värdefull statistik och de kan få en personlig miljörapport.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-12">
                        <a href="#contact" class="group inline-flex items-center justify-center gap-3 bg-[#00D26A] text-black font-semibold px-8 py-4 rounded-full btn-glow text-lg">
                            <span>Boka en demo</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#platform" class="inline-flex items-center justify-center gap-2 glass-card text-white font-medium px-8 py-4 rounded-full hover:bg-white/10 transition-colors text-lg">
                            Se hur det fungerar
                        </a>
                    </div>

                    <!-- Target audience badges -->
                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-2 rounded-full glass-card text-sm text-white/60">Återvinningscentraler</span>
                        <span class="px-4 py-2 rounded-full glass-card text-sm text-white/60">Kommuner</span>
                        <span class="px-4 py-2 rounded-full glass-card text-sm text-white/60">Avfallsbolag</span>
                        <span class="px-4 py-2 rounded-full glass-card text-sm text-white/60">Secondhand</span>
                    </div>
                </div>

                <!-- Dashboard Mockup -->
                <div class="relative flex justify-center lg:justify-end">
                    <div class="dashboard-mockup relative w-full max-w-xl">
                        <!-- Browser frame -->
                        <div class="bg-[#1A1A1E] rounded-2xl shadow-2xl shadow-black/50 overflow-hidden border border-white/10">
                            <!-- Browser toolbar -->
                            <div class="flex items-center gap-2 px-4 py-3 bg-[#0A0A0B] border-b border-white/5">
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                                    <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                                </div>
                                <div class="flex-1 mx-4">
                                    <div class="bg-white/5 rounded-lg px-4 py-1.5 text-sm text-white/40 text-center">
                                        scanit.prezero.se/dashboard
                                    </div>
                                </div>
                            </div>

                            <!-- Dashboard content -->
                            <div class="p-6 bg-gradient-to-b from-[#0d1f12]/50 to-[#0A0A0B]">
                                <!-- Header -->
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-white font-semibold text-lg">Översikt</h3>
                                        <p class="text-white/40 text-sm">Återvinningscentral Nord</p>
                                    </div>
                                    <div class="flex gap-2">
                                        <div class="px-3 py-1.5 rounded-lg bg-white/5 text-white/60 text-sm">Denna vecka</div>
                                    </div>
                                </div>

                                <!-- Stats grid -->
                                <div class="grid grid-cols-3 gap-4 mb-6">
                                    <div class="glass-card rounded-xl p-4">
                                        <p class="text-white/40 text-xs mb-1">Hämtade</p>
                                        <p class="text-2xl font-bold text-white">1,247</p>
                                        <p class="text-[#00D26A] text-xs mt-1">+23% ↑</p>
                                    </div>
                                    <div class="glass-card rounded-xl p-4">
                                        <p class="text-white/40 text-xs mb-1">CO₂ sparat</p>
                                        <p class="text-2xl font-bold text-white">892<span class="text-sm">kg</span></p>
                                        <p class="text-[#00D26A] text-xs mt-1">+18% ↑</p>
                                    </div>
                                    <div class="glass-card rounded-xl p-4">
                                        <p class="text-white/40 text-xs mb-1">Totalt värde</p>
                                        <p class="text-2xl font-bold text-white">45k<span class="text-sm">kr</span></p>
                                        <p class="text-[#00D26A] text-xs mt-1">+31% ↑</p>
                                    </div>
                                </div>

                                <!-- Chart placeholder -->
                                <div class="glass-card rounded-xl p-4 mb-4">
                                    <p class="text-white/40 text-xs mb-3">Hämtade föremål per dag</p>
                                    <div class="flex items-end gap-2 h-24">
                                        <div class="flex-1 bg-[#00D26A]/20 rounded-t" style="height: 40%"></div>
                                        <div class="flex-1 bg-[#00D26A]/20 rounded-t" style="height: 60%"></div>
                                        <div class="flex-1 bg-[#00D26A]/20 rounded-t" style="height: 45%"></div>
                                        <div class="flex-1 bg-[#00D26A]/20 rounded-t" style="height: 80%"></div>
                                        <div class="flex-1 bg-[#00D26A]/20 rounded-t" style="height: 65%"></div>
                                        <div class="flex-1 bg-[#00D26A]/40 rounded-t" style="height: 90%"></div>
                                        <div class="flex-1 bg-[#00D26A] rounded-t" style="height: 100%"></div>
                                    </div>
                                </div>

                                <!-- Stations list -->
                                <div class="glass-card rounded-xl p-4">
                                    <p class="text-white/40 text-xs mb-3">Stationer</p>
                                    <div class="space-y-2">
                                        <div class="flex items-center justify-between py-2 border-b border-white/5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-[#00D26A]/20 flex items-center justify-center">
                                                    <div class="w-2 h-2 rounded-full bg-[#00D26A]"></div>
                                                </div>
                                                <span class="text-white text-sm">Secondhand</span>
                                            </div>
                                            <span class="text-white/40 text-sm">423 föremål</span>
                                        </div>
                                        <div class="flex items-center justify-between py-2 border-b border-white/5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-[#00D26A]/20 flex items-center justify-center">
                                                    <div class="w-2 h-2 rounded-full bg-[#00D26A]"></div>
                                                </div>
                                                <span class="text-white text-sm">Återbruk A</span>
                                            </div>
                                            <span class="text-white/40 text-sm">389 föremål</span>
                                        </div>
                                        <div class="flex items-center justify-between py-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                                    <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                                                </div>
                                                <span class="text-white text-sm">Återbruk B</span>
                                            </div>
                                            <span class="text-white/40 text-sm">435 föremål</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating QR code badge -->
                        <div class="absolute -left-8 bottom-20 glass-card rounded-2xl p-4 shadow-2xl hidden sm:block">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center">
                                    <svg class="w-8 h-8 text-[#0A0A0B]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-white/50 text-xs">QR-kod</p>
                                    <p class="text-white font-semibold">Genererad</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Props -->
    <section class="py-24 bg-[#0A0A0B] border-y border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center reveal">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-[#00D26A]/20 to-[#00D26A]/5 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Engagera kunderna</h3>
                    <p class="text-white/50">Låt kunder registrera föremål de hämtar och förstå miljövärdet av att välja återanvändning.</p>
                </div>
                <div class="text-center reveal">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Samla in data</h3>
                    <p class="text-white/50">Få insikt om vilka föremål som hämtas och köps, deras miljöpåverkan och totalt CO₂ sparat genom återanvändning.</p>
                </div>
                <div class="text-center reveal">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-500/5 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Visa er påverkan</h3>
                    <p class="text-white/50">Använd statistiken i era hållbarhetsrapporter och kommunikation med invånare och intressenter.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Platform Section -->
    <section id="platform" class="py-32 bg-[#0A0A0B] relative">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="reveal">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-sm text-[#00D26A] mb-6">
                        Så fungerar plattformen
                    </div>
                    <h2 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6">
                        Tre steg för att<br/><span class="text-[#00D26A]">komma igång</span>
                    </h2>
                    <p class="text-xl text-white/50 mb-10">
                        Sätt upp era anläggningar och stationer i admin-panelen. Placera ut QR-koder. Era kunder skannar och fotograferar föremål de tar med sig – ni får statistiken i realtid.
                    </p>

                    <div class="space-y-8">
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#00D26A] flex items-center justify-center text-black font-bold text-lg">1</div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">Skapa era anläggningar</h3>
                                <p class="text-white/50">Lägg till era återvinningscentraler, secondhand-butiker, återbruk eller andra platser där kunder hämtar föremål.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#00D26A] flex items-center justify-center text-black font-bold text-lg">2</div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">Sätt upp stationer</h3>
                                <p class="text-white/50">Skapa stationer och placera QR-koder där kunder kan skanna och fotografera föremålen de tar med sig.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-[#00D26A] flex items-center justify-center text-black font-bold text-lg">3</div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">Ni får all statistik</h3>
                                <p class="text-white/50">Ni ser alla skanningar i realtid. Kunden kan valfritt få sin egen miljörapport – ni får alltid all data.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Admin features illustration -->
                <div class="reveal">
                    <div class="glass-card rounded-3xl p-8 space-y-6">
                        <!-- Feature 1 -->
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-[#00D26A]/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Hantera anläggningar</h4>
                                <p class="text-white/40 text-sm">Lägg till secondhand-butiker, återbruk eller återvinningscentraler. Varje med egen statistik.</p>
                            </div>
                        </div>

                        <!-- Feature 2 -->
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-blue-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">QR-koder</h4>
                                <p class="text-white/40 text-sm">Kunder skannar QR-koden och fotograferar föremål de tar med sig. Ni får all data automatiskt.</p>
                            </div>
                        </div>

                        <!-- Feature 3 -->
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-purple-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Anpassa utseende</h4>
                                <p class="text-white/40 text-sm">Ladda upp er logotyp och anpassa texter så att skanningssidan matchar ert varumärke.</p>
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-white/5 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-white font-semibold mb-1">Exportera rapporter</h4>
                                <p class="text-white/40 text-sm">Ladda ner statistik som PDF eller Excel för era hållbarhetsrapporter och presentationer.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0A0A0B] via-[#0d1f12] to-[#0A0A0B]"></div>
        <div class="absolute inset-0 grid-pattern opacity-50"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-20 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-sm text-[#00D26A] mb-6">
                    Allt ni behöver
                </div>
                <h2 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6">
                    En komplett plattform för<br/><span class="text-[#00D26A]">miljöengagemang</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-[#00D26A]/20 to-[#00D26A]/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">AI-bildanalys</h3>
                    <p class="text-white/50">Automatisk identifiering av hämtade föremål, kategori, skick och beräkning av miljöbesparing genom återanvändning.</p>
                </div>

                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-blue-500/20 to-blue-500/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Dashboard & statistik</h3>
                    <p class="text-white/50">Realtidsöversikt över alla skanningar, trender och miljöpåverkan. Filtrera per anläggning, station eller tidsperiod.</p>
                </div>

                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500/20 to-purple-500/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Valfri miljörapport</h3>
                    <p class="text-white/50">Kunder kan valfritt få en personlig miljörapport via e-post med CO₂-besparing och föremålens värde.</p>
                </div>

                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500/20 to-orange-500/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">Multi-användare</h3>
                    <p class="text-white/50">Bjud in kollegor med olika behörigheter. Admin, personal eller enbart läsrättigheter.</p>
                </div>

                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500/20 to-pink-500/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">White-label</h3>
                    <p class="text-white/50">Anpassa skanningssidan med er logotyp, färger och texter. Era besökare ser ert varumärke.</p>
                </div>

                <div class="feature-card glass-card rounded-3xl p-8 reveal">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500/20 to-cyan-500/5 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-white mb-3">GDPR-säkert</h3>
                    <p class="text-white/50">All data lagras i Sverige. Besökare godkänner villkor innan e-post sparas. Data raderas automatiskt.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-32 bg-[#0A0A0B]">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16 reveal">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-sm text-[#00D26A] mb-6">
                    Enkel prissättning
                </div>
                <h2 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6">
                    Välj den plan som<br/><span class="text-[#00D26A]">passar er</span>
                </h2>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Starter -->
                <div class="glass-card rounded-3xl p-8 reveal">
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Starter</h3>
                        <p class="text-white/50">För mindre återvinningscentraler och kommuner</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-bold text-white">Kontakta oss</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Upp till 3 anläggningar
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            10 stationer per anläggning
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Dashboard & statistik
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Valfria miljörapporter till kunder
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            E-post support
                        </li>
                    </ul>
                    <a href="#contact" class="block w-full text-center glass-card text-white font-semibold px-8 py-4 rounded-full hover:bg-white/10 transition-colors">
                        Kontakta oss
                    </a>
                </div>

                <!-- Enterprise -->
                <div class="relative glass-card rounded-3xl p-8 reveal border-[#00D26A]/30">
                    <div class="absolute -top-4 left-1/2 -translate-x-1/2">
                        <span class="bg-[#00D26A] text-black text-sm font-semibold px-4 py-1 rounded-full">Populärast</span>
                    </div>
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold text-white mb-2">Enterprise</h3>
                        <p class="text-white/50">För större organisationer och avfallsbolag</p>
                    </div>
                    <div class="mb-8">
                        <span class="text-5xl font-bold text-white">Offert</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Obegränsat antal anläggningar
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Obegränsat antal stationer
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            White-label (egen logotyp & färger)
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            API-integration
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Dedikerad support
                        </li>
                        <li class="flex items-center gap-3 text-white/70">
                            <svg class="w-5 h-5 text-[#00D26A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Anpassade rapporter
                        </li>
                    </ul>
                    <a href="#contact" class="block w-full text-center bg-[#00D26A] text-black font-semibold px-8 py-4 rounded-full btn-glow">
                        Begär offert
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="contact" class="py-32 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-[#0A0A0B] via-[#0d1f12] to-[#0A0A0B]"></div>
        <div class="absolute inset-0 grid-pattern opacity-50"></div>

        <div class="max-w-4xl mx-auto px-6 lg:px-8 text-center relative z-10 reveal">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-card text-sm text-[#00D26A] mb-6">
                Kom igång idag
            </div>
            <h2 class="text-4xl sm:text-5xl font-bold tracking-tight mb-6">
                Redo att mäta<br/><span class="text-[#00D26A]">er miljöpåverkan?</span>
            </h2>
            <p class="text-xl text-white/50 mb-10 max-w-2xl mx-auto">
                Boka en demo så visar vi hur ScanIT hjälper er samla in statistik om allt som hämtas och köps på era anläggningar.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="mailto:scanit@prezero.se" class="group inline-flex items-center justify-center gap-3 bg-[#00D26A] text-black font-semibold px-8 py-4 rounded-full btn-glow text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>scanit@prezero.se</span>
                </a>
                <a href="tel:+46771123456" class="inline-flex items-center justify-center gap-2 glass-card text-white font-medium px-8 py-4 rounded-full hover:bg-white/10 transition-colors text-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    0771-12 34 56
                </a>
            </div>

            <!-- Trust badges -->
            <div class="flex flex-wrap justify-center gap-8 pt-8 border-t border-white/10">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-1">GDPR</div>
                    <div class="text-white/40 text-sm">Kompatibel</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-1">Sverige</div>
                    <div class="text-white/40 text-sm">Datalagring</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-white/40 text-sm">Tillgänglighet</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 border-t border-white/5 bg-[#0A0A0B]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#00D26A] to-[#00A854] flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="text-xl font-bold">Scan<span class="text-[#00D26A]">IT</span></span>
                        <span class="text-white/40 text-sm ml-2">by PreZero</span>
                    </div>
                </div>

                <div class="flex items-center gap-8">
                    <a href="https://www.prezero.se" target="_blank" class="text-white/40 hover:text-white transition-colors text-sm">PreZero Sverige</a>
                    <a href="#" class="text-white/40 hover:text-white transition-colors text-sm">Integritetspolicy</a>
                    <a href="#" class="text-white/40 hover:text-white transition-colors text-sm">Villkor</a>
                </div>

                <p class="text-white/30 text-sm">
                    &copy; {{ date('Y') }} PreZero Sverige
                </p>
            </div>
        </div>
    </footer>

    <script>
        const reveals = document.querySelectorAll('.reveal');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

        reveals.forEach(el => observer.observe(el));
    </script>
</body>
</html>
