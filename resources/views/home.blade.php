@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid">
                <div class="space-y-6">
                    <div class="space-y-4">
                        <p class="page-kicker">{{ __('messages.app_name') }}</p>
                        <h1 class="page-title mt-3">{{ __('messages.home_title') }}</h1>
                        <p class="page-description mt-4">{{ __('messages.home_subtitle') }}</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn-ui btn-ui-md btn-ui-primary">
                                {{ __('messages.nav_dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-ui btn-ui-md btn-ui-primary">
                                {{ __('messages.home_get_started') }}
                            </a>
                        @endauth
                    </div>

                </div>

            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="home-quick-card">
                <div class="public-icon-badge">01</div>
                <h2 class="mt-4 text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.my_profile_description') }}</p>
            </div>

            <div class="home-quick-card">
                <div class="public-icon-badge bg-sky-100 text-sky-700">02</div>
                <h2 class="mt-4 text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.plan_generate_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
            </div>

            <div class="home-quick-card">
                <div class="public-icon-badge bg-amber-100 text-amber-700">03</div>
                <h2 class="mt-4 text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
            </div>

            <div class="home-quick-card">
                <div class="public-icon-badge bg-cyan-100 text-cyan-700">04</div>
                <h2 class="mt-4 text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.progress_title') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.progress_description') }}</p>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="home-link-card">
                <p class="page-kicker">{{ __('messages.methodology_title') }}</p>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">
                    {{ __('messages.plan_bmr') }} / {{ __('messages.plan_tdee') }} / {{ __('messages.plan_target_calories') }}
                </h2>
                <p class="mt-4 max-w-2xl text-sm leading-7 text-slate-600">
                    {{ __('messages.home_methodology_card_description') }}
                </p>
                <div class="mt-6">
                    <a href="{{ route('methodology') }}" class="btn-ui btn-ui-md btn-ui-primary">
                        {{ __('messages.home_learn_methodology') }}
                    </a>
                </div>
            </div>

            <div class="home-link-card bg-emerald-50/70 border-emerald-100">
                <div class="space-y-4">
                    <p class="page-kicker">{{ __('messages.food_library_title') }}</p>
                    <h2 class="text-2xl font-semibold tracking-tight text-slate-900">{{ __('messages.food_library_title') }}</h2>
                    <p class="max-w-xl text-sm leading-7 text-slate-600">
                        {{ __('messages.home_food_library_card_description') }}
                    </p>
                    <a href="{{ route('foods.index') }}" class="btn-ui btn-ui-md btn-ui-primary">
                        {{ __('messages.nav_food_library') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
