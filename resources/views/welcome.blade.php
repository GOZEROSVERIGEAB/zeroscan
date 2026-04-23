<x-layouts.landing>
    {{-- Navigation --}}
    <nav class="sticky top-0 z-50 backdrop-blur-[14px] bg-bg/80 border-b border-line">
        <div class="max-w-[1360px] mx-auto px-8 py-[18px] flex items-center gap-8">
            {{-- Brand --}}
            <a href="#" class="flex items-center gap-2.5" aria-label="PreZero Scanit">
                <img src="{{ asset('images/prezero-logo.svg') }}" alt="PreZero" class="h-[26px]">
                <span class="font-display font-semibold text-[22px] tracking-tight text-green-ink">+</span>
            </a>

            {{-- Nav links --}}
            <div class="hidden lg:flex gap-7 ml-6">
                <a href="#tjanster" class="text-sm font-medium text-ink/75 hover:text-teal hover:opacity-100 transition-colors">Funktioner</a>
                <a href="#anvandningsfall" class="text-sm font-medium text-ink/75 hover:text-teal hover:opacity-100 transition-colors">Användningsfall</a>
                <a href="#rapporter" class="text-sm font-medium text-ink/75 hover:text-teal hover:opacity-100 transition-colors">Rapporter</a>
                <a href="#priser" class="text-sm font-medium text-ink/75 hover:text-teal hover:opacity-100 transition-colors">Priser</a>
                <a href="{{ route('reports.index') }}" class="text-sm font-medium text-green-ink hover:text-teal transition-colors">Demo</a>
            </div>

            {{-- CTA buttons --}}
            <div class="ml-auto flex gap-2.5 items-center">
                <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-[18px] py-[11px] rounded-full font-medium text-sm text-teal border border-line-strong bg-transparent hover:bg-teal/5 transition-all">
                    Logga in
                </a>
                <a href="#kontakt" class="inline-flex items-center gap-2 px-[18px] py-[11px] rounded-full font-medium text-sm bg-teal text-bg hover:bg-teal-deep hover:-translate-y-px transition-all group">
                    Boka demo <span class="group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform">↗</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <header class="relative max-w-[1360px] mx-auto px-8 pt-[72px] pb-14">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-start">
            {{-- Left column --}}
            <div>
                {{-- Eyebrow --}}
                <div class="inline-flex items-center gap-2.5 px-3.5 py-2 rounded-full bg-green/20 border border-green/40 mb-8" data-reveal>
                    <span class="w-[7px] h-[7px] rounded-full bg-green animate-pulse-dot"></span>
                    <span class="font-mono text-xs tracking-widest uppercase text-teal">Mät er miljöpåverkan</span>
                </div>

                {{-- Title --}}
                <h1 class="font-display font-semibold text-teal leading-[0.95] tracking-[-0.035em] text-[clamp(42px,5.5vw,72px)] mb-7" data-reveal data-delay="1">
                    Dokumentera<br>
                    återbruk med<br>
                    <span class="text-green-ink">verkliga siffror</span>
                </h1>

                {{-- Lede --}}
                <p class="text-[19px] text-muted max-w-[520px] mb-9 leading-normal" data-reveal data-delay="2">
                    PreZero Scanit hjälper återvinningscentraler, secondhand-butiker och byggåterbruk att mäta och rapportera sin miljöpåverkan. Ge era kunder personlig CO₂-feedback och få CSRD-redo data.
                </p>

                {{-- Actions --}}
                <div class="flex flex-wrap gap-3 mb-8" data-reveal data-delay="3">
                    <a href="#kontakt" class="inline-flex items-center gap-2 px-[18px] py-[11px] rounded-full font-medium text-sm bg-green text-teal hover:bg-green-hover transition-all group">
                        Boka demo <span class="group-hover:translate-x-0.5 group-hover:-translate-y-0.5 transition-transform">→</span>
                    </a>
                    <a href="#hur-det-fungerar" class="inline-flex items-center gap-2 px-[18px] py-[11px] rounded-full font-medium text-sm text-teal border border-line-strong bg-transparent hover:bg-teal/5 transition-all">
                        Se hur det fungerar
                    </a>
                </div>

                {{-- Trust badges --}}
                <div class="flex flex-wrap gap-4 text-xs text-muted" data-reveal data-delay="4">
                    <span class="flex items-center gap-1.5 bg-green/10 px-2.5 py-1 rounded-full border border-green/30">
                        <svg class="w-4 h-4 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span class="text-green-ink font-medium">100% verifierad CO₂-data</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        GDPR-säkert
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        CSRD-redo
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Data i Sverige
                    </span>
                </div>
            </div>

            {{-- Right column - Dashboard Mockup --}}
            <div class="relative" data-reveal data-delay="2">
                <div class="bg-white rounded-2xl border border-line shadow-xl overflow-hidden">
                    {{-- Dashboard Header --}}
                    <div class="p-4 border-b border-line bg-bg/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-teal flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5"/>
                                    </svg>
                                </div>
                                <span class="font-display font-semibold text-teal">Dashboard</span>
                            </div>
                            {{-- Period selector --}}
                            <div class="flex bg-bg rounded-lg p-0.5 text-[10px] font-medium">
                                <span class="px-2 py-1 text-muted">7d</span>
                                <span class="px-2 py-1 bg-green text-teal-deep rounded">30d</span>
                                <span class="px-2 py-1 text-muted">90d</span>
                                <span class="px-2 py-1 text-muted">365d</span>
                            </div>
                        </div>
                    </div>

                    {{-- Stats Cards --}}
                    <div class="p-4">
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">
                            {{-- Hämtade --}}
                            <div class="bg-bg/50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-muted uppercase tracking-wider">Hämtade</span>
                                    <span class="text-[10px] text-green-ink flex items-center gap-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                        18.2%
                                    </span>
                                </div>
                                <div class="font-display font-bold text-xl text-ink">3,847</div>
                            </div>
                            {{-- CO₂ --}}
                            <div class="bg-bg/50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-muted uppercase tracking-wider">CO₂ sparat</span>
                                    <span class="text-[10px] text-green-ink flex items-center gap-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                        23.5%
                                    </span>
                                </div>
                                <div class="font-display font-bold text-xl text-ink">2.4 <span class="text-sm font-normal text-muted">ton</span></div>
                            </div>
                            {{-- Värde --}}
                            <div class="bg-bg/50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-muted uppercase tracking-wider">Värde</span>
                                    <span class="text-[10px] text-green-ink flex items-center gap-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                        31.8%
                                    </span>
                                </div>
                                <div class="font-display font-bold text-xl text-ink">847 <span class="text-sm font-normal text-muted">tkr</span></div>
                            </div>
                            {{-- Besökare --}}
                            <div class="bg-bg/50 rounded-xl p-3">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[10px] text-muted uppercase tracking-wider">Besökare</span>
                                    <span class="text-[10px] text-green-ink flex items-center gap-0.5">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                                        12.4%
                                    </span>
                                </div>
                                <div class="font-display font-bold text-xl text-ink">1,293</div>
                            </div>
                        </div>

                        {{-- Chart mockup --}}
                        <div class="bg-bg/30 rounded-xl p-4 mb-4">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-medium text-ink">Hämtade föremål</span>
                                <span class="text-[10px] text-muted">Senaste 30 dagarna</span>
                            </div>
                            <div class="flex items-end gap-1 h-16">
                                @foreach ([45, 62, 38, 75, 52, 88, 65, 70, 55, 82, 48, 95, 72, 60, 78] as $height)
                                    <div class="flex-1 bg-green/{{ $loop->last ? '100' : '60' }} rounded-t" style="height: {{ $height }}%"></div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Bottom row --}}
                        <div class="grid grid-cols-2 gap-3">
                            {{-- Categories --}}
                            <div class="bg-bg/30 rounded-xl p-3">
                                <span class="text-[10px] text-muted uppercase tracking-wider block mb-2">Kategorier</span>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-green"></div>
                                        <span class="text-[11px] text-ink flex-1">Möbler</span>
                                        <span class="text-[11px] font-mono text-muted">34%</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-teal"></div>
                                        <span class="text-[11px] text-ink flex-1">Kläder</span>
                                        <span class="text-[11px] font-mono text-muted">28%</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                        <span class="text-[11px] text-ink flex-1">Elektronik</span>
                                        <span class="text-[11px] font-mono text-muted">18%</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-amber-500"></div>
                                        <span class="text-[11px] text-ink flex-1">Byggmaterial</span>
                                        <span class="text-[11px] font-mono text-muted">12%</span>
                                    </div>
                                </div>
                            </div>
                            {{-- Stations --}}
                            <div class="bg-bg/30 rounded-xl p-3">
                                <span class="text-[10px] text-muted uppercase tracking-wider block mb-2">Stationer</span>
                                <div class="space-y-1.5">
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green animate-pulse"></div>
                                        <span class="text-[11px] text-ink flex-1">Återbrukshall A</span>
                                        <span class="text-[10px] text-green-ink">Aktiv</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green animate-pulse"></div>
                                        <span class="text-[11px] text-ink flex-1">Klädinsamling</span>
                                        <span class="text-[10px] text-green-ink">Aktiv</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-muted/50"></div>
                                        <span class="text-[11px] text-ink flex-1">Elektronik</span>
                                        <span class="text-[10px] text-muted">Inaktiv</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <div class="w-1.5 h-1.5 rounded-full bg-green animate-pulse"></div>
                                        <span class="text-[11px] text-ink flex-1">Byggåterbruk</span>
                                        <span class="text-[10px] text-green-ink">Aktiv</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Floating badge --}}
                <div class="absolute -bottom-4 -right-4 bg-teal text-white px-4 py-2 rounded-xl shadow-lg text-sm font-medium">
                    Realtidsdata
                </div>
            </div>
        </div>
    </header>

    {{-- Market Context Section --}}
    <section class="py-[80px] px-8 bg-gradient-to-b from-bg to-white">
        <div class="max-w-[1360px] mx-auto">
            <div class="text-center mb-12" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-muted mb-3">Marknadskontext</div>
                <h2 class="font-display font-semibold text-teal leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,48px)] mb-4">
                    Sveriges massiva återbrukspotential
                </h2>
                <p class="text-muted max-w-[600px] mx-auto">
                    Miljarder i återbruksvärde försvinner varje år. Nya EU-regler kräver dokumentation. Tiden att agera är nu.
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" data-reveal data-delay="1">
                {{-- Stat cards --}}
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-teal mb-2">600+</div>
                    <div class="text-sm text-muted">återvinningscentraler i Sverige</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-teal mb-2">26M</div>
                    <div class="text-sm text-muted">besök per år</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-green-ink mb-2">70%</div>
                    <div class="text-sm text-muted">tar emot återbruk</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-teal mb-2">400+</div>
                    <div class="text-sm text-muted">secondhand-butiker</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-red-500 mb-2">3.4%</div>
                    <div class="text-sm text-muted">återcirkuleras idag</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-amber-600 mb-2">600</div>
                    <div class="text-sm text-muted">miljarder SEK årligt värdegap</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-3xl font-display font-bold text-green-ink mb-2">95%</div>
                    <div class="text-sm text-muted">lägre utsläpp vs nytillverkning</div>
                </div>
                <div class="bg-white rounded-2xl p-6 border border-line text-center">
                    <div class="text-2xl font-display font-bold text-teal mb-2">Juli 2026</div>
                    <div class="text-sm text-muted">EU Right to Repair & ESPR träder i kraft</div>
                </div>
            </div>

            <p class="text-center text-xs text-muted mt-6" data-reveal data-delay="2">
                Källor: Avfall Sverige, RISE, Naturvårdsverket
            </p>
        </div>
    </section>

    {{-- Use Cases Section --}}
    <section id="anvandningsfall" class="py-[100px] px-8">
        <div class="max-w-[1360px] mx-auto">
            <div class="text-center mb-14" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-muted mb-3">Användningsfall</div>
                <h2 class="font-display font-semibold text-teal leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,52px)]">
                    Anpassat för er verksamhet
                </h2>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                {{-- Use Case 1: Kommunal ÅVC --}}
                <div class="bg-gradient-to-br from-teal/5 to-teal/10 rounded-2xl p-8 border border-teal/20" data-reveal>
                    <div class="w-14 h-14 rounded-2xl bg-teal/10 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-2xl text-teal mb-3">Kommunal Återvinningscentral</h3>
                    <p class="text-muted mb-6">Maximera återbruk och bevisa miljöpåverkan för budgetbeslut.</p>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Automatisk CSRD-rapportering</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Bevis för kommunfullmäktige</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Jämför anläggningar</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Invånare får personlig miljörapport</span>
                        </div>
                    </div>

                    <div class="bg-white/60 rounded-xl p-4 border border-line">
                        <div class="text-xs text-muted uppercase tracking-wider mb-2">Exempeldata per år</div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="font-mono font-medium text-teal">3</span> anläggningar</div>
                            <div><span class="font-mono font-medium text-teal">8</span> stationer</div>
                            <div><span class="font-mono font-medium text-teal">2,500</span> skanningar/mån</div>
                            <div><span class="font-mono font-medium text-green-ink">15 ton</span> CO₂</div>
                        </div>
                    </div>
                </div>

                {{-- Use Case 2: Secondhand --}}
                <div class="bg-gradient-to-br from-green/5 to-green/10 rounded-2xl p-8 border border-green/20" data-reveal data-delay="1">
                    <div class="w-14 h-14 rounded-2xl bg-green/10 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-green-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-2xl text-teal mb-3">Secondhand-kedja</h3>
                    <p class="text-muted mb-6">Visa kunderna deras miljöpåverkan och öka lojaliteten.</p>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Personlig miljörapport via e-post</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Marknadsföring med verkliga siffror</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Kategoriinsikter - vad säljer?</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">CSRD-redo för årsredovisningen</span>
                        </div>
                    </div>

                    <div class="bg-white/60 rounded-xl p-4 border border-line">
                        <div class="text-xs text-muted uppercase tracking-wider mb-2">Exempeldata per år</div>
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <div><span class="font-mono font-medium text-teal">5</span> butiker</div>
                            <div><span class="font-mono font-medium text-teal">10</span> stationer</div>
                            <div><span class="font-mono font-medium text-teal">3,000</span> köp/mån</div>
                            <div><span class="font-mono font-medium text-green-ink">8.2 ton</span> CO₂</div>
                        </div>
                    </div>
                </div>

                {{-- Use Case 3: Byggåterbruk --}}
                <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-2xl p-8 border border-amber-200/50" data-reveal data-delay="2">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21l-7-5-7 5V5a2 2 0 012-2h10a2 2 0 012 2v16z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-2xl text-teal mb-3">Byggåterbruk</h3>
                    <p class="text-muted mb-6">Cirkulär ekonomi för byggmaterial med stor CO₂-besparing.</p>

                    <div class="space-y-3 mb-6">
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Dokumentera tunga materialbesparingar</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Underlag för BREEAM & Svanen</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Spårbarhet för byggprojekt</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Konkret miljövinst för entreprenörer</span>
                        </div>
                    </div>

                    <div class="bg-white/60 rounded-xl p-4 border border-line">
                        <div class="text-xs text-muted uppercase tracking-wider mb-2">Exempelmaterial</div>
                        <div class="flex flex-wrap gap-2 text-xs">
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded">Dörrar</span>
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded">Fönster</span>
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded">VVS</span>
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded">Kakel</span>
                            <span class="px-2 py-1 bg-amber-100 text-amber-800 rounded">Virke</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- How It Works Section --}}
    <section id="hur-det-fungerar" class="py-[100px] px-8 bg-teal">
        <div class="max-w-[1360px] mx-auto">
            <div class="text-center mb-14" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-green mb-3">Kom igång</div>
                <h2 class="font-display font-semibold text-white leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,52px)]">
                    Så enkelt fungerar det
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Step 1 --}}
                <div class="relative" data-reveal>
                    <div class="bg-white/10 rounded-2xl p-8 border border-white/20 h-full">
                        <div class="font-display font-bold text-[56px] text-white/40 mb-4">01</div>
                        <h3 class="font-display font-semibold text-xl text-white mb-3">Skapa anläggningar och stationer</h3>
                        <p class="text-white/70 mb-4">Lägg till era platser i admin-panelen. Anpassa text, logga och varumärke. Klart på 5 minuter.</p>
                        <div class="flex items-center gap-2 text-sm text-green">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            5 min setup
                        </div>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-4 w-8 h-0.5 bg-green/50"></div>
                </div>

                {{-- Step 2 --}}
                <div class="relative" data-reveal data-delay="1">
                    <div class="bg-white/10 rounded-2xl p-8 border border-white/20 h-full">
                        <div class="font-display font-bold text-[56px] text-white/40 mb-4">02</div>
                        <h3 class="font-display font-semibold text-xl text-white mb-3">Placera QR-koder</h3>
                        <p class="text-white/70 mb-4">Ladda ner färdiga QR-koder för varje station. Skriv ut och placera där kunder hämtar eller köper.</p>
                        <div class="flex items-center gap-2 text-sm text-green">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Kunder skannar med mobilen
                        </div>
                    </div>
                    <div class="hidden md:block absolute top-1/2 -right-4 w-8 h-0.5 bg-green/50"></div>
                </div>

                {{-- Step 3 --}}
                <div data-reveal data-delay="2">
                    <div class="bg-white/10 rounded-2xl p-8 border border-white/20 h-full">
                        <div class="font-display font-bold text-[56px] text-white/40 mb-4">03</div>
                        <h3 class="font-display font-semibold text-xl text-white mb-3">Följ statistiken i realtid</h3>
                        <p class="text-white/70 mb-4">Dashboard med alla anläggningar. Automatiska miljöberäkningar. Exportera rapporter med ett klick.</p>
                        <div class="flex items-center gap-2 text-sm text-green">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            CSRD-redo rapporter
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Verified Data Callout --}}
    <section class="py-12 px-8 bg-green/10 border-y border-green/20">
        <div class="max-w-[900px] mx-auto text-center" data-reveal>
            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-green/30 mb-4">
                <svg class="w-5 h-5 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <span class="text-sm font-medium text-green-ink">100% Verifierad miljödata</span>
            </div>
            <h2 class="font-display font-semibold text-teal text-2xl md:text-3xl mb-4">
                CO₂-siffror du kan lita på
            </h2>
            <p class="text-muted max-w-[700px] mx-auto mb-6">
                All miljödata i PreZero Scanit kommer från officiella vetenskapliga källor — <strong>aldrig AI-gissningar</strong>.
                Vi använder livscykelanalyser (LCA) enligt ISO 14040-44 från svenska myndigheter och forskningsinstitut.
            </p>
            <div class="flex flex-wrap justify-center gap-3 text-xs">
                <span class="px-3 py-1.5 bg-white rounded-full border border-line text-muted">IVL Svenska Miljöinstitutet</span>
                <span class="px-3 py-1.5 bg-white rounded-full border border-line text-muted">Naturskyddsföreningen</span>
                <span class="px-3 py-1.5 bg-white rounded-full border border-line text-muted">Naturvårdsverket / RISE</span>
                <span class="px-3 py-1.5 bg-white rounded-full border border-line text-muted">Carbonfact</span>
                <span class="px-3 py-1.5 bg-white rounded-full border border-line text-muted">Nature Scientific Reports</span>
            </div>
        </div>
    </section>

    {{-- Reports Section --}}
    <section id="rapporter" class="py-[100px] px-8">
        <div class="max-w-[1360px] mx-auto">
            <div class="text-center mb-14" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-muted mb-3">Rapporter & Compliance</div>
                <h2 class="font-display font-semibold text-teal leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,52px)]">
                    Kraftfulla rapporter för alla behov
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                {{-- Environmental Report --}}
                <div class="bg-white rounded-2xl border border-line overflow-hidden" data-reveal>
                    <div class="h-48 bg-gradient-to-br from-teal to-teal-deep p-6 flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-white/70 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064"/>
                            </svg>
                            Miljöpåverkan
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="text-center">
                                <div class="text-2xl font-display font-bold text-green">2.4t</div>
                                <div class="text-[10px] text-white/60">CO₂</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-display font-bold text-green">847</div>
                                <div class="text-[10px] text-white/60">Träd</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-display font-bold text-green">12k</div>
                                <div class="text-[10px] text-white/60">Bil-km</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display font-semibold text-lg mb-2">Miljöpåverkan</h3>
                        <p class="text-sm text-muted mb-4">CO₂-data från IVL, Naturskyddsföreningen och Naturvårdsverket — inga AI-uppskattningar.</p>
                        <ul class="text-sm space-y-1.5 text-muted">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>100% verifierade LCA-siffror</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>Källhänvisning på all data</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>CSR/CSRD-godkänd</li>
                        </ul>
                    </div>
                </div>

                {{-- CSRD Report --}}
                <div class="bg-white rounded-2xl border border-line overflow-hidden" data-reveal data-delay="1">
                    <div class="h-48 bg-gradient-to-br from-slate-700 to-slate-900 p-6 flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-white/70 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            CSRD / ESRS E5
                        </div>
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-white/60">Materialinflöden</span>
                                <span class="text-white font-mono">4,847 kg</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-white/60">Återanvändningsgrad</span>
                                <span class="text-green font-mono">78.4%</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-white/60">Cirkulärt värde</span>
                                <span class="text-white font-mono">847K SEK</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display font-semibold text-lg mb-2">CSRD-rapport</h3>
                        <p class="text-sm text-muted mb-4">ESRS E5-kompatibel för hållbarhetsredovisning med kvartals- och årsjämförelser.</p>
                        <ul class="text-sm space-y-1.5 text-muted">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>Materialinflöden (kg)</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>Avfall förhindrat</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>GRI-standard redo</li>
                        </ul>
                    </div>
                </div>

                {{-- Export Center --}}
                <div class="bg-white rounded-2xl border border-line overflow-hidden" data-reveal data-delay="2">
                    <div class="h-48 bg-gradient-to-br from-green to-green-hover p-6 flex flex-col justify-between">
                        <div class="flex items-center gap-2 text-teal-deep/70 text-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Exportcenter
                        </div>
                        <div class="flex gap-3">
                            <div class="bg-white/20 rounded-lg px-3 py-2 text-center">
                                <div class="text-xs text-teal-deep/70">PDF</div>
                                <svg class="w-8 h-8 mx-auto text-teal-deep" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                </svg>
                            </div>
                            <div class="bg-white/20 rounded-lg px-3 py-2 text-center">
                                <div class="text-xs text-teal-deep/70">Excel</div>
                                <svg class="w-8 h-8 mx-auto text-teal-deep" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                </svg>
                            </div>
                            <div class="bg-white/20 rounded-lg px-3 py-2 text-center">
                                <div class="text-xs text-teal-deep/70">Certifikat</div>
                                <svg class="w-8 h-8 mx-auto text-teal-deep" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8l-6-6z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="font-display font-semibold text-lg mb-2">Exportcenter</h3>
                        <p class="text-sm text-muted mb-4">Ladda ner rapporter i valfritt format. Ingen inlåsning — er data, era rapporter.</p>
                        <ul class="text-sm space-y-1.5 text-muted">
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>PDF för styrelsen</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>Excel för detaljanalys</li>
                            <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 bg-green rounded-full"></span>Certifikat för marknadsföring</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="tjanster" class="py-[100px] px-8 bg-bg">
        <div class="max-w-[1360px] mx-auto">
            <div class="text-center mb-14" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-muted mb-3">Funktioner</div>
                <h2 class="font-display font-semibold text-teal leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,52px)]">
                    Allt du behöver för att mäta återbruk
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Feature 1: AI --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal>
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">AI-bildanalys</h3>
                    <p class="text-sm text-muted">AI identifierar och kategoriserar föremål. Miljödata hämtas från verifierade vetenskapliga källor — aldrig AI-gissningar.</p>
                </div>

                {{-- Feature 2: Realtime --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="1">
                    <div class="w-12 h-12 rounded-xl bg-green/10 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Realtidsstatistik</h3>
                    <p class="text-sm text-muted">Dashboard med 7d/30d/90d/365d perioder. Se trender och jämför anläggningar live.</p>
                </div>

                {{-- Feature 3: CSRD --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="2">
                    <div class="w-12 h-12 rounded-xl bg-teal/10 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-teal" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">CSRD-rapporter</h3>
                    <p class="text-sm text-muted">ESRS E5-kompatibla för hållbarhetsredovisning. GRI 301 och GRI 306 redo.</p>
                </div>

                {{-- Feature 4: Email --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="3">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Miljörapporter</h3>
                    <p class="text-sm text-muted">Kunder får personlig CO₂-besparing via e-post. Ökar lojalitet och engagemang.</p>
                </div>

                {{-- Feature 5: QR --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="4">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">QR-koder</h3>
                    <p class="text-sm text-muted">Ladda ner för varje station, färdiga för utskrift. Kunder skannar med sin mobil.</p>
                </div>

                {{-- Feature 6: Export --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="5">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Exportera data</h3>
                    <p class="text-sm text-muted">PDF och Excel för årsredovisningar och detaljanalys. Er data, inga begränsningar.</p>
                </div>

                {{-- Feature 7: Brand --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="6">
                    <div class="w-12 h-12 rounded-xl bg-rose-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">Anpassat varumärke</h3>
                    <p class="text-sm text-muted">Er logga och färger på kundupplevelsen. Stärker ert varumärke vid varje interaktion.</p>
                </div>

                {{-- Feature 8: GDPR --}}
                <div class="bg-white rounded-xl p-6 border border-line" data-reveal data-delay="7">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-display font-semibold text-lg mb-2">GDPR-säkert</h3>
                    <p class="text-sm text-muted">All data lagras i Sverige. Samtycke före e-post. Full transparens och kontroll.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Pricing Section --}}
    <section id="priser" class="py-[100px] px-8">
        <div class="max-w-[900px] mx-auto">
            <div class="text-center mb-14" data-reveal>
                <div class="font-mono text-xs tracking-widest uppercase text-muted mb-3">Prissättning</div>
                <h2 class="font-display font-semibold text-teal leading-tight tracking-[-0.03em] text-[clamp(32px,4vw,52px)]">
                    Enkel och transparent prissättning
                </h2>
            </div>

            <div class="bg-white rounded-3xl border-2 border-line shadow-xl overflow-hidden" data-reveal data-delay="1">
                <div class="p-8 md:p-12 text-center border-b border-line bg-gradient-to-b from-bg/50 to-transparent">
                    <p class="text-muted mb-6">Kontakta oss för priser för just er lösning</p>

                    <div class="bg-green/10 border border-green/30 rounded-2xl p-6 max-w-md mx-auto">
                        <div class="text-sm text-muted mb-2">Exempelpris:</div>
                        <div class="text-sm text-ink mb-3">1 anläggning, 3 stationer, ~1,000 skanningar/månad</div>
                        <div class="font-display font-bold text-4xl text-teal">3 000 <span class="text-lg font-normal">SEK + moms / månad</span></div>
                    </div>
                </div>

                <div class="p-8 md:p-12">
                    <h3 class="font-display font-semibold text-lg mb-6 text-center">Inkluderar:</h3>
                    <div class="grid md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Obegränsad tillgång till dashboard och rapporter</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">AI-analys av alla bilder</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Miljöberäkningar och CSRD-data</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Kundmiljörapporter via e-post</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Export till PDF och Excel</span>
                        </div>
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-ink flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            <span class="text-sm">Support via e-post</span>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6 pt-6 border-t border-line">
                        <div>
                            <h4 class="font-medium text-teal mb-3">Inga bindningstider</h4>
                            <ul class="text-sm text-muted space-y-1.5">
                                <li>• Ingen startavgift</li>
                                <li>• Ingen uppsägningstid</li>
                                <li>• Månadsvis fakturering</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-teal mb-3">Ni äger er data</h4>
                            <ul class="text-sm text-muted space-y-1.5">
                                <li>• Exportera all data när som helst</li>
                                <li>• Ingen inlåsning</li>
                                <li>• Full GDPR-kontroll</li>
                            </ul>
                        </div>
                    </div>

                    <div class="text-center mt-8">
                        <a href="#kontakt" class="inline-flex items-center gap-2 px-8 py-4 rounded-full font-medium bg-green text-teal hover:bg-green-hover transition-all group">
                            Boka demo för prisförslag <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Trust Section --}}
    <section class="py-12 px-8 border-y border-line bg-bg/50">
        <div class="max-w-[1360px] mx-auto">
            <div class="flex flex-wrap items-center justify-center gap-6 md:gap-10">
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-line">
                    <img src="{{ asset('images/prezero-logo.svg') }}" alt="PreZero" class="h-5">
                    <span class="text-sm text-muted">Powered by PreZero</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-line">
                    <svg class="w-5 h-5 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    <span class="text-sm text-muted">GDPR-säkert</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-line">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                    <span class="text-sm text-muted">Data lagras i Sverige</span>
                </div>
                <div class="flex items-center gap-2 px-4 py-2 bg-white rounded-full border border-line">
                    <span class="text-sm font-medium text-purple-600">Anthropic</span>
                    <span class="text-sm text-muted">AI-partner</span>
                </div>
            </div>
            <p class="text-center text-xs text-muted mt-4">
                CO₂-data från: IVL Svenska Miljöinstitutet, Naturskyddsföreningen, Naturvårdsverket, RISE, Carbonfact
            </p>
        </div>
    </section>

    {{-- Contact Section --}}
    <section id="kontakt" class="py-[120px] px-8">
        <div class="max-w-[1360px] mx-auto">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                {{-- Left copy --}}
                <div>
                    <div class="font-mono text-xs tracking-widest uppercase text-muted mb-4" data-reveal>Kontakta oss</div>
                    <h2 class="font-display font-semibold text-teal leading-none tracking-[-0.03em] text-[clamp(40px,5vw,64px)] mb-5" data-reveal data-delay="1">
                        Redo att mäta er miljöpåverkan?
                    </h2>
                    <p class="text-muted text-[17px] max-w-[460px] mb-6" data-reveal data-delay="2">
                        Boka en kostnadsfri demo och se hur PreZero Scanit kan hjälpa er dokumentera återbruk med verkliga siffror.
                    </p>
                    <div class="space-y-3" data-reveal data-delay="3">
                        <div class="flex items-center gap-3 text-sm text-muted">
                            <svg class="w-5 h-5 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            20 min demo av plattformen
                        </div>
                        <div class="flex items-center gap-3 text-sm text-muted">
                            <svg class="w-5 h-5 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Prisförslag anpassat för er
                        </div>
                        <div class="flex items-center gap-3 text-sm text-muted">
                            <svg class="w-5 h-5 text-green-ink" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            Ingen förpliktelse
                        </div>
                    </div>
                </div>

                {{-- Right form --}}
                <div class="bg-white border border-line rounded-2xl p-6" data-reveal data-delay="2">
                    <form id="contact-form" class="space-y-3.5">
                        <div>
                            <label class="block text-[13px] font-medium text-teal mb-1.5">Namn</label>
                            <input type="text" name="name" placeholder="Anna Andersson" required class="w-full px-3.5 py-3 border border-line-strong rounded-[10px] bg-bg text-[15px] text-ink outline-none focus:border-teal transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-teal mb-1.5">Jobbmejl</label>
                            <input type="email" name="email" placeholder="anna@foretag.se" required class="w-full px-3.5 py-3 border border-line-strong rounded-[10px] bg-bg text-[15px] text-ink outline-none focus:border-teal transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-teal mb-1.5">Organisation</label>
                            <input type="text" name="company" placeholder="Kommun / Företag" required class="w-full px-3.5 py-3 border border-line-strong rounded-[10px] bg-bg text-[15px] text-ink outline-none focus:border-teal transition-colors">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-teal mb-1.5">Verksamhetstyp</label>
                            <select name="type" class="w-full px-3.5 py-3 border border-line-strong rounded-[10px] bg-bg text-[15px] text-ink outline-none focus:border-teal transition-colors">
                                <option value="">Välj typ...</option>
                                <option value="avc">Kommunal återvinningscentral</option>
                                <option value="secondhand">Secondhand-butik/kedja</option>
                                <option value="bygg">Byggåterbruk</option>
                                <option value="annat">Annat</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-teal mb-1.5">Meddelande (valfritt)</label>
                            <textarea name="message" rows="3" placeholder="Berätta kort om era behov..." class="w-full px-3.5 py-3 border border-line-strong rounded-[10px] bg-bg text-[15px] text-ink outline-none focus:border-teal transition-colors resize-none"></textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-[18px] py-[13px] rounded-full font-medium text-sm bg-teal text-bg hover:bg-teal-deep hover:-translate-y-px transition-all group">
                            Boka demo <span class="group-hover:translate-x-0.5 transition-transform">→</span>
                        </button>
                        <p class="text-[12.5px] text-muted pt-2">
                            Genom att skicka godkänner du att vi kontaktar dig angående PreZero Scanit. Vi delar aldrig dina uppgifter med tredje part.
                        </p>
                    </form>

                    {{-- Success state (hidden by default) --}}
                    <div id="contact-success" class="hidden py-8 text-center">
                        <div class="w-14 h-14 rounded-full bg-green mx-auto mb-4 grid place-items-center text-teal text-[28px]">✓</div>
                        <h4 class="font-display font-semibold text-[22px] text-teal mb-2">Tack!</h4>
                        <p class="text-muted">Vi hör av oss inom 24 timmar för att boka in en demo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-teal-deep text-bg pt-20 pb-10 px-8">
        <div class="max-w-[1360px] mx-auto">
            <div class="grid grid-cols-2 lg:grid-cols-[1.6fr_1fr_1fr_1fr] gap-12 pb-12 border-b border-bg/15">
                {{-- Brand column --}}
                <div class="col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-2.5 mb-4">
                        <img src="{{ asset('images/prezero-logo.svg') }}" alt="PreZero" class="h-[30px] brightness-0 invert">
                        <span class="font-display font-semibold text-[26px] tracking-tight text-green">+</span>
                    </div>
                    <p class="text-[14.5px] opacity-70 max-w-[340px]">
                        PreZero Scanit hjälper återvinningscentraler, secondhand-butiker och byggåterbruk att mäta och rapportera sin miljöpåverkan.
                    </p>
                </div>

                {{-- Produkt --}}
                <div>
                    <h5 class="font-display text-[13px] uppercase tracking-widest opacity-55 font-medium mb-3.5">Produkt</h5>
                    <ul class="space-y-2.5">
                        <li><a href="#tjanster" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Funktioner</a></li>
                        <li><a href="#anvandningsfall" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Användningsfall</a></li>
                        <li><a href="#rapporter" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Rapporter</a></li>
                        <li><a href="#priser" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Priser</a></li>
                    </ul>
                </div>

                {{-- Företag --}}
                <div>
                    <h5 class="font-display text-[13px] uppercase tracking-widest opacity-55 font-medium mb-3.5">Företag</h5>
                    <ul class="space-y-2.5">
                        <li><a href="https://www.prezero.se" target="_blank" rel="noopener noreferrer" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">PreZero.se ↗</a></li>
                        <li><a href="#kontakt" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Kontakt</a></li>
                        <li><a href="{{ route('reports.index') }}" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Demo</a></li>
                    </ul>
                </div>

                {{-- Juridik --}}
                <div>
                    <h5 class="font-display text-[13px] uppercase tracking-widest opacity-55 font-medium mb-3.5">Juridik</h5>
                    <ul class="space-y-2.5">
                        <li><a href="#" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Integritetspolicy</a></li>
                        <li><a href="#" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Användarvillkor</a></li>
                        <li><a href="#" class="text-[14.5px] text-bg/80 hover:text-green hover:opacity-100 transition-colors">Cookies</a></li>
                    </ul>
                </div>
            </div>

            {{-- Bottom bar --}}
            <div class="flex flex-wrap justify-between items-center gap-4 mt-8 text-[13px] opacity-55">
                <div>© 2026 PreZero Sverige AB</div>
                <div>Utvecklad av <span class="text-green">GoZero Sverige AB</span> — ett techbolag i PreZero-koncernen</div>
            </div>
        </div>
    </footer>

    {{-- Contact form handler --}}
    <script>
        document.getElementById('contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            this.style.display = 'none';
            document.getElementById('contact-success').classList.remove('hidden');
        });
    </script>
</x-layouts.landing>
