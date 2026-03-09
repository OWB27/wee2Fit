@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.dashboard_title') }}</h1>
            <p class="text-base-content/70 mt-2">
                {{ __('messages.dashboard_welcome', ['name' => auth()->user()->name]) }}
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_profile_title') }}</h2>
                    <p>{{ __('messages.dashboard_profile_text') }}</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_plan_title') }}</h2>
                    <p>{{ __('messages.dashboard_plan_text') }}</p>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.dashboard_progress_title') }}</h2>
                    <p>{{ __('messages.dashboard_progress_text') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection