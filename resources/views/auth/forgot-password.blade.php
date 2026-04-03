<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ app()->getLocale() === 'zh_CN'
            ? '忘记密码也没关系。告诉我们你的邮箱地址，我们会发送一封重置密码邮件给你。'
            : 'Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.' }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="app()->getLocale() === 'zh_CN' ? '邮箱' : 'Email'" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex justify-end pt-2">
            <x-primary-button class="w-full sm:w-auto">
                {{ app()->getLocale() === 'zh_CN' ? '发送重置密码链接' : 'Email Password Reset Link' }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
