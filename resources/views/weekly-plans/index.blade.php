@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.weekly_plans_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.weekly_plans_description') }}</p>
            </div>

            <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                {{ __('messages.weekly_plan_create') }}
            </a>
        </section>

        <section class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($weeklyPlans as $weeklyPlan)
                <div class="surface-card h-full p-6">
                    <div class="flex h-full flex-col gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-slate-900">{{ $weeklyPlan->title }}</h2>
                            <p class="mt-3 text-sm text-slate-600">
                                {{ __('messages.weekly_plan_week_start_date') }}:
                                <span class="font-medium text-slate-900">{{ $weeklyPlan->week_start_date?->format('Y-m-d') }}</span>
                            </p>
                            <p class="mt-2 text-sm text-slate-600">
                                {{ __('messages.weekly_plan_is_finalized') }}:
                                <span class="font-medium text-slate-900">
                                    {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                                </span>
                            </p>
                        </div>

                        <div class="mt-auto">
                            <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                                {{ __('messages.weekly_plan_open_planner') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full empty-state-card">
                    <div class="empty-state-icon">WP</div>
                    <h2 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_empty') }}</h2>
                    <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                        {{ __('messages.weekly_plans_description') }}
                    </p>
                    <div class="mt-5">
                        <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                            {{ __('messages.weekly_plan_create') }}
                        </a>
                    </div>
                </div>
            @endforelse
        </section>
    </div>
@endsection
