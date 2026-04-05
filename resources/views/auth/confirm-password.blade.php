<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ __('messages.auth_confirm_password_intro') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="password" :value="__('messages.auth_password_label')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button class="w-full sm:w-auto">
                {{ __('messages.auth_confirm_button') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
