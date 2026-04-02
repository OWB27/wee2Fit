<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h2 class="page-title mt-2">{{ __('Profile') }}</h2>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl page-stack py-2 sm:py-4">
        <div class="section-card">
            <div class="max-w-2xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="section-card">
            <div class="max-w-2xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="section-card">
            <div class="max-w-2xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
