<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ __('messages.auth_verify_email_intro') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success rounded-2xl border border-green-200 bg-green-50 text-green-800">
            <span>{{ __('messages.auth_verify_email_resent') }}</span>
        </div>
    @endif

    <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="w-full sm:w-auto">
                    {{ __('messages.auth_resend_verification') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-link-ui-underline">
                {{ __('messages.nav_logout') }}
            </button>
        </form>
    </div>
</x-guest-layout>
