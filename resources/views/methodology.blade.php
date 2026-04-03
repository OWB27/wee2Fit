@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="public-hero">
            <div class="public-hero-grid">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.methodology_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.methodology_paragraph_1') }}</p>
                </div>

                <div class="public-soft-panel">
                    <div class="text-sm font-semibold uppercase tracking-[0.16em] text-emerald-700">{{ __('messages.plan_target_calories') }}</div>
                    <div class="mt-4 space-y-3 text-sm leading-7 text-slate-600">
                        <p>{{ __('messages.methodology_paragraph_2') }}</p>
                        <p class="rounded-2xl border border-white/80 bg-white/80 px-4 py-3 text-slate-700">
                            Mifflin-St Jeor = 10 x kg + 6.25 x cm - 5 x age + sex adjustment
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="public-feature-card">
                <div class="public-icon-badge">1</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.plan_bmr') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_1') }}</p>
            </div>

            <div class="public-feature-card">
                <div class="public-icon-badge bg-sky-100 text-sky-700">2</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.plan_tdee') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
            </div>

            <div class="public-feature-card">
                <div class="public-icon-badge bg-amber-100 text-amber-700">3</div>
                <h2 class="mt-5 text-lg font-semibold text-slate-900">{{ __('messages.plan_target_calories') }}</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="public-section-card">
                <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.methodology_title') }}</h2>
                <div class="mt-5 space-y-4 text-sm leading-7 text-slate-600">
                    <p>{{ __('messages.methodology_paragraph_1') }}</p>
                    <p>{{ __('messages.methodology_paragraph_2') }}</p>
                    <p>{{ __('messages.methodology_placeholder') }}</p>
                </div>
            </div>

            <div class="public-soft-panel">
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.plan_generate_title') }}</h2>
                    <p class="text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                    <div class="grid gap-3">
                        <div class="rounded-2xl border border-white/80 bg-white/80 p-4 text-sm text-slate-700">
                            {{ __('messages.profile_activity_level') }} / {{ __('messages.plan_tdee') }}
                        </div>
                        <div class="rounded-2xl border border-white/80 bg-white/80 p-4 text-sm text-slate-700">
                            {{ __('messages.profile_goal') }} + {{ __('messages.profile_intensity') }} / {{ __('messages.plan_target_calories') }}
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                            {{ __('messages.plan_generate_button') }}
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                            {{ __('messages.home_get_started') }}
                        </a>
                    @endauth
                </div>
            </div>
        </section>
    </div>
@endsection
