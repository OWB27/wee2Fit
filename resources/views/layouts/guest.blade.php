<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('messages.app_name') }}</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo-mark.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="relative min-h-screen overflow-hidden">
        <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(220,252,231,0.9),transparent_24%),radial-gradient(circle_at_85%_20%,rgba(219,234,254,0.75),transparent_20%),linear-gradient(180deg,rgba(248,250,248,1)_0%,rgba(255,255,255,0.96)_100%)]"></div>

        <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="page-shell">
                <div class="site-topbar-shell">
                    <div class="flex min-w-0 flex-1 items-center gap-4">
                        <a href="{{ route('home') }}" class="workspace-brand">
                            <x-brand-logo />
                        </a>

                        <nav class="hidden md:flex md:flex-wrap md:items-center md:gap-2">
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}">
                                {{ __('messages.nav_home') }}
                            </a>
                            <a href="{{ route('methodology') }}" class="{{ request()->routeIs('methodology') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}">
                                {{ __('messages.nav_methodology') }}
                            </a>
                            <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}">
                                {{ __('messages.nav_food_library') }}
                            </a>
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="dropdown dropdown-end">
                            <label tabindex="0" class="btn-ui-nav">
                                {{ __('messages.nav_language') }}
                            </label>

                            <ul tabindex="0" class="menu dropdown-content z-[1] mt-2 w-40 rounded-2xl border border-slate-200 bg-white p-2 shadow-lg">
                                <li><a href="{{ route('locale.switch', 'en') }}">{{ __('messages.nav_english') }}</a></li>
                                <li><a href="{{ route('locale.switch', 'zh_CN') }}">{{ __('messages.nav_chinese') }}</a></li>
                            </ul>
                        </div>

                        @auth
                            <div class="topbar-user-card">
                                <span class="topbar-user-avatar">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                </span>
                                <div class="topbar-user-meta">
                                    <div class="truncate text-sm font-semibold text-slate-900">{{ auth()->user()->name ?? __('messages.app_name') }}</div>
                                    <div class="text-xs text-slate-500">{{ auth()->user()->email ?? '' }}</div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <div class="page-shell relative flex min-h-screen flex-col py-6 sm:py-8">
            <div class="flex flex-1 items-center py-10 sm:py-14">
                <div class="grid w-full gap-8 lg:grid-cols-[0.85fr,1.15fr] lg:items-center">
                    <div class="public-auth-panel">
                        <div class="mb-6 flex flex-wrap gap-2">
                            <a
                                href="{{ route('login') }}"
                                class="{{ request()->routeIs('login') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}"
                            >
                                {{ __('messages.nav_login') }}
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="{{ request()->routeIs('register') ? 'btn-ui-nav btn-ui-nav-active' : 'btn-ui-nav' }}"
                            >
                                {{ __('messages.nav_register') }}
                            </a>
                        </div>

                        <div class="space-y-6">
                            {{ $slot }}
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="overflow-hidden rounded-[2rem] border border-emerald-100/80 bg-white/85 p-7 shadow-sm backdrop-blur sm:p-8">
                            <div class="space-y-4">
                                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                                <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                                    {{ __('messages.home_title') }}
                                </h1>
                                <p class="max-w-xl text-base leading-7 text-slate-600 sm:text-lg">
                                    {{ __('messages.home_subtitle') }}
                                </p>
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/80 p-4 shadow-sm">
                                    <div class="inline-flex items-center rounded-2xl bg-gradient-to-br from-emerald-100 to-green-50 px-3 py-2 text-sm font-semibold text-emerald-700">01</div>
                                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.my_profile_description') }}</p>
                                </div>

                                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/80 p-4 shadow-sm">
                                    <div class="inline-flex items-center rounded-2xl bg-gradient-to-br from-sky-100 to-cyan-50 px-3 py-2 text-sm font-semibold text-sky-700">02</div>
                                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900">{{ __('messages.plan_generate_title') }}</h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                                </div>

                                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/80 p-4 shadow-sm">
                                    <div class="inline-flex items-center rounded-2xl bg-gradient-to-br from-amber-100 to-yellow-50 px-3 py-2 text-sm font-semibold text-amber-700">03</div>
                                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                                </div>

                                <div class="rounded-[1.5rem] border border-slate-200/80 bg-white/80 p-4 shadow-sm">
                                    <div class="inline-flex items-center rounded-2xl bg-gradient-to-br from-violet-100 to-fuchsia-50 px-3 py-2 text-sm font-semibold text-violet-700">04</div>
                                    <h2 class="mt-4 text-lg font-semibold tracking-tight text-slate-900">{{ __('messages.progress_title') }}</h2>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.progress_description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
