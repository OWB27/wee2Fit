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
                            <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                                {{ __('messages.nav_dashboard') }}
                            </a>
                            <a href="{{ route('plans.current') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                                {{ __('messages.plan_current_title') }}
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                                {{ __('messages.home_get_started') }}
                            </a>
                            <a href="{{ route('methodology') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                                {{ __('messages.home_learn_methodology') }}
                            </a>
                        @endauth
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="workspace-chip">{{ __('messages.my_profile_title') }}</span>
                        <span class="workspace-chip">{{ __('messages.plan_generate_title') }}</span>
                        <span class="workspace-chip">{{ __('messages.weekly_plans_title') }}</span>
                        <span class="workspace-chip">{{ __('messages.progress_title') }}</span>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="public-soft-panel sm:col-span-2">
                        <div class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">{{ __('messages.plan_target_calories') }}</div>
                        <div class="mt-3 text-4xl font-semibold tracking-tight text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '每日' : 'Daily' }}</div>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
                    </div>

                    <div class="public-stat-card">
                        <div class="text-sm text-slate-500">{{ __('messages.dashboard_profile_title') }}</div>
                        <div class="mt-3 text-2xl font-semibold text-slate-900">{{ __('messages.profile_goal') }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_profile_text') }}</p>
                    </div>

                    <div class="public-stat-card">
                        <div class="text-sm text-slate-500">{{ __('messages.dashboard_progress_title') }}</div>
                        <div class="mt-3 text-2xl font-semibold text-slate-900">{{ __('messages.progress_title') }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_progress_text') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="public-feature-card">
                <div class="public-icon-badge">01</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.my_profile_description') }}</p>
            </div>

            <div class="public-feature-card">
                <div class="public-icon-badge bg-sky-100 text-sky-700">02</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.plan_generate_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
            </div>

            <div class="public-feature-card">
                <div class="public-icon-badge bg-amber-100 text-amber-700">03</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="public-section-card">
                <p class="page-kicker">{{ __('messages.methodology_title') }}</p>
                <h2 class="mt-3 text-2xl font-semibold tracking-tight text-slate-900">{{ __('messages.plan_bmr') }} / {{ __('messages.plan_tdee') }} / {{ __('messages.plan_target_calories') }}</h2>
                <p class="mt-4 text-sm leading-7 text-slate-600">{{ __('messages.methodology_paragraph_1') }}</p>
                <p class="mt-3 text-sm leading-7 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
                <div class="mt-6">
                    <a href="{{ route('methodology') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.home_learn_methodology') }}
                    </a>
                </div>
            </div>

            <div class="public-soft-panel">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.food_library_title') }}</h2>
                    <p class="text-sm leading-6 text-slate-600">{{ __('messages.food_library_description') }}</p>
                    <div class="grid gap-3 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/80 bg-white/80 p-4">
                            <div class="text-sm font-medium text-slate-500">{{ __('messages.food_category_protein') }}</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ __('messages.plan_protein') }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/80 bg-white/80 p-4">
                            <div class="text-sm font-medium text-slate-500">{{ __('messages.food_category_carb') }}</div>
                            <div class="mt-2 text-lg font-semibold text-slate-900">{{ __('messages.plan_carbs') }}</div>
                        </div>
                    </div>
                    <a href="{{ route('foods.index') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.nav_food_library') }}
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
