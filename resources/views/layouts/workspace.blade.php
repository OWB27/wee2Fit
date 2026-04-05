<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="workspace-body">
    <div x-data="{ mobileOpen: false }" class="workspace-root">
        <div class="workspace-shell">
            <aside class="workspace-sidebar hidden lg:block">
                <div class="workspace-sidebar-panel">
                    <a href="{{ route('home') }}" class="workspace-brand">
                        <span class="workspace-brand-mark">W</span>
                        <span>{{ __('messages.app_name') }}</span>
                    </a>

                    <section>
                        <p class="workspace-section-label">{{ __('messages.ui_main_section') }}</p>
                        <nav class="workspace-nav mt-3">
                            <a href="{{ route('dashboard') }}" class="workspace-nav-link {{ request()->routeIs('dashboard') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('dashboard') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_dashboard') }}</span>
                            </a>
                            <a href="{{ route('plans.current') }}" class="workspace-nav-link {{ request()->routeIs('plans.current') || request()->routeIs('plans.create') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('plans.current') || request()->routeIs('plans.create') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_plan') }}</span>
                            </a>
                            <a href="{{ route('weekly-plans.index') }}" class="workspace-nav-link {{ request()->routeIs('weekly-plans.*') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('weekly-plans.*') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_weekly_plans') }}</span>
                            </a>
                        </nav>
                    </section>

                    <section>
                        <p class="workspace-section-label">{{ __('messages.nav_progress') }}</p>
                        <nav class="workspace-nav mt-3">
                            <a href="{{ route('progress.index') }}" class="workspace-nav-link {{ request()->routeIs('progress.*') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('progress.*') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_progress') }}</span>
                            </a>
                            <a href="{{ route('my-profile.edit') }}" class="workspace-nav-link {{ request()->routeIs('my-profile.*') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('my-profile.*') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_my_profile') }}</span>
                            </a>
                        </nav>
                    </section>

                    <section>
                        <p class="workspace-section-label">{{ __('messages.ui_resources_section') }}</p>
                        <nav class="workspace-nav mt-3">
                            <a href="{{ route('methodology') }}" class="workspace-nav-link {{ request()->routeIs('methodology') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('methodology') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_methodology') }}</span>
                            </a>
                            <a href="{{ route('foods.index') }}" class="workspace-nav-link {{ request()->routeIs('foods.*') ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}">
                                <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs('foods.*') ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                <span>{{ __('messages.nav_food_library') }}</span>
                            </a>
                        </nav>
                    </section>

                    <div class="workspace-goal-card">
                        <p class="workspace-section-label text-slate-500">{{ __('messages.ui_current_goal') }}</p>
                        <div class="mt-3 text-xl font-semibold text-slate-900">
                            {{ auth()->user()->profile?->goal ? __('messages.goal_' . auth()->user()->profile->goal) : __('messages.nav_my_profile') }}
                        </div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">
                            {{ __('messages.dashboard_plan_text') }}
                        </p>
                        <div class="workspace-progress-track">
                            <div class="workspace-progress-fill w-2/3"></div>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="workspace-main">
                <header class="workspace-topbar">
                    <div class="page-shell">
                        <div class="workspace-topbar-shell">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('home') }}" class="workspace-brand lg:hidden">
                                    <span class="workspace-brand-mark">W</span>
                                    <span>{{ __('messages.app_name') }}</span>
                                </a>
                            </div>

                            <div class="hidden flex-wrap items-center gap-3 lg:flex">
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

                                    <div tabindex="0" class="dropdown-content z-[90] mt-2 w-64 rounded-3xl border border-slate-200 bg-white p-3 shadow-lg">
                                        <div class="mb-2 px-3 py-2 text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">
                                            {{ __('messages.ui_account') }}
                                        </div>
                                        <ul class="menu w-full gap-1 rounded-2xl p-0">
                                            <li><a href="{{ route('dashboard') }}" class="rounded-2xl">{{ __('messages.nav_dashboard') }}</a></li>
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
                            </div>

                            <div class="ml-auto flex items-center gap-2 lg:hidden">
                                <div class="dropdown dropdown-end">
                                    <label tabindex="0" class="btn-ui btn-ui-sm btn-ui-ghost p-1">
                                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-sm font-semibold text-green-700">
                                            {{ strtoupper(substr(auth()->user()->name ?? 'W', 0, 1)) }}
                                        </span>
                                    </label>

                                    <div tabindex="0" class="dropdown-content z-[90] mt-2 w-72 rounded-3xl border border-slate-200 bg-white p-4 shadow-lg">
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
                                                <a href="{{ route('dashboard') }}" class="btn-ui btn-ui-ghost justify-start rounded-2xl px-4">{{ __('messages.nav_dashboard') }}</a>
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

                                <button
                                    type="button"
                                    class="btn-ui btn-ui-sm btn-ui-ghost"
                                    @click="mobileOpen = !mobileOpen"
                                    :aria-expanded="mobileOpen.toString()"
                                    aria-label="Toggle workspace navigation"
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
                    </div>

                    <div x-cloak x-show="mobileOpen" x-transition.opacity class="border-t border-slate-200 py-4 lg:hidden">
                        <div class="page-shell">
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
                        </div>
                    </div>
                </header>

                <main class="workspace-main-shell">
                    <div class="page-shell">
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

                        @yield('content')
                    </div>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
