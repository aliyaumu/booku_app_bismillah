<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white heading-font">Selamat Datang Kembali</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1.5 font-medium">Silakan masuk ke akun Booku Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="font-semibold text-slate-700 dark:text-slate-300" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
<div class="mt-5">
    <x-input-label for="password" :value="__('Password')" class="font-semibold text-slate-700 dark:text-slate-300" />

    <div class="relative mt-1">
        <x-text-input id="password" class="block w-full pr-10"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />

        <button
            type="button"
            onclick="togglePassword()"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors focus:outline-none"
            aria-label="Toggle password visibility"
        >
            <i id="password-icon" class="ti ti-eye text-xl"></i>
        </button>
    </div>

    <x-input-error :messages="$errors->get('password')" class="mt-2" />
</div>
        <!-- Remember Me -->
        <div class="flex items-center justify-between mt-5">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md dark:bg-slate-900 border-gray-300 dark:border-slate-700 text-amber-500 shadow-sm focus:ring-amber-500 dark:focus:ring-offset-slate-900" name="remember">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400 font-medium">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-semibold text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400 transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 rounded-md" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-8 text-center border-t border-slate-100 dark:border-slate-700/50 pt-6">
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-bold text-amber-600 hover:text-amber-500 dark:text-amber-500 dark:hover:text-amber-400 transition-colors ml-1">Daftar Anggota</a>
        </p>
    </div>
</x-guest-layout>
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('password-icon');
        const isHidden = input.type === 'password';

        input.type = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'ti ti-eye-off text-xl' : 'ti ti-eye text-xl';
    }
</script>