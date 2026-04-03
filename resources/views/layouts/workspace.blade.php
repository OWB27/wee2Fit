<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="workspace-body">
    @php
        $user = auth()->user();
        $goal = $user?->profile?->goal;
        $navGroups = [
            [
                'label' => 'MAIN',
                'links' => [
                    ['route' => 'dashboard', 'label' => __('messages.nav_dashboard'), 'active' => 'dashboard'],
                    ['route' => 'plans.current', 'label' => __('messages.nav_current_plan'), 'active' => 'plans.current'],
                    ['route' => 'plans.create', 'label' => __('messages.nav_generate_plan'), 'active' => 'plans.create'],
                    ['route' => 'weekly-plans.index', 'label' => __('messages.nav_weekly_plans'), 'active' => 'weekly-plans.*'],
                ],
            ],
            [
                'label' => 'PROGRESS',
                'links' => [
                    ['route' => 'progress.index', 'label' => __('messages.nav_progress'), 'active' => 'progress.*'],
                    ['route' => 'my-profile.edit', 'label' => __('messages.nav_my_profile'), 'active' => 'my-profile.*'],
                ],
            ],
            [
                'label' => 'RESOURCES',
                'links' => [
                    ['route' => 'foods.index', 'label' => __('messages.nav_food_library'), 'active' => 'foods.*'],
                    ['route' => 'methodology', 'label' => __('messages.nav_methodology'), 'active' => 'methodology'],
                ],
            ],
        ];
    @endphp

    <div class="workspace-root">
        <div class="workspace-shell">
            <aside class="workspace-sidebar">
                <div class="workspace-sidebar-panel">
                    <a href="{{ route('home') }}" class="workspace-brand">
                        <span class="workspace-brand-mark">W</span>
                        <span>{{ __('messages.app_name') }}</span>
                    </a>

                    @foreach ($navGroups as $group)
                        <section>
                            <p class="workspace-section-label">{{ $group['label'] }}</p>
                            <nav class="workspace-nav mt-3">
                                @foreach ($group['links'] as $link)
                                    <a
                                        href="{{ route($link['route']) }}"
                                        class="workspace-nav-link {{ request()->routeIs($link['active']) ? 'workspace-nav-link-active' : 'workspace-nav-link-idle' }}"
                                    >
                                        <span class="inline-flex h-2 w-2 rounded-full {{ request()->routeIs($link['active']) ? 'bg-white/80' : 'bg-slate-300' }}"></span>
                                        <span>{{ $link['label'] }}</span>
                                    </a>
                                @endforeach
                            </nav>
                        </section>
                    @endforeach

                    <div class="workspace-goal-card">
                        <p class="workspace-section-label text-slate-500">CURRENT GOAL</p>
                        <div class="mt-3 text-xl font-semibold text-slate-900">
                            {{ $goal ? __('messages.goal_' . $goal) : __('messages.nav_my_profile') }}
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
                    <div class="workspace-topbar-shell">
                        <div class="workspace-search lg:min-w-[320px] lg:max-w-[420px] lg:flex-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z" />
                            </svg>
                            <span>Search foods, meals...</span>
                            <span class="ml-auto rounded-lg bg-slate-100 px-2 py-1 text-xs text-slate-400">/</span>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <div class="inline-flex rounded-full border border-slate-200 bg-white p-1 text-xs font-medium text-slate-500 shadow-sm">
                                <a href="{{ route('locale.switch', 'en') }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === 'en' ? 'bg-green-50 text-green-700' : '' }}">
                                    EN
                                </a>
                                <a href="{{ route('locale.switch', 'zh_CN') }}" class="rounded-full px-3 py-1 {{ app()->getLocale() === 'zh_CN' ? 'bg-green-50 text-green-700' : '' }}">
                                    中文
                                </a>
                            </div>

                            <div class="flex items-center gap-3 rounded-full border border-slate-200 bg-white px-2 py-1.5 shadow-sm">
                                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-sm font-semibold text-green-700">
                                    {{ strtoupper(substr($user->name ?? 'W', 0, 1)) }}
                                </span>
                                <div class="hidden pr-2 sm:block">
                                    <div class="text-sm font-semibold text-slate-900">{{ $user->name ?? __('messages.app_name') }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email ?? '' }}</div>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline btn-sm rounded-full border-slate-200 normal-case text-slate-700 hover:border-slate-300 hover:bg-slate-50">
                                    {{ __('messages.nav_logout') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </header>

                <main class="workspace-main-shell">
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
                </main>
            </div>
        </div>
    </div>
</body>
</html>
