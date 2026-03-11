@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto">
        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h1 class="card-title text-3xl">{{ __('messages.plan_generate_title') }}</h1>
                <p class="text-base-content/70">
                    {{ __('messages.plan_generate_description') }}
                </p>

                @if (session('error'))
                    <div class="alert alert-error mt-4">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <div class="mt-6 grid gap-4 md:grid-cols-2">
                    <div>
                        <p><strong>{{ __('messages.profile_sex') }}:</strong> {{ __('messages.sex_' . $profile->sex) }}</p>
                        <p><strong>{{ __('messages.profile_birth_date') }}:</strong> {{ $profile->birth_date?->format('Y-m-d') }}</p>
                        <p><strong>{{ __('messages.profile_height_cm') }}:</strong> {{ $profile->height_cm }}</p>
                        <p><strong>{{ __('messages.profile_current_weight_kg') }}:</strong> {{ $profile->current_weight_kg }}</p>
                    </div>

                    <div>
                        <p><strong>{{ __('messages.profile_activity_level') }}:</strong> {{ __('messages.activity_' . $profile->activity_level) }}</p>
                        <p><strong>{{ __('messages.profile_goal') }}:</strong> {{ __('messages.goal_' . $profile->goal) }}</p>
                        <p><strong>{{ __('messages.profile_intensity') }}:</strong> {{ __('messages.intensity_' . $profile->intensity) }}</p>
                    </div>
                </div>

                <form action="{{ route('plans.store') }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.plan_generate_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection