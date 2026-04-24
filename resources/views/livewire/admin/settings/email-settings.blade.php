<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ __('admin.settings.title') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('admin.settings.subtitle') }}</p>
            </div>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200">
        <nav class="flex gap-8">
            <button
                wire:click="setTab('email')"
                class="pb-4 px-1 text-sm font-medium border-b-2 transition
                    {{ $activeTab === 'email' ? 'border-[#005151] text-[#005151]' : 'border-transparent text-gray-500 hover:text-gray-700' }}"
            >
                {{ __('admin.settings.tab_email') }}
            </button>
        </nav>
    </div>

    @if($activeTab === 'email')
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-900">{{ __('admin.settings.welcome_email_title') }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ __('admin.settings.welcome_email_desc') }}</p>
            </div>

            <form wire:submit="save">
                <div class="space-y-6">
                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin.settings.subject') }} <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="subject"
                            wire:model="subject"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition"
                        />
                        @error('subject') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Body -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin.settings.body') }} <span class="text-red-500">*</span>
                        </label>
                        <p class="text-xs text-gray-500 mb-3">
                            {{ __('admin.settings.variables_hint') }}: <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#005151]">@{{name}}</code>,
                            <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#005151]">@{{email}}</code>,
                            <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#005151]">@{{customer_name}}</code>,
                            <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#005151]">@{{role}}</code>,
                            <code class="bg-gray-100 px-1.5 py-0.5 rounded text-[#005151]">@{{login_url}}</code>
                        </p>
                        <textarea
                            id="body"
                            wire:model="body"
                            rows="20"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#97d700] focus:ring-2 focus:ring-[#97d700]/20 transition font-mono text-sm"
                        ></textarea>
                        @error('body') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <button
                            type="button"
                            wire:click="resetToDefault"
                            wire:confirm="{{ __('admin.settings.confirm_reset') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition"
                        >
                            {{ __('admin.settings.reset_to_default') }}
                        </button>

                        <button
                            type="submit"
                            class="px-8 py-3 bg-[#97d700] hover:bg-[#85c200] text-[#005151] font-semibold rounded-xl transition"
                        >
                            {{ __('admin.settings.save_changes') }}
                        </button>
                    </div>
                </div>
            </form>

            <!-- Info box -->
            <div class="mt-8 p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600">
                    <strong>{{ __('admin.settings.sender') }}:</strong> {{ config('mail.from.address') }}<br>
                    <span class="text-xs text-gray-500">{{ __('admin.settings.sender_note') }}</span>
                </p>
            </div>
        </div>
    @endif
</div>
