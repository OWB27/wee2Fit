<x-guest-layout>
    <div class="space-y-5">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('messages.nav_register') }}</h2>
            <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="name" :value="__('messages.auth_name_label')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('messages.auth_email_label')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('messages.auth_password_label')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('messages.auth_password_confirm_label')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
            <a class="text-link-ui-underline" href="{{ route('login') }}">
                {{ __('messages.auth_already_registered') }}
            </a>

            <x-primary-button class="w-full sm:w-auto">
                {{ __('messages.nav_register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
