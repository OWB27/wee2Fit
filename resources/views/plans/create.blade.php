@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-5xl page-stack">
        <section class="surface-card overflow-hidden">
            <div class="grid gap-8 p-6 sm:p-8 lg:grid-cols-[1.15fr,0.85fr] lg:p-10">
                <div>
                    <p class="page-kicker">{{ __('messages.app_name') }}</p>
                    <h1 class="page-title mt-3">{{ __('messages.plan_generate_title') }}</h1>
                    <p class="page-description mt-4">{{ __('messages.plan_generate_description') }}</p>
                </div>

                <div class="surface-card-soft p-6">
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">1</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.my_profile_description') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-sm font-semibold text-green-700 shadow-sm">2</span>
                            <div>
                                <h2 class="text-sm font-semibold text-slate-900">{{ __('messages.plan_generate_button') }}</h2>
                                <p class="mt-1 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_2') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-[1.2fr,0.8fr]">
            <div class="section-card">
                <div class="page-header">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.my_profile_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.plan_generate_description') }}</p>
                    </div>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_sex') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ __('messages.sex_' . $profile->sex) }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_birth_date') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ $profile->birth_date?->format('Y-m-d') }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_height_cm') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ $profile->height_cm }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_current_weight_kg') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ $profile->current_weight_kg }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_activity_level') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ __('messages.activity_' . $profile->activity_level) }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_goal') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ __('messages.goal_' . $profile->goal) }}</div>
                    </div>

                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2">
                        <div class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">{{ __('messages.profile_intensity') }}</div>
                        <div class="mt-2 text-base font-semibold text-slate-900">{{ __('messages.intensity_' . $profile->intensity) }}</div>
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.plan_generate_button') }}</h2>
                <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.methodology_paragraph_1') }}</p>

                <form action="{{ route('plans.store') }}" method="POST" class="mt-6 space-y-4">
                    @csrf

                    <div class="rounded-2xl border border-green-100 bg-green-50 p-5">
                        <div class="text-sm font-medium text-green-800">{{ __('messages.plan_current_title') }}</div>
                        <p class="mt-2 text-sm leading-6 text-slate-700">{{ __('messages.plan_generate_description') }}</p>
                    </div>

                    <button type="submit" class="btn btn-primary w-full rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.plan_generate_button') }}
                    </button>

                    <a href="{{ route('my-profile.edit') }}" class="btn btn-outline w-full rounded-full border-slate-200 px-5 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.nav_my_profile') }}
                    </a>
                </form>
            </div>
        </section>
    </div>
@endsection
