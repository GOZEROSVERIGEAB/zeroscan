<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center px-4 py-8 bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md">
            {{-- Logo --}}
            <div class="flex justify-center mb-8">
                <a href="/" class="flex items-center gap-3">
                    <img src="/images/prezero-logo.svg" alt="PreZero" class="h-12">
                    <span class="text-2xl font-semibold text-[#005151]">Scan<span class="font-normal text-lg">it</span></span>
                </a>
            </div>

            {{-- Login Card --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-2xl p-8">
                <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-2">
                    {{ __('scanit.auth.login_title') }}
                </h1>
                <p class="text-center text-gray-600 dark:text-gray-400 mb-8">
                    {{ __('scanit.auth.login_subtitle') }}
                </p>

                @if (session('status'))
                    <div class="mb-6 p-4 bg-lime-50 dark:bg-lime-900/20 border border-lime-200 dark:border-lime-800 rounded-lg">
                        <p class="text-sm text-lime-700 dark:text-lime-400">{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700 dark:text-red-400">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('otp.send') }}">
                    @csrf

                    <div class="mb-6">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            {{ __('scanit.auth.email_label') }}
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="{{ __('scanit.auth.email_placeholder') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full px-4 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-xl bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-lime-500 focus:border-transparent transition"
                        />
                    </div>

                    <button
                        type="submit"
                        class="w-full py-4 px-6 text-lg font-semibold text-white bg-lime-600 hover:bg-lime-700 focus:outline-none focus:ring-4 focus:ring-lime-300 dark:focus:ring-lime-800 rounded-xl transition duration-200 ease-in-out transform hover:scale-[1.02]"
                    >
                        {{ __('scanit.auth.send_code') }}
                    </button>
                </form>
            </div>

            {{-- Footer --}}
            <p class="mt-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; {{ date('Y') }} GoZero Sverige AB. Alla rättigheter förbehållna.
            </p>
        </div>
    </div>
</x-guest-layout>
