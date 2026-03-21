@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.dashboard_title') }}</h1>
            <p class="text-base-content/70 mt-2">
                {{ __('messages.dashboard_welcome', ['name' => auth()->user()->name]) }}
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_profile_title') }}</h2>
                    <p>{{ __('messages.dashboard_profile_text') }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('my-profile.edit') }}" class="btn btn-primary btn-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_plan_title') }}</h2>
                    <p>{{ __('messages.dashboard_plan_text') }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('plans.current') }}" class="btn btn-primary btn-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_progress_title') }}</h2>
                    <p>{{ __('messages.dashboard_progress_text') }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('progress.index') }}" class="btn btn-primary btn-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.weekly_plans_title') }}</h2>
                    <p>{{ __('messages.weekly_plans_description') }}</p>
                    <div class="card-actions justify-end">
                        <a href="{{ route('weekly-plans.index') }}" class="btn btn-primary btn-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection