<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('messages.nav_login') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.home_subtitle') }}</p>
        </div>

        <x-auth-session-status class="rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800" :status="session('status')" />

        @if (session('error'))
            <div class="alert alert-error rounded-2xl border border-red-200 bg-red-50 text-red-800">
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-600">
            <input id="remember_me" type="checkbox" class="checkbox checkbox-sm checkbox-primary rounded-md" name="remember">
            <span>{{ __('Remember me') }}</span>
        </label>

        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-green-700 underline underline-offset-4 transition hover:text-green-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
