<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ app()->getLocale() === 'zh_CN'
            ? '这是应用中的安全区域，请先确认你的密码再继续。'
            : 'This is a secure area of the application. Please confirm your password before continuing.' }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="app()->getLocale() === 'zh_CN' ? '密码' : 'Password'" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button class="w-full sm:w-auto">
                {{ app()->getLocale() === 'zh_CN' ? '确认' : 'Confirm' }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
