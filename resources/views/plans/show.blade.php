@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section>
            <div class="workspace-page-header">
                <div>
                    <h1 class="workspace-page-title">{{ __('messages.nav_plan') }}</h1>
                    <p class="workspace-page-description">
                        {{ $plan ? __('messages.plans_current_active_description') : __('messages.plan_page_empty_description') }}
                    </p>
                </div>

                <div class="header-actions">
                    <form action="{{ route('plans.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-ui btn-ui-md btn-ui-primary">
                            {{ $plan ? __('messages.plan_regenerate_button') : __('messages.plan_generate_button') }}
                        </button>
                    </form>
                </div>
            </div>
        </section>

        @if ($plan)
            <section class="workspace-soft-card">
                <div class="section-header-end">
                    <div>
                        <div class="workspace-chip">{{ __('messages.plan_goal') }}: {{ __('messages.goal_' . $plan->goal) }}</div>
                        <div class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plan_generated_success') }}</div>
                    </div>

                    <div class="meta-text">
                        {{ __('messages.profile_activity_level') }}: {{ __('messages.activity_' . $plan->activity_level) }}
                    </div>
                </div>
            </section>

            <section class="layout-stat-grid">
                <div class="workspace-stat-card">
                    <div class="workspace-stat-label">{{ __('messages.plan_bmr') }}</div>
                    <div class="workspace-stat-value">{{ $plan->bmr }}</div>
                    <p class="stat-card-note">{{ __('messages.plans_current_bmr_hint') }}</p>
                </div>

                <div class="workspace-stat-card">
                    <div class="workspace-stat-label">{{ __('messages.plan_tdee') }}</div>
                    <div class="workspace-stat-value">{{ $plan->tdee }}</div>
                    <p class="stat-card-note">{{ __('messages.plans_current_tdee_hint') }}</p>
                </div>

                <div class="workspace-soft-card">
                    <div class="workspace-stat-label">{{ __('messages.plan_target_calories') }}</div>
                    <div class="workspace-stat-value text-green-700">{{ $plan->target_calories }}</div>
                    <p class="stat-card-note">{{ __('messages.intensity_' . $plan->intensity) }}</p>
                </div>

                <div class="workspace-stat-card">
                    <div class="workspace-stat-label">{{ __('messages.plan_goal') }}</div>
                    <div class="workspace-stat-value text-3xl">{{ __('messages.goal_' . $plan->goal) }}</div>
                    <p class="stat-card-note">{{ __('messages.profile_intensity') }}: {{ __('messages.intensity_' . $plan->intensity) }}</p>
                </div>
            </section>

            <section class="workspace-card">
                <h2 class="display-card-heading text-xl">{{ __('messages.plans_current_macros_title') }}</h2>
                <p class="display-card-description">{{ __('messages.plans_current_macros_description') }}</p>

                <div class="mt-6 grid gap-6 md:grid-cols-3">
                    <div>
                        <div class="info-row">
                            <span class="list-item-title">{{ __('messages.plan_protein') }}</span>
                            <span class="info-row-value">{{ $plan->protein_g }} g</span>
                        </div>
                    </div>

                    <div>
                        <div class="info-row">
                            <span class="list-item-title">{{ __('messages.plan_carbs') }}</span>
                            <span class="info-row-value">{{ $plan->carbs_g }} g</span>
                        </div>
                    </div>

                    <div>
                        <div class="info-row">
                            <span class="list-item-title">{{ __('messages.plan_fat') }}</span>
                            <span class="info-row-value">{{ $plan->fat_g }} g</span>
                        </div>
                    </div>
                </div>
            </section>
        @else
            <section class="workspace-soft-card">
                <div class="section-header">
                    <div>
                        <h2 class="display-card-heading text-xl">{{ __('messages.plans_create_ready_title') }}</h2>
                        <p class="display-card-description">{{ __('messages.plan_page_generate_description') }}</p>
                    </div>

                    <form action="{{ route('plans.store') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-ui btn-ui-md btn-ui-primary px-6">
                            {{ __('messages.plan_generate_button') }}
                        </button>
                    </form>
                </div>
            </section>

            <section class="workspace-card">
                <h2 class="display-card-heading text-xl">{{ __('messages.plans_create_generated_title') }}</h2>
                <p class="display-card-description">{{ __('messages.plans_create_generated_description') }}</p>

                <div class="mt-6 grid gap-3 md:grid-cols-2">
                    <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                        <div class="display-card-heading text-base">{{ __('messages.plan_bmr') }}</div>
                        <p class="display-card-description">{{ __('messages.plans_create_bmr_description') }}</p>
                    </div>
                    <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                        <div class="display-card-heading text-base">{{ __('messages.plan_tdee') }}</div>
                        <p class="display-card-description">{{ __('messages.plans_create_tdee_description') }}</p>
                    </div>
                    <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                        <div class="display-card-heading text-base">{{ __('messages.plan_target_calories') }}</div>
                        <p class="display-card-description">{{ __('messages.plans_create_target_description') }}</p>
                    </div>
                    <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-4">
                        <div class="display-card-heading text-base">{{ __('messages.plans_create_macro_targets_title') }}</div>
                        <p class="display-card-description">{{ __('messages.plans_create_macro_targets_description') }}</p>
                    </div>
                </div>
            </section>
        @endif

        <section class="layout-main-side-panel">
            <div class="workspace-card">
                <div class="card-header">
                    <h2 class="display-card-heading text-xl">{{ __('messages.plan_profile_snapshot_title') }}</h2>
                    <a href="{{ route('my-profile.edit') }}" class="text-link-ui">{{ __('messages.plans_current_update_profile') }}</a>
                </div>

                <p class="display-card-description">{{ __('messages.plan_profile_snapshot_description') }}</p>

                <div class="mt-6 grid gap-4 sm:grid-cols-3 xl:grid-cols-6">
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_sex') }}</div>
                        <div class="key-stat-value">{{ __('messages.sex_' . $profile->sex) }}</div>
                    </div>
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_height_cm') }}</div>
                        <div class="key-stat-value">{{ $profile->height_cm }}</div>
                    </div>
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_current_weight_kg') }}</div>
                        <div class="key-stat-value">{{ $profile->current_weight_kg }}</div>
                    </div>
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_activity_level') }}</div>
                        <div class="key-stat-value">{{ __('messages.activity_' . $profile->activity_level) }}</div>
                    </div>
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_goal') }}</div>
                        <div class="key-stat-value">{{ __('messages.goal_' . $profile->goal) }}</div>
                    </div>
                    <div>
                        <div class="key-stat-label">{{ __('messages.profile_intensity') }}</div>
                        <div class="key-stat-value">{{ __('messages.intensity_' . $profile->intensity) }}</div>
                    </div>
                </div>
            </div>

            <div class="workspace-card">
                <h2 class="display-card-heading text-xl">{{ __('messages.plans_current_how_title') }}</h2>
                <div class="mt-5 space-y-3">
                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3" open>
                        <summary class="cursor-pointer font-medium text-slate-900">{{ __('messages.plans_current_step_1') }}: {{ __('messages.plan_bmr') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plans_current_step_1_description') }}</p>
                    </details>

                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <summary class="cursor-pointer font-medium text-slate-900">{{ __('messages.plans_current_step_2') }}: {{ __('messages.plan_tdee') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plans_current_step_2_description') }}</p>
                    </details>

                    <details class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                        <summary class="cursor-pointer font-medium text-slate-900">{{ __('messages.plans_current_step_3') }}: {{ __('messages.plan_target_calories') }}</summary>
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ __('messages.plans_current_step_3_description') }}</p>
                    </details>
                </div>
            </div>
        </section>

        @if ($plan)
            <section class="workspace-card">
                <div class="section-header">
                    <div>
                        <h2 class="display-card-heading text-xl">{{ __('messages.plans_current_ready_title') }}</h2>
                        <p class="display-card-description">{{ __('messages.plans_current_ready_description') }}</p>
                    </div>

                    <div class="header-actions">
                        <a href="{{ route('weekly-plans.index') }}" class="btn-ui btn-ui-md btn-ui-secondary">
                            {{ __('messages.weekly_plan_open_planner') }}
                        </a>
                        <a href="{{ route('weekly-plans.create') }}" class="btn-ui btn-ui-md btn-ui-primary">
                            {{ __('messages.weekly_plan_create') }}
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
