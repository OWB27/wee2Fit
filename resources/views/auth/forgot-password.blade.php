<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ __('messages.auth_forgot_password_intro') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" :value="__('messages.auth_email_label')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button class="w-full sm:w-auto">
                {{ __('messages.auth_send_reset_link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
