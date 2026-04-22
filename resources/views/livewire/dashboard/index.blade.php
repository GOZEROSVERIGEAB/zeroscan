<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Welcome Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900">
                {{ __('scanit.dashboard.welcome_back', ['name' => auth()->user()->name]) }}
            </h1>
            <p class="text-gray-500 mt-1">{{ __('scanit.dashboard.title') }} - Scanit</p>
        </div>

        {{-- Onboarding --}}
        @if($showOnboarding)
            <div class="bg-gradient-to-br from-[#005151] to-[#006666] rounded-2xl p-8 mb-8 text-white">
                <div class="max-w-2xl">
                    <h2 class="text-2xl font-bold mb-2">{{ __('scanit.onboarding.title') }}</h2>
                    <p class="text-white/80 mb-8">{{ __('scanit.onboarding.subtitle') }}</p>

                    {{-- Progress --}}
                    <div class="flex items-center gap-2 mb-8">
                        @for($i = 1; $i <= $totalSteps; $i++)
                            <div class="flex-1 h-2 rounded-full {{ $i <= $onboardingStep ? 'bg-[#97d700]' : 'bg-white/20' }}"></div>
                        @endfor
                    </div>

                    {{-- Steps --}}
                    <div class="bg-white/10 rounded-xl p-6 backdrop-blur-sm">
                        @if($onboardingStep === 1)
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#97d700] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">{{ __('scanit.onboarding.step_1_title') }}</h3>
                                    <p class="text-white/70">{{ __('scanit.onboarding.step_1_desc') }}</p>
                                </div>
                            </div>
                        @elseif($onboardingStep === 2)
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#97d700] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">{{ __('scanit.onboarding.step_2_title') }}</h3>
                                    <p class="text-white/70">{{ __('scanit.onboarding.step_2_desc') }}</p>
                                </div>
                            </div>
                        @elseif($onboardingStep === 3)
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#97d700] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">{{ __('scanit.onboarding.step_3_title') }}</h3>
                                    <p class="text-white/70">{{ __('scanit.onboarding.step_3_desc') }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-[#97d700] flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold mb-2">{{ __('scanit.onboarding.step_4_title') }}</h3>
                                    <p class="text-white/70">{{ __('scanit.onboarding.step_4_desc') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Navigation --}}
                    <div class="flex items-center justify-between mt-6">
                        <div class="text-sm text-white/60">
                            {{ __('scanit.onboarding.step', ['current' => $onboardingStep, 'total' => $totalSteps]) }}
                        </div>
                        <div class="flex items-center gap-3">
                            <button wire:click="skipOnboarding" class="px-4 py-2 text-white/70 hover:text-white transition-colors">
                                {{ __('scanit.onboarding.skip') }}
                            </button>

                            @if($onboardingStep > 1)
                                <button wire:click="previousStep" class="px-4 py-2 bg-white/10 hover:bg-white/20 rounded-lg transition-colors">
                                    {{ __('scanit.onboarding.previous') }}
                                </button>
                            @endif

                            @if($onboardingStep < $totalSteps)
                                <button wire:click="nextStep" class="px-6 py-2 bg-[#97d700] text-[#005151] font-semibold rounded-lg hover:bg-[#85c100] transition-colors">
                                    {{ __('scanit.onboarding.next') }}
                                </button>
                            @else
                                <button wire:click="goToFacilities" class="px-6 py-2 bg-[#97d700] text-[#005151] font-semibold rounded-lg hover:bg-[#85c100] transition-colors">
                                    {{ __('scanit.onboarding.complete') }}
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Quick Stats --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['today_scans'] }}</p>
                        <p class="text-sm text-gray-500">{{ __('scanit.stats.today') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_scans']) }}</p>
                        <p class="text-sm text-gray-500">{{ __('scanit.stats.total_scans') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-amber-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_items']) }}</p>
                        <p class="text-sm text-gray-500">{{ __('scanit.stats.total_items') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_co2'] }} <span class="text-sm font-normal text-gray-500">kg</span></p>
                        <p class="text-sm text-gray-500">{{ __('scanit.stats.total_co2') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Facilities --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('scanit.facilities.title') }}</h2>
                        <a href="{{ route('facilities.index') }}" class="text-sm text-[#005151] hover:underline font-medium">
                            {{ __('scanit.actions.view') }} →
                        </a>
                    </div>

                    @if($facilities->isEmpty())
                        {{-- Empty State --}}
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ __('scanit.facilities.empty_title') }}</h3>
                            <p class="text-gray-500 mb-6 max-w-sm mx-auto">{{ __('scanit.facilities.empty_desc') }}</p>
                            <a href="{{ route('facilities.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#97d700] text-[#005151] font-semibold rounded-lg hover:bg-[#85c100] transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                {{ __('scanit.facilities.empty_action') }}
                            </a>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100">
                            @foreach($facilities as $facility)
                                <a href="{{ route('facilities.edit', $facility) }}" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-lg bg-[#005151]/10 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $facility->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $facility->city }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span class="text-sm text-gray-500">{{ __('scanit.facilities.stations_count', ['count' => $facility->stations_count]) }}</span>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Activity --}}
            <div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-semibold text-gray-900">{{ __('scanit.dashboard.recent_activity') }}</h2>
                    </div>

                    @if($recentActivity->isEmpty())
                        <div class="p-8 text-center">
                            <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <p class="text-gray-500 text-sm">{{ __('scanit.dashboard.no_activity') }}</p>
                        </div>
                    @else
                        <div class="divide-y divide-gray-100 max-h-96 overflow-y-auto">
                            @foreach($recentActivity as $session)
                                <div class="p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-8 h-8 rounded-lg bg-green-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ $session->station?->name ?? 'Station' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $session->completed_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
