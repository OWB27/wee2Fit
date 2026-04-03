<x-guest-layout>
    <div class="text-sm leading-6 text-slate-600">
        {{ app()->getLocale() === 'zh_CN'
            ? '感谢注册。在开始之前，请先点击我们刚刚发送到你邮箱中的链接完成邮箱验证。如果你没有收到邮件，我们可以重新发送。'
            : 'Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.' }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success rounded-2xl border border-green-200 bg-green-50 text-green-800">
            <span>{{ app()->getLocale() === 'zh_CN' ? '新的验证链接已经发送到你注册时填写的邮箱。' : 'A new verification link has been sent to the email address you provided during registration.' }}</span>
        </div>
    @endif

    <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button class="w-full sm:w-auto">
                    {{ app()->getLocale() === 'zh_CN' ? '重新发送验证邮件' : 'Resend Verification Email' }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="text-sm font-medium text-green-700 underline underline-offset-4 transition hover:text-green-800">
                {{ app()->getLocale() === 'zh_CN' ? '退出登录' : 'Log Out' }}
            </button>
        </form>
    </div>
</x-guest-layout>
