@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">{{ __('messages.weekly_plans_title') }}</h1>
                <p class="text-base-content/70">{{ __('messages.weekly_plans_description') }}</p>
            </div>

            <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary">
                {{ __('messages.weekly_plan_create') }}
            </a>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($weeklyPlans as $weeklyPlan)
                <div class="card bg-base-100 shadow">
                    <div class="card-body">
                        <h2 class="card-title">{{ $weeklyPlan->title }}</h2>
                        <p>{{ __('messages.weekly_plan_week_start_date') }}: {{ $weeklyPlan->week_start_date?->format('Y-m-d') }}</p>
                        <p>
                            {{ __('messages.weekly_plan_is_finalized') }}:
                            {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                        </p>

                        <div class="card-actions justify-end">
                            <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn btn-primary btn-sm">
                                {{ __('messages.weekly_plan_open_planner') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p>{{ __('messages.weekly_plan_empty') }}</p>
            @endforelse
        </div>
    </div>
@endsection