@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.admin_dashboard_title') }}</h1>
            <p class="text-base-content/70">{{ __('messages.admin_dashboard_description') }}</p>
        </div>

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">{{ __('messages.admin_foods_title') }}</h2>
                <p>{{ __('messages.admin_foods_description') }}</p>
                <div class="card-actions justify-end">
                    <a href="{{ route('admin.foods.index') }}" class="btn btn-primary">
                        {{ __('messages.admin_manage_foods') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection