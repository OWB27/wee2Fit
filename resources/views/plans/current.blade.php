@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.plan_current_title') }}</h1>

                @if (session('success'))
                    <div class="alert alert-success mt-4">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <div class="grid gap-4 md:grid-cols-2 mt-6">
                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.plan_bmr') }}</div>
                            <div class="stat-value text-primary">{{ $plan->bmr }}</div>
                        </div>
                    </div>

                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.plan_tdee') }}</div>
                            <div class="stat-value text-primary">{{ $plan->tdee }}</div>
                        </div>
                    </div>

                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.plan_target_calories') }}</div>
                            <div class="stat-value text-secondary">{{ $plan->target_calories }}</div>
                        </div>
                    </div>

                    <div class="stats shadow">
                        <div class="stat">
                            <div class="stat-title">{{ __('messages.plan_goal') }}</div>
                            <div class="stat-value text-sm">{{ __('messages.goal_' . $plan->goal) }}</div>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3 mt-6">
                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_protein') }}</h2>
                            <p class="text-2xl font-bold">{{ $plan->protein_g }} g</p>
                        </div>
                    </div>

                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_carbs') }}</h2>
                            <p class="text-2xl font-bold">{{ $plan->carbs_g }} g</p>
                        </div>
                    </div>

                    <div class="card bg-base-200">
                        <div class="card-body">
                            <h2 class="card-title">{{ __('messages.plan_fat') }}</h2>
                            <p class="text-2xl font-bold">{{ $plan->fat_g }} g</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('plans.create') }}" class="btn btn-outline">
                        {{ __('messages.plan_regenerate_button') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection