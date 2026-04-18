<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('messages.app_name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-mark.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="relative min-h-screen">
        <header x-data="{ mobileOpen: false }" class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="page-shell">
                <div class="site-topbar-shell">
                    <div class="flex min-w-0 flex-1 items-center gap-4">
                        <a href="{{ route('home') }}" class="workspace-brand">
                            <x-brand-logo />
                        </a>

                        <nav class="hidden xl:flex xl:flex-wrap xl:items-center xl:gap-2">
                            <a
                                href="{{ route('home') }}"
                                class="{{ request()->routeIs('home') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}"
                            >
                                {{ __('messages.nav_home') }}
                            </a>
                            <a
                                href="{{ route('methodology') }}"
                                class="{{ request()->routeIs('methodology') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}"
                            >
                                {{ __('messages.nav_methodology') }}
                            </a>
                            <a
                                href="{{ route('foods.index') }}"
                                class="{{ request()->routeIs('foods.*') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}"
                            >
                                {{ __('messages.nav_food_library') }}
                            </a>
                        </nav>
                    </div>

                    <div class="hidden items-center gap-3 xl:flex">
                        @auth
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn-ui-nav">
                                    {{ __('messages.nav_language') }}
                                </label>

                                <ul tabindex="0" class="menu dropdown-content z-[1] mt-2 w-40 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg">
                                    <li><a href="{{ route('locale.switch', 'en') }}">{{ __('messages.nav_english') }}</a></li>
                                    <li><a href="{{ route('locale.switch', 'zh_CN') }}">{{ __('messages.nav_chinese') }}</a></li>
                                </ul>
                            </div>

                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="topbar-user-card cursor-pointer transition hover:border-slate-300 hover:bg-slate-50">
                                    <span class="topbar-user-avatar">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                    </span>
                                    <div class="topbar-user-meta">
                                        <div class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? __('messages.app_name') }}</div>
                                        <div class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
                                    </div>
                                </label>

                                <div tabindex="0" class="dropdown-content z-[1] mt-2 w-64 rounded-3xl border border-slate-200 bg-white p-3 shadow-lg">
                                    <div class="mb-2 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                        {{ __('messages.ui_account') }}
                                    </div>
                                    <ul class="menu w-full gap-1 rounded-2xl p-0">
                                        <li>
                                            <a href="{{ route('dashboard') }}" class="rounded-2xl">
                                                {{ __('messages.ui_account') }}
                                            </a>
                                        </li>
                                        <li><a href="{{ route('my-profile.edit') }}" class="rounded-2xl">{{ __('messages.nav_my_profile') }}</a></li>
                                        <li><a href="{{ route('plans.current') }}" class="rounded-2xl">{{ __('messages.nav_plan') }}</a></li>
                                        <li><a href="{{ route('progress.index') }}" class="rounded-2xl">{{ __('messages.nav_progress') }}</a></li>
                                        <li><a href="{{ route('weekly-plans.index') }}" class="rounded-2xl">{{ __('messages.nav_weekly_plans') }}</a></li>
                                        @if (auth()->user()->role === 'admin')
                                            <li><a href="{{ route('admin.dashboard') }}" class="rounded-2xl">{{ __('messages.nav_admin') }}</a></li>
                                        @endif
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
                                <label tabindex="0" class="btn-ui-nav">
                                    {{ __('messages.nav_language') }}
                                </label>

                                <ul tabindex="0" class="menu dropdown-content z-[1] mt-2 w-40 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg">
                                    <li><a href="{{ route('locale.switch', 'en') }}">{{ __('messages.nav_english') }}</a></li>
                                    <li><a href="{{ route('locale.switch', 'zh_CN') }}">{{ __('messages.nav_chinese') }}</a></li>
                                </ul>
                            </div>

                            <a href="{{ route('login') }}" class="btn-ui btn-ui-sm btn-ui-ghost">
                                {{ __('messages.nav_login') }}
                            </a>

                            <a href="{{ route('register') }}" class="btn-ui btn-ui-sm btn-ui-primary">
                                {{ __('messages.nav_register') }}
                            </a>
                        @endauth
                    </div>

                    <div class="flex items-center gap-2 xl:hidden">
                        @auth
                            <div class="dropdown dropdown-end">
                                <label tabindex="0" class="btn-ui btn-ui-sm btn-ui-ghost p-1">
                                    <span class="topbar-user-avatar">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                    </span>
                                </label>

                                <div tabindex="0" class="dropdown-content z-[1] mt-2 w-72 rounded-3xl border border-slate-200 bg-white p-4 shadow-lg">
                                    <div class="topbar-user-card rounded-3xl">
                                        <span class="topbar-user-avatar">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                        </span>
                                        <div class="topbar-user-meta">
                                            <div class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? __('messages.app_name') }}</div>
                                            <div class="truncate text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
                                        </div>
                                    </div>

                                    <div class="mt-4 border-t border-slate-200 pt-4">
                                        <div class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            {{ __('messages.ui_account') }}
                                        </div>
                                        <div class="flex flex-col gap-2">
                                            <a href="{{ route('dashboard') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">
                                                {{ __('messages.ui_account') }}
                                            </a>
                                            <a href="{{ route('my-profile.edit') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_my_profile') }}</a>
                                            <a href="{{ route('plans.current') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_plan') }}</a>
                                            <a href="{{ route('progress.index') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_progress') }}</a>
                                            <a href="{{ route('weekly-plans.index') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_weekly_plans') }}</a>
                                            @if (auth()->user()->role === 'admin')
                                                <a href="{{ route('admin.dashboard') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_admin') }}</a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mt-4 border-t border-slate-200 pt-4">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn-ui btn-ui-sm btn-ui-ghost w-full justify-start rounded-2xl text-red-600 hover:text-red-600 hover:bg-red-50">
                                                {{ __('messages.nav_logout') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endauth

                        <button
                            type="button"
                            class="btn-ui btn-ui-sm btn-ui-ghost"
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
                        <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                {{ __('messages.ui_resources_section') }}
                            </div>
                            <div class="flex flex-col gap-2">
                                        <a href="{{ route('methodology') }}" class="{{ request()->routeIs('methodology') ? 'btn-ui btn-ui-ghost justify-start rounded-2xl px-4 btn-ui-nav-active' : 'btn-ui btn-ui-ghost justify-start rounded-2xl px-4' }}">
                                            {{ __('messages.nav_methodology') }}
                                        </a>
                                        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'btn-ui btn-ui-ghost justify-start rounded-2xl px-4 btn-ui-nav-active' : 'btn-ui btn-ui-ghost justify-start rounded-2xl px-4' }}">
                                            {{ __('messages.nav_food_library') }}
                                        </a>
                            </div>
                        </div>

                        <div class="rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
                            <div class="mb-3 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                {{ __('messages.nav_language') }}
                            </div>
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('locale.switch', 'en') }}" class="btn-ui btn-ui-sm btn-ui-secondary">
                                    {{ __('messages.nav_english') }}
                                </a>
                                <a href="{{ route('locale.switch', 'zh_CN') }}" class="btn-ui btn-ui-sm btn-ui-secondary">
                                    {{ __('messages.nav_chinese') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    @guest
                        <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-200 pt-4">
                            <a href="{{ route('login') }}" class="btn-ui btn-ui-sm btn-ui-ghost">
                                {{ __('messages.nav_login') }}
                            </a>
                            <a href="{{ route('register') }}" class="btn-ui btn-ui-sm btn-ui-primary">
                                {{ __('messages.nav_register') }}
                            </a>
                        </div>
                    @endguest
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
