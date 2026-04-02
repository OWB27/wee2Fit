@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.2fr,0.8fr] lg:p-10">
                <div class="space-y-5">
                    <div>
                        <p class="page-kicker">{{ __('messages.app_name') }}</p>
                        <h1 class="page-title mt-3">{{ __('messages.dashboard_title') }}</h1>
                        <p class="page-description mt-4">
                            {{ __('messages.dashboard_welcome', ['name' => auth()->user()->name]) }}
                        </p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('my-profile.edit') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                            {{ __('messages.my_profile_title') }}
                        </a>
                        <a href="{{ route('plans.create') }}" class="btn btn-outline rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.plan_generate_button') }}
                        </a>
                    </div>
                </div>

                <div class="surface-card-soft p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">1</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.dashboard_profile_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_profile_text') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">2</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.dashboard_plan_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">3</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.dashboard_progress_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_progress_text') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="surface-card h-full p-6">
                <div class="flex h-full flex-col gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.dashboard_profile_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_profile_text') }}</p>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ route('my-profile.edit') }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="surface-card h-full p-6">
                <div class="flex h-full flex-col gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.dashboard_plan_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                    </div>

                    <div class="mt-auto flex flex-wrap gap-2">
                        <a href="{{ route('plans.current') }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                            {{ __('messages.open') }}
                        </a>
                        <a href="{{ route('plans.create') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.plan_regenerate_button') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="surface-card h-full p-6">
                <div class="flex h-full flex-col gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.dashboard_progress_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.dashboard_progress_text') }}</p>
                    </div>

                    <div class="mt-auto">
                        <a href="{{ route('progress.index') }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                            {{ __('messages.open') }}
                        </a>
                    </div>
                </div>
            </div>

            <div class="surface-card h-full p-6">
                <div class="flex h-full flex-col gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                    </div>

                    <div class="mt-auto flex flex-wrap gap-2">
                        <a href="{{ route('weekly-plans.index') }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                            {{ __('messages.open') }}
                        </a>
                        <a href="{{ route('weekly-plans.create') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                            {{ __('messages.weekly_plan_create') }}
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
