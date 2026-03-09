@extends('layouts.app')

@section('content')
    <div class="hero bg-base-100 rounded-box shadow">
        <div class="hero-content text-center py-16">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-bold">{{ __('messages.home_title') }}</h1>

                <p class="py-6 text-base-content/80">
                    {{ __('messages.home_subtitle') }}
                </p>

                <div class="flex justify-center gap-3">
                    <a href="{{ route('register') }}" class="btn btn-primary">
                        {{ __('messages.home_get_started') }}
                    </a>

                    <a href="{{ route('methodology') }}" class="btn btn-outline">
                        {{ __('messages.home_learn_methodology') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection