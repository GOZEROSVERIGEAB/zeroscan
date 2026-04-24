<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-[#005151]">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="flex justify-center mb-8">
                <div class="flex items-center gap-3">
                    <img src="/images/prezero-logo.svg" alt="PreZero" class="h-12 brightness-0 invert">
                    <div>
                        <span class="text-2xl font-semibold text-white">Scan<span class="font-normal text-lg">it</span></span>
                        <span class="ml-2 px-2 py-0.5 text-xs bg-[#97d700] text-[#005151] rounded-full font-medium">Admin</span>
                    </div>
                </div>
            </div>

            {{-- Verify Card --}}
            <div class="bg-white shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">
                    {{ __('admin.auth.verify_title') }}
                </h1>
                <p class="text-center text-gray-600 mb-2">
                    {{ __('admin.auth.verify_subtitle') }}
                </p>
                <p class="text-center text-sm text-gray-500 mb-8">
                    {{ $user->email }}
                </p>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-[#97d700]/20 border border-[#97d700] rounded-lg">
                        <p class="text-sm text-[#005151]">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.otp.verify', ['user' => $user->id]) }}">
                    @csrf

                    <div class="mb-6">
                        <label for="otp" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin.auth.otp_label') }}
                        </label>
                        <input
                            type="text"
                            id="otp"
                            name="otp"
                            maxlength="6"
                            pattern="[0-9]{6}"
                            inputmode="numeric"
                            placeholder="{{ __('admin.auth.otp_placeholder') }}"
                            required
                            autofocus
                            autocomplete="one-time-code"
                            class="w-full px-4 py-4 text-2xl text-center font-mono tracking-[0.5em] border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#005151] focus:border-transparent transition"
                        />
                        <p class="mt-2 text-xs text-center text-gray-500">
                            {{ __('admin.auth.code_expires') }}
                        </p>
                    </div>

                    <button
                        type="submit"
                        class="w-full py-4 px-6 text-lg font-semibold text-[#005151] bg-[#97d700] hover:bg-[#85c200] focus:outline-none focus:ring-4 focus:ring-[#97d700]/50 rounded-xl transition duration-200 ease-in-out transform hover:scale-[1.02]"
                    >
                        {{ __('admin.auth.verify_button') }}
                    </button>
                </form>

                <div class="mt-6 flex flex-col space-y-3">
                    <form method="POST" action="{{ route('admin.otp.resend', ['user' => $user->id]) }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-[#005151] hover:text-[#005151]/80 font-medium transition">
                            {{ __('admin.auth.resend_code') }}
                        </button>
                    </form>

                    <a href="{{ route('admin.login') }}" class="text-center text-gray-500 hover:text-gray-700 text-sm transition">
                        {{ __('admin.auth.back_to_login') }}
                    </a>
                </div>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-center text-sm text-white/50">
                &copy; {{ date('Y') }} GoZero Sverige AB. {{ __('admin.auth.all_rights') }}
            </p>
        </div>
    </div>
</x-guest-layout>
