<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $user = auth()->user();
    @endphp

    <div class="relative min-h-screen overflow-hidden">
        <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/90 backdrop-blur">
            <div class="page-shell">
                <div class="site-topbar-shell">
                    <div class="flex min-w-0 flex-1 items-center gap-4">
                        <a href="{{ route('home') }}" class="workspace-brand">
                            <span class="workspace-brand-mark">W</span>
                            {{ __('messages.app_name') }}
                        </a>

                        <nav class="hidden md:flex md:flex-wrap md:items-center md:gap-2">
                            <a href="{{ route('home') }}" class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs('home') ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                {{ __('messages.nav_home') }}
                            </a>
                            <a href="{{ route('methodology') }}" class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs('methodology') ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                {{ __('messages.nav_methodology') }}
                            </a>
                            <a href="{{ route('foods.index') }}" class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs('foods.*') ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                                {{ __('messages.nav_food_library') }}
                            </a>
                        </nav>
                    </div>

                    <div class="flex items-center gap-3">
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

                        @auth
                            <div class="topbar-user-card">
                                <span class="topbar-user-avatar">
                                    {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                </span>
                                <div class="topbar-user-meta">
                                    <div class="truncate text-sm font-semibold text-slate-900">{{ $user->name ?? __('messages.app_name') }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email ?? '' }}</div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <div class="page-shell relative flex min-h-screen flex-col py-6 sm:py-8">

            <div class="flex flex-1 items-center py-10 sm:py-14">
                <div class="grid w-full gap-8 lg:grid-cols-[1.15fr,0.85fr] lg:items-center">
                    <div class="space-y-6">
                        <div class="inline-flex items-center rounded-full border border-green-100 bg-green-50 px-4 py-2 text-sm font-medium text-green-800 shadow-sm">
                            {{ __('messages.home_learn_methodology') }}
                        </div>

                        <div class="space-y-4">
                            <h1 class="text-4xl font-semibold tracking-tight text-slate-900 sm:text-5xl">
                                {{ __('messages.home_title') }}
                            </h1>
                            <p class="max-w-xl text-base leading-7 text-slate-600 sm:text-lg">
                                {{ __('messages.home_subtitle') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <span class="public-auth-stat">
                                {{ __('messages.my_profile_title') }}
                            </span>
                            <span class="public-auth-stat">
                                {{ __('messages.plan_current_title') }}
                            </span>
                            <span class="public-auth-stat">
                                {{ __('messages.progress_title') }}
                            </span>
                            <span class="public-auth-stat">
                                {{ __('messages.weekly_plans_title') }}
                            </span>
                        </div>
                    </div>

                    <div class="public-auth-panel">
                        <div class="mb-6 flex flex-wrap gap-2">
                            <a
                                href="{{ route('login') }}"
                                class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs('login') ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                            >
                                {{ __('messages.nav_login') }}
                            </a>
                            <a
                                href="{{ route('register') }}"
                                class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs('register') ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                            >
                                {{ __('messages.nav_register') }}
                            </a>
                        </div>

                        <div class="space-y-6">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
