@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.1fr,0.9fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.plan_current_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.dashboard_plan_text') }}</p>
                </div>

                <div class="surface-card-soft p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.plan_target_calories') }}</h2>
                    <div class="mt-4 text-4xl font-semibold tracking-tight text-slate-900">{{ $plan->target_calories }}</div>
                    <p class="mt-2 text-sm leading-6 text-slate-600">
                        {{ __('messages.plan_goal') }}: {{ __('messages.goal_' . $plan->goal) }}
                    </p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="section-card">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.plan_bmr') }}</div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-green-700">{{ $plan->bmr }}</div>
            </div>

            <div class="section-card">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.plan_tdee') }}</div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-green-700">{{ $plan->tdee }}</div>
            </div>

            <div class="section-card">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.plan_target_calories') }}</div>
                <div class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $plan->target_calories }}</div>
            </div>

            <div class="section-card">
                <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.plan_goal') }}</div>
                <div class="mt-3 text-xl font-semibold tracking-tight text-slate-900">{{ __('messages.goal_' . $plan->goal) }}</div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-3">
            <div class="surface-card-soft p-6">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_protein') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $plan->protein_g }} g</p>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_carbs') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $plan->carbs_g }} g</p>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_fat') }}</h2>
                <p class="mt-3 text-3xl font-semibold tracking-tight text-slate-900">{{ $plan->fat_g }} g</p>
            </div>
        </section>

        <section class="section-card">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_regenerate_button') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                </div>

                <a href="{{ route('plans.create') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                    {{ __('messages.plan_regenerate_button') }}
                </a>
            </div>
        </section>
    </div>
@endsection
