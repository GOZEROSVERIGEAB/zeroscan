<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Miljödata Granskning</h1>
            <p class="text-gray-600">Objekt som saknar CO2-data och behöver manuell granskning</p>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        {{-- Blocked Sessions Section --}}
        @if ($blockedSessions->isNotEmpty())
            <div class="mb-8 bg-amber-50 border border-amber-200 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="h-6 w-6 text-amber-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <h2 class="text-lg font-semibold text-amber-800">Blockerade Rapporter</h2>
                </div>
                <p class="text-sm text-amber-700 mb-4">Följande sessioner har rapporter som väntar på att skickas. Korrigera CO2-data för alla objekt och klicka sedan på "Skicka rapport".</p>

                <div class="space-y-4">
                    @foreach ($blockedSessions as $session)
                        <div class="bg-white rounded-lg border {{ $session->can_send ? 'border-green-300' : 'border-amber-300' }} p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="font-medium text-gray-900">Session #{{ $session->id }}</span>
                                        @if ($session->can_send)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                Redo att skicka
                                            </span>
                                        @else
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                {{ $session->zero_co2_count }} objekt saknar CO2
                                            </span>
                                        @endif
                                    </div>
                                    <div class="mt-1 text-sm text-gray-500">
                                        <span>{{ $session->station?->name ?? 'Okänd station' }}</span>
                                        <span class="mx-1">·</span>
                                        <span>{{ $session->email }}</span>
                                        <span class="mx-1">·</span>
                                        <span>{{ $session->inventories->count() }} objekt</span>
                                        <span class="mx-1">·</span>
                                        <span>{{ $session->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                    @if ($session->report_blocked_reason)
                                        <div class="mt-1 text-xs text-gray-400">{{ $session->report_blocked_reason }}</div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    @if ($session->can_send)
                                        <button
                                            wire:click="sendBlockedReport({{ $session->id }})"
                                            wire:confirm="Vill du skicka miljörapporten till {{ $session->email }}?"
                                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                        >
                                            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            Skicka rapport
                                        </button>
                                    @else
                                        <span class="text-sm text-gray-400 italic">Korrigera CO2-data nedan först</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($inventories->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Allt ser bra ut!</h3>
                <p class="mt-1 text-gray-500">Inga objekt behöver granskning just nu.</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bild</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objekt</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">CO2</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Station</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                            <th class="px-4 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($inventories as $inventory)
                            <tr class="{{ $editing?->id === $inventory->id ? 'bg-yellow-50' : '' }}">
                                <td class="px-4 py-3">
                                    @if ($inventory->image_url)
                                        <img src="{{ $inventory->image_url }}" alt="" class="h-12 w-12 rounded object-cover">
                                    @else
                                        <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $inventory->name }}</div>
                                    <div class="text-xs text-gray-500">{{ Str::limit($inventory->description, 50) }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="text-sm text-gray-900">{{ $inventory->category }}</div>
                                    <div class="text-xs text-gray-500">{{ $inventory->subcategory }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $inventory->co2_savings ?? 0 }} kg
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $inventory->station?->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $inventory->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button wire:click="edit({{ $inventory->id }})" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                        Redigera
                                    </button>
                                </td>
                            </tr>

                            @if ($editing?->id === $inventory->id)
                                <tr class="bg-yellow-50">
                                    <td colspan="7" class="px-4 py-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            {{-- Option 1: Change category --}}
                                            <div class="bg-white p-4 rounded-lg border">
                                                <h4 class="font-medium text-gray-900 mb-3">Alternativ 1: Välj annan kategori</h4>
                                                <div class="space-y-3">
                                                    <select wire:model="newCategoryId" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                        <option value="">Välj kategori...</option>
                                                        @foreach ($categories as $cat)
                                                            <option value="{{ $cat->id }}">{{ $cat->name_sv }}</option>
                                                        @endforeach
                                                    </select>
                                                    <button wire:click="recalculate" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
                                                        Räkna om med vald kategori
                                                    </button>
                                                </div>
                                            </div>

                                            {{-- Option 2: Manual entry --}}
                                            <div class="bg-white p-4 rounded-lg border">
                                                <h4 class="font-medium text-gray-900 mb-3">Alternativ 2: Ange manuellt</h4>
                                                <div class="space-y-3">
                                                    <div>
                                                        <label class="block text-xs text-gray-600">CO2 (kg) *</label>
                                                        <input type="number" step="0.1" wire:model="co2" class="w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="ex. 15.5">
                                                        @error('co2') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="grid grid-cols-2 gap-2">
                                                        <div>
                                                            <label class="block text-xs text-gray-600">Vatten (liter)</label>
                                                            <input type="number" step="0.1" wire:model="water" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs text-gray-600">Energi (kWh)</label>
                                                            <input type="number" step="0.1" wire:model="energy" class="w-full rounded-md border-gray-300 shadow-sm text-sm">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-600">Anteckning</label>
                                                        <input type="text" wire:model="notes" class="w-full rounded-md border-gray-300 shadow-sm text-sm" placeholder="Valfri anteckning">
                                                    </div>
                                                    <button wire:click="saveManual" class="w-full bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700">
                                                        Spara manuell data
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mt-4 text-right">
                                            <button wire:click="cancel" class="text-gray-600 hover:text-gray-900 text-sm">
                                                Avbryt
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="mt-4 text-sm text-gray-500">
                Visar {{ $inventories->count() }} objekt (max 50)
            </p>
        @endif
    </div>
</div>
