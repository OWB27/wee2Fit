@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-6 p-6 sm:p-8 lg:grid-cols-[1.15fr,0.85fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.methodology_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.methodology_paragraph_1') }}</p>
                </div>

                <div class="surface-card-soft p-6">
                    <h2 class="text-sm font-semibold uppercase tracking-[0.2em] text-green-700">{{ __('messages.plan_target_calories') }}</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-700">{{ __('messages.methodology_paragraph_2') }}</p>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2">
            <div class="section-card">
                <div class="flex items-start gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-50 text-sm font-semibold text-green-700">1</span>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_bmr') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_1') }}</p>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <div class="flex items-start gap-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-50 text-sm font-semibold text-green-700">2</span>
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.plan_tdee') }} / {{ __('messages.plan_target_calories') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="surface-card-soft p-6 sm:p-8">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.methodology_title') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-700">{{ __('messages.methodology_placeholder') }}</p>
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
        </section>
    </div>
@endsection
