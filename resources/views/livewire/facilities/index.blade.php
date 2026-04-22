<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('scanit.facilities.title') }}</h1>
                <p class="text-gray-500 mt-1">{{ __('scanit.facilities.subtitle') }}</p>
            </div>
            <a href="{{ route('facilities.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#97d700] text-[#005151] font-semibold rounded-lg hover:bg-[#85c100] transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                {{ __('scanit.facilities.create') }}
            </a>
        </div>

        {{-- Flash Message --}}
        @if(session('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif

        @if($facilities->isEmpty() && empty($search))
            {{-- Empty State --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-[#005151]/10 to-[#97d700]/10 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ __('scanit.facilities.empty_title') }}</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">{{ __('scanit.facilities.empty_desc') }}</p>
                <a href="{{ route('facilities.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#97d700] text-[#005151] font-semibold rounded-xl hover:bg-[#85c100] transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    {{ __('scanit.facilities.empty_action') }}
                </a>
            </div>
        @else
            {{-- Search --}}
            <div class="mb-6">
                <div class="relative max-w-md">
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
            </div>

            {{-- Facilities Grid --}}
            <div class="grid gap-4">
                @forelse($facilities as $facility)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-[#005151]/10 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-6 h-6 text-[#005151]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">{{ $facility->name }}</h3>
                                        <p class="text-gray-500 text-sm mt-1">
                                            @if($facility->address)
                                                {{ $facility->address }}, {{ $facility->postal_code }} {{ $facility->city }}
                                            @else
                                                {{ $facility->city ?? '-' }}
                                            @endif
                                        </p>
                                        @if($facility->description)
                                            <p class="text-gray-600 text-sm mt-2">{{ Str::limit($facility->description, 100) }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center gap-2">
                                    {{-- Status Badge --}}
                                    @if($facility->is_active)
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

                            <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-100">
                                <div class="flex items-center gap-6">
                                    <div class="flex items-center gap-2 text-sm text-gray-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/>
                                        </svg>
                                        {{ __('scanit.facilities.stations_count', ['count' => $facility->stations_count]) }}
                                    </div>

                                    @if($facility->contact_email)
                                        <div class="flex items-center gap-2 text-sm text-gray-500">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                            </svg>
                                            {{ $facility->contact_email }}
                                        </div>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2">
                                    <a href="{{ route('stations.index', ['facility' => $facility->uuid]) }}" class="px-4 py-2 text-sm font-medium text-[#005151] hover:bg-[#005151]/5 rounded-lg transition-colors">
                                        {{ __('scanit.facilities.view_stations') }}
                                    </a>
                                    <a href="{{ route('facilities.edit', $facility) }}" class="p-2 text-gray-400 hover:text-[#005151] hover:bg-gray-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    <button wire:click="confirmDelete({{ $facility->id }})" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 text-center">
                        <p class="text-gray-500">{{ __('scanit.no_data') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($facilities->hasPages())
                <div class="mt-6">
                    {{ $facilities->links() }}
                </div>
            @endif
        @endif
    </div>

    {{-- Delete Modal --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50" wire:click.self="cancelDelete">
            <div class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __('scanit.facilities.delete') }}</h3>
                        <p class="text-sm text-gray-500">{{ $facilityToDelete?->name }}</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-6">{{ __('scanit.facilities.delete_confirm') }}</p>
                <div class="flex gap-3">
                    <button wire:click="cancelDelete" class="flex-1 px-4 py-2.5 border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        {{ __('scanit.actions.cancel') }}
                    </button>
                    <button wire:click="deleteFacility" class="flex-1 px-4 py-2.5 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                        {{ __('scanit.actions.delete') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
