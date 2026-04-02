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
        $publicLinks = [
            ['route' => 'home', 'label' => __('messages.nav_home'), 'active' => 'home'],
            ['route' => 'methodology', 'label' => __('messages.nav_methodology'), 'active' => 'methodology'],
            ['route' => 'foods.index', 'label' => __('messages.nav_food_library'), 'active' => 'foods.*'],
        ];

        $userLinks = [];

        if (auth()->check()) {
            $userLinks = [
                ['route' => 'dashboard', 'label' => __('messages.nav_dashboard'), 'active' => 'dashboard'],
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
                <div class="flex h-16 items-center justify-between gap-4">
                    <div class="flex min-w-0 flex-1 items-center gap-4">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 rounded-full border border-green-100 bg-green-50 px-4 py-2 text-sm font-semibold text-green-800 transition hover:bg-green-100">
                            <span class="inline-flex h-2.5 w-2.5 rounded-full bg-green-600"></span>
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

                            @foreach ($userLinks as $link)
                                <a
                                    href="{{ route($link['route']) }}"
                                    class="btn btn-sm rounded-full border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                                >
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="hidden items-center gap-2 xl:flex">
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
                                        {{ __('messages.nav_chinese') }}
                                    </a>
                                </li>
                            </ul>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                                    {{ __('messages.nav_logout') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm rounded-full normal-case text-slate-700 hover:bg-slate-100">
                                {{ __('messages.nav_login') }}
                            </a>

                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm rounded-full border-0 normal-case shadow-sm">
                                {{ __('messages.nav_register') }}
                            </a>
                        @endauth
                    </div>

                    <button
                        type="button"
                        class="btn btn-ghost btn-sm rounded-full xl:hidden"
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

                <div x-cloak x-show="mobileOpen" x-transition.opacity class="border-t border-slate-200 py-4 xl:hidden">
                    <div class="flex flex-col gap-2">
                        @foreach ($publicLinks as $link)
                            <a
                                href="{{ route($link['route']) }}"
                                class="btn justify-start rounded-2xl border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-700 hover:bg-slate-100' }}"
                            >
                                {{ $link['label'] }}
                            </a>
                        @endforeach

                        @foreach ($userLinks as $link)
                            <a
                                href="{{ route($link['route']) }}"
                                class="btn justify-start rounded-2xl border-0 normal-case shadow-none {{ request()->routeIs($link['active']) ? 'bg-green-50 text-green-700 hover:bg-green-100' : 'btn-ghost text-slate-700 hover:bg-slate-100' }}"
                            >
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2 border-t border-slate-200 pt-4">
                        <a href="{{ route('locale.switch', 'en') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case">
                            {{ __('messages.nav_english') }}
                        </a>
                        <a href="{{ route('locale.switch', 'zh_CN') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case">
                            {{ __('messages.nav_chinese') }}
                        </a>

                        @auth
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case">
                                    {{ __('messages.nav_logout') }}
                                </button>
                            </form>
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
