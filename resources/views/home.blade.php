@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr,0.9fr] lg:p-10">
                <div class="space-y-5">
                    <div>
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
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="surface-card-soft p-5">
                        <h2 class="text-base font-semibold text-slate-900">{{ __('messages.dashboard_profile_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_profile_text') }}</p>
                    </div>

                    <div class="surface-card p-5">
                        <h2 class="text-base font-semibold text-slate-900">{{ __('messages.dashboard_plan_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                    </div>

                    <div class="surface-card p-5">
                        <h2 class="text-base font-semibold text-slate-900">{{ __('messages.dashboard_progress_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_progress_text') }}</p>
                    </div>

                    <div class="surface-card-soft p-5">
                        <h2 class="text-base font-semibold text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.methodology_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_1') }}</p>
                <div class="mt-5">
                    <a href="{{ route('methodology') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.home_learn_methodology') }}
                    </a>
                </div>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.food_library_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.food_library_description') }}</p>
                <div class="mt-5">
                    <a href="{{ route('foods.index') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.nav_food_library') }}
                    </a>
                </div>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                <div class="mt-5">
                    @auth
                        <a href="{{ route('weekly-plans.index') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.weekly_plan_open_planner') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.home_get_started') }}
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </div>
@endsection
