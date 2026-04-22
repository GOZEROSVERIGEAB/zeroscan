<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Scanit - Låt kunder registrera föremål de hämtar och köper. Samla in statistik om återanvändning och visa er miljöpåverkan.">
    <title>Scanit | Miljöregistrering för återbruk</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

        .btn-primary {
            background-color: var(--pz-green);
            color: var(--pz-teal);
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 4px;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-primary:hover {
            background-color: #85c100;
            transform: translateY(-1px);
        }

        .btn-secondary {
            border: 2px solid var(--pz-teal);
            color: var(--pz-teal);
            font-weight: 600;
            padding: 0.875rem 2rem;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        .btn-secondary:hover {
            background-color: var(--pz-teal);
            color: white;
        }

        .text-pz-teal { color: var(--pz-teal); }
        .text-pz-green { color: var(--pz-green); }
        .bg-pz-green { background-color: var(--pz-green); }
        .bg-pz-teal { background-color: var(--pz-teal); }
        .bg-pz-dark { background-color: var(--pz-dark); }

        .hero-bg {
            background: linear-gradient(135deg, rgba(0,81,81,0.03) 0%, rgba(151,215,0,0.08) 100%);
        }

        .card-shadow {
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, var(--pz-green) 0%, #85c100 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .step-number {
            width: 48px;
            height: 48px;
            background-color: var(--pz-green);
            color: var(--pz-teal);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        /* Dashboard Styles */
        .dashboard-container {
            background: linear-gradient(145deg, #f8fafc 0%, #f1f5f9 100%);
            border-radius: 20px;
            padding: 1.5rem;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(0, 81, 81, 0.05);
        }

        .dashboard-header {
            background: linear-gradient(135deg, var(--pz-teal) 0%, var(--pz-teal-light) 100%);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--pz-green) 0%, var(--pz-teal) 100%);
        }

        .chart-bar {
            border-radius: 6px 6px 2px 2px;
            transition: all 0.3s ease;
            position: relative;
        }
        .chart-bar:hover {
            filter: brightness(1.1);
            transform: scaleY(1.02);
            transform-origin: bottom;
        }

        .activity-item {
            animation: slideIn 0.5s ease forwards;
            opacity: 0;
        }
        .activity-item:nth-child(1) { animation-delay: 0.1s; }
        .activity-item:nth-child(2) { animation-delay: 0.2s; }
        .activity-item:nth-child(3) { animation-delay: 0.3s; }
        .activity-item:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .pulse-dot {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .trend-up {
            color: #10b981;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .category-bar {
            height: 8px;
            border-radius: 4px;
            background: #e2e8f0;
            overflow: hidden;
        }
        .category-progress {
            height: 100%;
            border-radius: 4px;
            transition: width 1s ease;
        }

        .co2-gauge {
            background: conic-gradient(
                var(--pz-green) 0deg,
                var(--pz-green) 252deg,
                #e2e8f0 252deg,
                #e2e8f0 360deg
            );
            border-radius: 50%;
            position: relative;
        }
        .co2-gauge::before {
            content: '';
            position: absolute;
            inset: 8px;
            background: white;
            border-radius: 50%;
        }

        .live-badge {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            font-size: 0.65rem;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }
        .live-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            background: white;
            border-radius: 50%;
            animation: pulse 1s infinite;
        }

        .station-status {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--pz-green);
            box-shadow: 0 0 0 3px rgba(151, 215, 0, 0.2);
        }
        .station-status.busy {
            background: #f59e0b;
            box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.2);
        }

        .mini-sparkline {
            display: flex;
            align-items: flex-end;
            gap: 2px;
            height: 24px;
        }
        .mini-sparkline span {
            width: 4px;
            background: var(--pz-green);
            border-radius: 2px;
            opacity: 0.6;
        }
        .mini-sparkline span:last-child {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-white text-gray-800 antialiased">

    <!-- Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-4">
                    <img src="/images/prezero-logo.svg" alt="PreZero" class="h-10">
                    <span class="text-2xl font-semibold text-pz-teal">Scan<span class="font-normal text-lg">it</span></span>
                </a>

                <nav class="hidden md:flex items-center gap-8">
                    <a href="#om" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Om Scanit</a>
                    <a href="#funktioner" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Funktioner</a>
                    <a href="#hur-det-fungerar" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Hur det fungerar</a>
                    <a href="#kontakt" class="text-gray-600 hover:text-pz-teal transition-colors font-medium">Kontakt</a>
                </nav>

                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-pz-teal font-medium hover:underline hidden sm:block">Logga in</a>
                        <a href="#kontakt" class="btn-primary">Boka demo</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-bg py-16 lg:py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-pz-teal leading-tight mb-6">
                        Mät miljövärdet av återbruk
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed mb-8 max-w-lg">
                        Scanit låter era kunder registrera föremål de hämtar eller köper. Ni samlar in värdefull statistik om återanvändning och kan visa er miljöpåverkan.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        <a href="#kontakt" class="btn-primary">
                            Boka en demo
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </a>
                        <a href="#hur-det-fungerar" class="btn-secondary">Se hur det fungerar</a>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 card-shadow">Återvinningscentraler</span>
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 card-shadow">Kommuner</span>
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 card-shadow">Secondhand</span>
                        <span class="px-4 py-2 bg-white rounded-full text-sm text-gray-600 card-shadow">Återbruk</span>
                    </div>
                </div>

                <!-- KILLER DASHBOARD -->
                <div class="dashboard-container">
                    <!-- Dashboard Header -->
                    <div class="dashboard-header flex items-center justify-between">
                        <div>
                            <h3 class="text-white font-semibold text-lg">Återbruk Centrum Nord</h3>
                            <p class="text-white/70 text-sm">Samtliga stationer • Denna månad</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="live-badge">Live</span>
                            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500 text-xs font-medium uppercase tracking-wide">Hämtade</span>
                                <div class="mini-sparkline">
                                    <span style="height: 40%"></span>
                                    <span style="height: 60%"></span>
                                    <span style="height: 45%"></span>
                                    <span style="height: 80%"></span>
                                    <span style="height: 70%"></span>
                                    <span style="height: 90%"></span>
                                    <span style="height: 100%"></span>
                                </div>
                            </div>
                            <p class="text-2xl font-bold text-pz-teal">3,847</p>
                            <span class="trend-up">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                +18.2%
                            </span>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500 text-xs font-medium uppercase tracking-wide">CO₂ sparat</span>
                                <div class="co2-gauge w-7 h-7"></div>
                            </div>
                            <p class="text-2xl font-bold text-pz-teal">2.4<span class="text-base font-medium text-gray-400 ml-1">ton</span></p>
                            <span class="trend-up">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                +23.5%
                            </span>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500 text-xs font-medium uppercase tracking-wide">Värde</span>
                                <svg class="w-5 h-5 text-pz-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-pz-teal">847<span class="text-base font-medium text-gray-400 ml-1">tkr</span></p>
                            <span class="trend-up">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                +31.8%
                            </span>
                        </div>

                        <div class="stat-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-500 text-xs font-medium uppercase tracking-wide">Besökare</span>
                                <svg class="w-5 h-5 text-pz-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <p class="text-2xl font-bold text-pz-teal">1,293</p>
                            <span class="trend-up">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                +12.4%
                            </span>
                        </div>
                    </div>

                    <!-- Chart & Categories -->
                    <div class="grid grid-cols-5 gap-3 mb-4">
                        <!-- Chart -->
                        <div class="col-span-3 bg-white rounded-xl p-4 shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <p class="text-gray-800 font-semibold text-sm">Hämtade föremål</p>
                                    <p class="text-gray-400 text-xs">Senaste 7 dagarna</p>
                                </div>
                                <div class="flex gap-1">
                                    <span class="w-6 h-6 rounded bg-gray-100 flex items-center justify-center text-gray-400 text-xs">V</span>
                                    <span class="w-6 h-6 rounded bg-pz-teal text-white flex items-center justify-center text-xs">D</span>
                                </div>
                            </div>
                            <div class="flex items-end gap-2 h-28">
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green/60 to-pz-green/30" style="height: 45%"></div>
                                    <span class="text-[10px] text-gray-400">Mån</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green/60 to-pz-green/30" style="height: 62%"></div>
                                    <span class="text-[10px] text-gray-400">Tis</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green/60 to-pz-green/30" style="height: 38%"></div>
                                    <span class="text-[10px] text-gray-400">Ons</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green/70 to-pz-green/40" style="height: 75%"></div>
                                    <span class="text-[10px] text-gray-400">Tor</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green/80 to-pz-green/50" style="height: 88%"></div>
                                    <span class="text-[10px] text-gray-400">Fre</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-green to-pz-green/70" style="height: 100%"></div>
                                    <span class="text-[10px] text-gray-400">Lör</span>
                                </div>
                                <div class="flex-1 flex flex-col items-center gap-1">
                                    <div class="chart-bar w-full bg-gradient-to-t from-pz-teal to-pz-teal/70" style="height: 72%"></div>
                                    <span class="text-[10px] text-gray-400 font-semibold">Idag</span>
                                </div>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="col-span-2 bg-white rounded-xl p-4 shadow-sm">
                            <p class="text-gray-800 font-semibold text-sm mb-3">Kategorier</p>
                            <div class="space-y-3">
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 flex items-center gap-1.5">
                                            <span class="text-sm">🛋️</span> Möbler
                                        </span>
                                        <span class="text-gray-800 font-semibold">34%</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-progress bg-gradient-to-r from-pz-green to-pz-green/70" style="width: 34%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 flex items-center gap-1.5">
                                            <span class="text-sm">👕</span> Kläder
                                        </span>
                                        <span class="text-gray-800 font-semibold">28%</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-progress bg-gradient-to-r from-blue-500 to-blue-400" style="width: 28%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 flex items-center gap-1.5">
                                            <span class="text-sm">📺</span> Elektronik
                                        </span>
                                        <span class="text-gray-800 font-semibold">18%</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-progress bg-gradient-to-r from-purple-500 to-purple-400" style="width: 18%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 flex items-center gap-1.5">
                                            <span class="text-sm">🔨</span> Byggmaterial
                                        </span>
                                        <span class="text-gray-800 font-semibold">12%</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-progress bg-gradient-to-r from-orange-500 to-orange-400" style="width: 12%"></div>
                                    </div>
                                </div>
                                <div>
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="text-gray-600 flex items-center gap-1.5">
                                            <span class="text-sm">📚</span> Övrigt
                                        </span>
                                        <span class="text-gray-800 font-semibold">8%</span>
                                    </div>
                                    <div class="category-bar">
                                        <div class="category-progress bg-gradient-to-r from-gray-400 to-gray-300" style="width: 8%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stations & Activity -->
                    <div class="grid grid-cols-2 gap-3">
                        <!-- Stations -->
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-gray-800 font-semibold text-sm">Stationer</p>
                                <span class="text-xs text-pz-green font-medium">4 aktiva</span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-2.5">
                                        <div class="station-status"></div>
                                        <span class="text-gray-700 text-sm font-medium">Secondhand Butik</span>
                                    </div>
                                    <span class="text-gray-400 text-xs">847</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-2.5">
                                        <div class="station-status busy"></div>
                                        <span class="text-gray-700 text-sm font-medium">Återbruk Hall A</span>
                                    </div>
                                    <span class="text-gray-400 text-xs">1,203</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-2.5">
                                        <div class="station-status"></div>
                                        <span class="text-gray-700 text-sm font-medium">Återbruk Hall B</span>
                                    </div>
                                    <span class="text-gray-400 text-xs">956</span>
                                </div>
                                <div class="flex items-center justify-between p-2 rounded-lg bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex items-center gap-2.5">
                                        <div class="station-status"></div>
                                        <span class="text-gray-700 text-sm font-medium">Byggåterbruk</span>
                                    </div>
                                    <span class="text-gray-400 text-xs">841</span>
                                </div>
                            </div>
                        </div>

                        <!-- Live Activity -->
                        <div class="bg-white rounded-xl p-4 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <p class="text-gray-800 font-semibold text-sm">Senaste aktivitet</p>
                                <span class="pulse-dot w-2 h-2 rounded-full bg-green-500"></span>
                            </div>
                            <div class="space-y-2">
                                <div class="activity-item flex items-center gap-3 p-2 rounded-lg bg-gradient-to-r from-green-50 to-transparent">
                                    <div class="w-8 h-8 rounded-lg bg-pz-green/20 flex items-center justify-center text-sm">🛋️</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-700 text-xs font-medium truncate">IKEA Kallax hylla</p>
                                        <p class="text-gray-400 text-[10px]">Secondhand • Just nu</p>
                                    </div>
                                    <span class="text-pz-green text-xs font-semibold">+12kg</span>
                                </div>
                                <div class="activity-item flex items-center gap-3 p-2 rounded-lg">
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-sm">👕</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-700 text-xs font-medium truncate">Vinterjacka barn</p>
                                        <p class="text-gray-400 text-[10px]">Secondhand • 2 min</p>
                                    </div>
                                    <span class="text-pz-green text-xs font-semibold">+3kg</span>
                                </div>
                                <div class="activity-item flex items-center gap-3 p-2 rounded-lg">
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center text-sm">📺</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-700 text-xs font-medium truncate">Samsung 32" TV</p>
                                        <p class="text-gray-400 text-[10px]">Återbruk A • 5 min</p>
                                    </div>
                                    <span class="text-pz-green text-xs font-semibold">+18kg</span>
                                </div>
                                <div class="activity-item flex items-center gap-3 p-2 rounded-lg">
                                    <div class="w-8 h-8 rounded-lg bg-orange-100 flex items-center justify-center text-sm">🚪</div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-gray-700 text-xs font-medium truncate">Innerdörr vit 80cm</p>
                                        <p class="text-gray-400 text-[10px]">Byggåterbruk • 8 min</p>
                                    </div>
                                    <span class="text-pz-green text-xs font-semibold">+25kg</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Value Props -->
    <section id="om" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-pz-teal mb-4">Varför Scanit?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Ge era kunder möjlighet att se miljövärdet av sina val – och samla in data för er hållbarhetsredovisning.
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 card-shadow border border-gray-100 text-center">
                    <div class="feature-icon mx-auto mb-6">
                        <svg class="w-7 h-7 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pz-teal mb-3">Engagera kunderna</h3>
                    <p class="text-gray-600">Låt kunder registrera vad de hämtar och förstå miljövärdet av att välja återanvändning.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-shadow border border-gray-100 text-center">
                    <div class="feature-icon mx-auto mb-6">
                        <svg class="w-7 h-7 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pz-teal mb-3">Samla in statistik</h3>
                    <p class="text-gray-600">Få insikt om vilka föremål som hämtas, deras miljöpåverkan och totalt CO₂ sparat.</p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-shadow border border-gray-100 text-center">
                    <div class="feature-icon mx-auto mb-6">
                        <svg class="w-7 h-7 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-pz-teal mb-3">Visa er påverkan</h3>
                    <p class="text-gray-600">Använd statistiken i era hållbarhetsrapporter och kommunikation med intressenter.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How it works -->
    <section id="hur-det-fungerar" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-pz-teal mb-4">Så fungerar det</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Tre enkla steg för att komma igång med miljöregistrering på era anläggningar.
                </p>
            </div>

            <div class="grid lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl p-8 card-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="step-number">1</div>
                        <h3 class="text-xl font-semibold text-pz-teal">Skapa anläggningar</h3>
                    </div>
                    <p class="text-gray-600">
                        Lägg till era secondhand-butiker, återbruk eller återvinningscentraler i admin-panelen. Varje anläggning får egen statistik.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="step-number">2</div>
                        <h3 class="text-xl font-semibold text-pz-teal">Sätt upp QR-koder</h3>
                    </div>
                    <p class="text-gray-600">
                        Skapa stationer och ladda ner QR-koder. Placera dem där kunder kan skanna och fotografera föremål de tar med sig.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 card-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="step-number">3</div>
                        <h3 class="text-xl font-semibold text-pz-teal">Följ statistiken</h3>
                    </div>
                    <p class="text-gray-600">
                        Ni får all data i realtid. Kunden kan valfritt få sin egen miljörapport – ni får alltid statistiken.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="funktioner" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl font-bold text-pz-teal mb-4">Funktioner</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Allt ni behöver för att mäta och kommunicera er miljöpåverkan.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">AI-bildanalys</h3>
                    <p class="text-gray-600 text-sm">Automatisk identifiering av föremål, kategori och beräkning av miljöbesparing.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">Realtidsstatistik</h3>
                    <p class="text-gray-600 text-sm">Dashboard med översikt över skanningar, trender och miljöpåverkan.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">Miljörapporter</h3>
                    <p class="text-gray-600 text-sm">Kunder kan valfritt få en personlig rapport med CO₂-besparing via e-post.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">QR-koder</h3>
                    <p class="text-gray-600 text-sm">Generera och ladda ner QR-koder för varje station, färdiga för utskrift.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">Exportera data</h3>
                    <p class="text-gray-600 text-sm">Ladda ner statistik som PDF eller Excel för hållbarhetsrapporter.</p>
                </div>

                <div class="bg-gray-50 rounded-xl p-6 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-pz-green/20 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-pz-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-pz-teal mb-2">GDPR-säkert</h3>
                    <p class="text-gray-600 text-sm">All data lagras i Sverige. Besökare godkänner villkor innan e-post sparas.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="kontakt" class="py-20 bg-gradient-to-br from-[#005151] to-[#003838]">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-start">
                <!-- Left: Info -->
                <div class="text-white">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-6">
                        Redo att mäta er miljöpåverkan?
                    </h2>
                    <p class="text-xl text-white/80 mb-10 max-w-lg">
                        Boka en demo så visar vi hur Scanit hjälper er samla in statistik om allt som hämtas och köps på era anläggningar.
                    </p>

                    <!-- Contact info -->
                    <div class="space-y-6 mb-10">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/60 text-sm">Kontakt</p>
                                <a href="mailto:emilia.mastad@prezero.com" class="text-white font-medium hover:text-[#97d700] transition-colors">emilia.mastad@prezero.com</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center">
                                <svg class="w-6 h-6 text-[#97d700]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-white/60 text-sm">Telefon</p>
                                <a href="tel:+46431444000" class="text-white font-medium hover:text-[#97d700] transition-colors">0431-44 40 00</a>
                            </div>
                        </div>
                    </div>

                    <!-- Trust badges -->
                    <div class="flex flex-wrap gap-6 pt-8 border-t border-white/20">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">GDPR</div>
                            <div class="text-white/60 text-sm">Kompatibel</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">Sverige</div>
                            <div class="text-white/60 text-sm">Datalagring</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white mb-1">24/7</div>
                            <div class="text-white/60 text-sm">Tillgänglighet</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div>
                    <livewire:contact-form />
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-pz-dark py-16">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-4 mb-6">
                        <img src="/images/prezero-logo-white.svg" alt="PreZero" class="h-10">
                        <span class="text-2xl font-semibold text-white">Scan<span class="font-normal text-lg">it</span></span>
                    </div>
                    <p class="text-gray-400 max-w-sm">
                        Scanit är en tjänst från PreZero Sverige för att mäta och kommunicera miljövärdet av återanvändning.
                    </p>
                </div>

                <div>
                    <h4 class="text-white font-semibold mb-4">Tjänster</h4>
                    <ul class="space-y-3">
                        <li><a href="#om" class="text-gray-400 hover:text-white transition-colors">Om Scanit</a></li>
                        <li><a href="#funktioner" class="text-gray-400 hover:text-white transition-colors">Funktioner</a></li>
                        <li><a href="#hur-det-fungerar" class="text-gray-400 hover:text-white transition-colors">Hur det fungerar</a></li>
                        <li><a href="#kontakt" class="text-gray-400 hover:text-white transition-colors">Kontakt</a></li>
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

</body>
</html>
