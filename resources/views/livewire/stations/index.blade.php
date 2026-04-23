<div class="space-y-6">
    {{-- Action Bar --}}
    @if($facilities->isNotEmpty() && $this->canCreate)
        <div class="flex justify-end">
            <a href="{{ route('stations.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#97d700] text-[#005151] font-semibold rounded-lg hover:bg-[#85c100] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('scanit.stations.create') }}
            </a>
        </div>
    @endif

    {{-- Flash Message --}}
        @if(session('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if($facilities->isEmpty())
            {{-- No Facilities Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-amber-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('scanit.stations.empty_no_facility') }}</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">{{ __('scanit.facilities.empty_desc') }}</p>
                <a href="{{ route('facilities.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#97d700] text-[#005151] font-semibold rounded-xl hover:bg-[#85c100] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('scanit.stations.go_to_facilities') }}
                </a>
            </div>
        @elseif($stations->isEmpty() && empty($search) && empty($facilityFilter))
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#005151]/10 to-[#97d700]/10 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('scanit.stations.empty_title') }}</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">{{ __('scanit.stations.empty_desc') }}</p>
                @if($this->canCreate)
                    <a href="{{ route('stations.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#97d700] text-[#005151] font-semibold rounded-xl hover:bg-[#85c100] transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        {{ __('scanit.stations.empty_action') }}
                    </a>
                @endif
            </div>
        @else
            {{-- Filters --}}
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="relative flex-1 max-w-md">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        type="text"
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('scanit.actions.search') }}..."
                        class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                    />
                </div>

                <select
                    wire:model.live="facilityFilter"
                    class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 outline-none transition-colors"
                >
                    <option value="">Alla anläggningar</option>
                    @foreach($facilities as $facility)
                        <option value="{{ $facility->uuid }}">{{ $facility->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Stations Grid --}}
            <div class="grid gap-4">
                @forelse($stations as $station)
                    @php
                        $isArchived = $station->trashed();
                        $daysUntilDelete = $isArchived ? max(0, 7 - (int) now()->diffInDays($station->deleted_at)) : null;
                        $permanentDeleteDate = $isArchived ? $station->deleted_at->addDays(7) : null;
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm border {{ $isArchived ? 'border-red-200' : 'border-gray-100' }} overflow-hidden {{ $isArchived ? 'opacity-75' : 'hover:shadow-md' }} transition-shadow">
                        {{-- Archived Banner --}}
                        @if($isArchived)
                            <div class="bg-red-50 border-b border-red-200 px-6 py-3 flex items-center justify-between">
                                <div class="flex items-center gap-2 text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <span class="text-sm font-medium">
                                        {{ __('scanit.archive.will_be_deleted', ['date' => $permanentDeleteDate->format('j M Y'), 'days' => $daysUntilDelete]) }}
                                    </span>
                                </div>
                                @if($this->canDelete)
                                    <button wire:click="restoreStation({{ $station->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-red-300 text-red-700 text-sm font-medium rounded-lg hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        {{ __('scanit.actions.restore') }}
                                    </button>
                                @endif
                            </div>
                        @endif

                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl {{ $isArchived ? 'bg-gray-300' : 'bg-[#005151]' }} flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 {{ $isArchived ? 'text-gray-500' : 'text-white' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold {{ $isArchived ? 'text-gray-500' : 'text-gray-900' }}">{{ $station->name }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $station->facility?->name }}</p>
                                        @if($station->location_description)
                                            <p class="text-gray-600 text-sm mt-2">{{ $station->location_description }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    @if($isArchived)
                                        <span class="px-3 py-1 bg-red-50 text-red-700 text-xs font-medium rounded-full">
                                            {{ __('scanit.status.archived') }}
                                        </span>
                                    @elseif($station->is_active)
                                        <span class="px-3 py-1 bg-green-50 text-green-700 text-xs font-medium rounded-full">
                                            {{ __('scanit.status.active') }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-full">
                                            {{ __('scanit.status.inactive') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Stats --}}
                            <div class="grid grid-cols-3 gap-4 mt-6 pt-6 border-t border-gray-100">
                                <div class="text-center">
                                    <p class="text-2xl font-bold {{ $isArchived ? 'text-gray-400' : 'text-gray-900' }}">{{ number_format($station->total_scans ?? 0) }}</p>
                                    <p class="text-xs text-gray-500">{{ __('scanit.stations.total_scans') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold {{ $isArchived ? 'text-gray-400' : 'text-gray-900' }}">{{ number_format($station->total_items ?? 0) }}</p>
                                    <p class="text-xs text-gray-500">{{ __('scanit.stations.total_items') }}</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-bold {{ $isArchived ? 'text-gray-400' : 'text-gray-900' }}">{{ number_format($station->total_co2_savings ?? 0, 1) }}</p>
                                    <p class="text-xs text-gray-500">{{ __('scanit.stations.total_co2') }} (kg)</p>
                                </div>
                            </div>

                            {{-- Actions --}}
                            @if(!$isArchived)
                                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('stations.qr', $station) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#005151] text-white text-sm font-medium rounded-lg hover:bg-[#006666] transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                                            </svg>
                                            {{ __('scanit.stations.qr_code') }}
                                        </a>

                                        <button
                                            wire:click="copyLink('{{ $station->public_uuid }}')"
                                            class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors"
                                            x-data
                                            @copy-to-clipboard.window="navigator.clipboard.writeText($event.detail.url); $el.querySelector('span').textContent = '{{ __('scanit.stations.link_copied') }}'; setTimeout(() => $el.querySelector('span').textContent = '{{ __('scanit.stations.copy_link') }}', 2000)"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                                            </svg>
                                            <span>{{ __('scanit.stations.copy_link') }}</span>
                                        </button>

                                        <a href="{{ route('public.scan', $station->public_uuid) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            {{ __('scanit.stations.preview') }}
                                        </a>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        @if($this->canEdit)
                                            <a href="{{ route('stations.edit', $station) }}" class="p-2 text-gray-400 hover:text-[#005151] hover:bg-gray-100 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                </svg>
                                            </a>
                                        @endif
                                        @if($this->canDelete)
                                            <button wire:click="confirmDelete({{ $station->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                        <p class="text-gray-500">{{ __('scanit.no_data') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($stations->hasPages())
                <div class="mt-6">
                    {{ $stations->links() }}
                </div>
            @endif
        @endif

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="cancelDelete">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('scanit.archive.title') }}</h3>
                        <p class="text-sm text-gray-500">{{ $stationToDelete?->name }}</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">{{ __('scanit.archive.station_confirm') }}</p>
                <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 mb-6">
                    <p class="text-sm text-amber-800">{{ __('scanit.archive.grace_period_info') }}</p>
                </div>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        {{ __('scanit.actions.cancel') }}
                    </button>
                    <button wire:click="deleteStation" class="flex-1 px-4 py-2.5 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-colors">
                        {{ __('scanit.actions.archive') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
