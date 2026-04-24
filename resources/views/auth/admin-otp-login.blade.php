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

            {{-- Login Card --}}
            <div class="bg-white shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">
                    {{ __('admin.auth.login_title') }}
                </h1>
                <p class="text-center text-gray-600 mb-8">
                    {{ __('admin.auth.login_subtitle') }}
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

                <form method="POST" action="{{ route('admin.otp.send') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ __('admin.auth.email_label') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('admin.auth.email_placeholder') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 text-lg border border-gray-300 rounded-xl bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#005151] focus:border-transparent transition"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full py-4 px-6 text-lg font-semibold text-[#005151] bg-[#97d700] hover:bg-[#85c200] focus:outline-none focus:ring-4 focus:ring-[#97d700]/50 rounded-xl transition duration-200 ease-in-out transform hover:scale-[1.02]"
                    >
                        {{ __('admin.auth.send_code') }}
                    </button>
                </form>
            </div>

            {{-- Back Link --}}
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-white/70 hover:text-white text-sm transition">
                    {{ __('admin.auth.back_to_main') }}
                </a>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-center text-sm text-white/50">
                &copy; {{ date('Y') }} GoZero Sverige AB. {{ __('admin.auth.all_rights') }}
            </p>
        </div>
    </div>
</x-guest-layout>
