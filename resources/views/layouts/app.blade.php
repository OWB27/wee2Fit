<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $user = auth()->user();
        $publicLinks = [
            ['route' => 'home', 'label' => __('messages.nav_home'), 'active' => 'home'],
            ['route' => 'methodology', 'label' => __('messages.nav_methodology'), 'active' => 'methodology'],
            ['route' => 'foods.index', 'label' => __('messages.nav_food_library'), 'active' => 'foods.*'],
        ];
        $mobilePublicGroups = [
            [
                'label' => app()->getLocale() === 'zh_CN' ? json_decode('"\u8d44\u6e90"') : 'Resources',
                'links' => [
                    ['route' => 'methodology', 'label' => __('messages.nav_methodology'), 'active' => 'methodology'],
                    ['route' => 'foods.index', 'label' => __('messages.nav_food_library'), 'active' => 'foods.*'],
                ],
            ],
        ];

        $userLinks = [];
        $accountLabel = app()->getLocale() === 'zh_CN' ? json_decode('"\u4e2a\u4eba\u4e2d\u5fc3"') : 'Account';

        if (auth()->check()) {
            $userLinks = [
                ['route' => 'my-profile.edit', 'label' => __('messages.nav_my_profile'), 'active' => 'my-profile.*'],
                ['route' => 'plans.create', 'label' => __('messages.nav_generate_plan'), 'active' => 'plans.create'],
                ['route' => 'plans.current', 'label' => __('messages.nav_current_plan'), 'active' => 'plans.current'],
                ['route' => 'progress.index', 'label' => __('messages.nav_progress'), 'active' => 'progress.*'],
                ['route' => 'weekly-plans.index', 'label' => __('messages.nav_weekly_plans'), 'active' => 'weekly-plans.*'],
            ];

            if (auth()->user()->role === 'admin') {
                $userLinks[] = ['route' => 'admin.dashboard', 'label' => __('messages.nav_admin'), 'active' => 'admin.*'];
            }
        }
    @endphp

    <div class="relative min-h-screen">
        <header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="page-shell">
                <div class="site-topbar-shell">
                    <div class="flex min-w-0 flex-1 items-center gap-4">
                        <a href="{{ route('home') }}" class="workspace-brand">
                            <span class="workspace-brand-mark">W</span>
                            {{ __('messages.app_name') }}
                        </a>

                        <nav class="hidden xl:flex xl:flex-wrap xl:items-center xl:gap-2">
                            @foreach ($publicLinks as $link)
                                <a
                                    href="{{ route($link['route']) }}"
                                    class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                                >
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="hidden items-center gap-3 xl:flex">
                        @auth
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-sm rounded-full normal-case text-slate-600 hover:bg-slate-100">
                                    {{ __('messages.nav_language') }}
                                </label>

                                <ul tabindex="0" class="menu dropdown-content z-[1] mt-2 w-40 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg">
                                    <li>
                                        <a href="{{ route('locale.switch', 'en') }}">
                                            {{ __('messages.nav_english') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('locale.switch', 'zh_CN') }}">
                                            {{ json_decode('"\u4e2d\u6587"') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="topbar-user-card cursor-pointer transition hover:border-slate-300 hover:bg-slate-50">
                                    <span class="topbar-user-avatar">
                                        {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                    </span>
                                    <div class="topbar-user-meta">
                                        <div class="truncate text-sm font-semibold text-slate-900">{{ $user->name ?? __('messages.app_name') }}</div>
                                        <div class="text-xs text-slate-500">{{ $user->email ?? '' }}</div>
                                    </div>
                                </label>

                                <div tabindex="0" class="dropdown-content z-[1] mt-2 w-64 rounded-3xl border border-slate-200 bg-white p-3 shadow-lg">
                                    <div class="mb-2 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                        {{ $accountLabel }}
                                    </div>
                                    <ul class="menu w-full gap-1 rounded-2xl p-0">
                                        <li>
                                            <a href="{{ route('dashboard') }}" class="rounded-2xl bg-green-50 font-medium text-green-700 hover:bg-green-100">
                                                {{ $accountLabel }}
                                            </a>
                                        </li>
                                        @foreach ($userLinks as $link)
                                            <li>
                                                <a href="{{ route($link['route']) }}" class="rounded-2xl">
                                                    {{ $link['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                        <li class="mt-1 border-t border-slate-200 pt-1">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full rounded-2xl px-4 py-2 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">
                                                    {{ __('messages.nav_logout') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-sm rounded-full normal-case text-slate-600 hover:bg-slate-100">
                                    {{ __('messages.nav_language') }}
                                </label>

                                <ul tabindex="0" class="menu dropdown-content z-[1] mt-2 w-40 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg">
                                    <li>
                                        <a href="{{ route('locale.switch', 'en') }}">
                                            {{ __('messages.nav_english') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('locale.switch', 'zh_CN') }}">
                                            {{ json_decode('"\u4e2d\u6587"') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-full normal-case text-slate-700 hover:bg-slate-100">
                                {{ __('messages.nav_login') }}
                            </a>

                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-full border-0 normal-case shadow-sm">
                                {{ __('messages.nav_register') }}
                            </a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-2 xl:hidden">
                        @auth
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn btn-ghost btn-sm rounded-full p-1 text-slate-700 hover:bg-slate-100">
                                    <span class="topbar-user-avatar">
                                        {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                    </span>
                                </label>

                                <div tabindex="0" class="dropdown-content z-[1] mt-2 w-72 rounded-3xl border border-slate-200 bg-white p-4 shadow-lg">
                                    <div class="topbar-user-card rounded-3xl">
                                        <span class="topbar-user-avatar">
                                            {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                        </span>
                                        <div class="topbar-user-meta">
                                            <div class="truncate text-sm font-semibold text-slate-900">{{ $user->name ?? __('messages.app_name') }}</div>
                                            <div class="truncate text-xs text-slate-500">{{ $user->email ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="mt-4 border-t border-slate-200 pt-4">
                                        <div class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            {{ $accountLabel }}
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <a
                                                href="{{ route('dashboard') }}"
                                                class="btn justify-start rounded-2xl border-0 bg-green-50 normal-case text-green-700 shadow-none hover:bg-green-100"
                                            >
                                                {{ $accountLabel }}
                                            </a>
                                            @foreach ($userLinks as $link)
                                                <a
                                                    href="{{ route($link['route']) }}"
                                                    class="btn justify-start rounded-2xl border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-700 hover:bg-slate-100' }}"
                                                >
                                                    {{ $link['label'] }}
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="mt-4 border-t border-slate-200 pt-4">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-ghost btn-sm w-full justify-start rounded-2xl normal-case text-red-600 hover:bg-red-50">
                                                {{ __('messages.nav_logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <button
                            type="button"
                            class="btn btn-ghost btn-sm rounded-full"
                            @click="mobileOpen = !mobileOpen"
                            :aria-expanded="mobileOpen.toString()"
                            aria-label="Toggle navigation"
                        >
                            <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 7h16M4 12h16M4 17h16" />
                            </svg>
                            <svg x-cloak x-show="mobileOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 6l12 12M18 6L6 18" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div x-cloak x-show="mobileOpen" x-transition.opacity class="border-t border-slate-200 py-4 xl:hidden">
                    <div class="space-y-4">
                        @foreach ($mobilePublicGroups as $group)
                            <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                                <div class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                    {{ $group['label'] }}
                                </div>
                                <div class="flex flex-col gap-2">
                                    @foreach ($group['links'] as $link)
                                        <a
                                            href="{{ route($link['route']) }}"
                                            class="btn justify-start rounded-2xl border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-700 hover:bg-slate-100' }}"
                                        >
                                            {{ $link['label'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                {{ __('messages.nav_language') }}
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('locale.switch', 'en') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case">
                                    {{ __('messages.nav_english') }}
                                </a>
                                <a href="{{ route('locale.switch', 'zh_CN') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case">
                                    {{ json_decode('"\u4e2d\u6587"') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-200 pt-4">
                        @auth
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-full normal-case">
                                {{ __('messages.nav_login') }}
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-full border-0 normal-case">
                                {{ __('messages.nav_register') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        @isset($header)
            <section class="border-b border-slate-200/80 bg-white/70">
                <div class="page-shell py-6">
                    {{ $header }}
                </div>
            </section>
        @endisset

        <main class="page-shell py-8 sm:py-10">
            @if (session('success'))
                <div class="alert alert-success mb-6 rounded-2xl border border-green-200 bg-green-50 text-green-800">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-error mb-6 rounded-2xl border border-red-200 bg-red-50 text-red-800">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>
</body>
</html>
