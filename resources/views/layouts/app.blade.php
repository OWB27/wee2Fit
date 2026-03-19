<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? __('messages.app_name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200 text-base-content">
    <div class="navbar bg-base-100 shadow-sm">
        <div class="container mx-auto">
            <div class="flex-1">
                <a href="{{ route('home') }}" class="btn btn-ghost text-xl">
                    {{ __('messages.app_name') }}
                </a>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">
                    {{ __('messages.nav_home') }}
                </a>

                <a href="{{ route('methodology') }}" class="btn btn-ghost btn-sm">
                    {{ __('messages.nav_methodology') }}
                </a>

                <a href="{{ route('foods.index') }}" class="btn btn-ghost btn-sm">
                {{ __('messages.nav_food_library') }}
                </a>

                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_dashboard') }}
                    </a>

                    <a href="{{ route('my-profile.edit') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_my_profile') }}
                    </a>

                    <a href="{{ route('plans.create') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_generate_plan') }}
                    </a>

                    <a href="{{ route('plans.current') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_current_plan') }}
                    </a>

                    <a href="{{ route('progress.index') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_progress') }}
                    </a>

                    @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_admin') }}
                    </a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline btn-sm">
                            {{ __('messages.nav_logout') }}
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_login') }}
                    </a>

                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        {{ __('messages.nav_register') }}
                    </a>
                @endauth

                <div class="dropdown dropdown-end">
                    <label tabindex="0" class="btn btn-ghost btn-sm">
                        {{ __('messages.nav_language') }}
                    </label>

                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-40 p-2 shadow">
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
            </div>
        </div>
    </div>

    <main class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="alert alert-success mb-6">
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error mb-6">
        <span>{{ session('error') }}</span>
            </div>
        @endif
        
        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>
</html>