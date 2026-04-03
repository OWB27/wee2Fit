@extends('layouts.workspace')

@section('content')
    @php
        $user = auth()->user();
        $currentPlan = $user->plans()->where('is_current', true)->latest()->first();
        $latestMetric = $user->bodyMetrics()->orderByDesc('recorded_on')->orderByDesc('id')->first();
        $weeklyPlansCount = $user->weeklyPlans()->count();
        $metricsCount = $user->bodyMetrics()->count();
        $goalLabel = $user->profile?->goal ? __('messages.goal_' . $user->profile->goal) : __('messages.nav_my_profile');
    @endphp

    <div class="workspace-content-stack">
        <section>
            <h1 class="workspace-page-title">{{ __('messages.dashboard_welcome', ['name' => $user->name]) }}</h1>
            <p class="workspace-page-description">{{ app()->getLocale() === 'zh_CN' ? '这里是你本周的健身营养概览。' : 'Here is your fitness nutrition overview for this week.' }}</p>
        </section>

        <section class="grid gap-4 xl:grid-cols-4">
            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_target_calories') }}</div>
                <div class="workspace-stat-value">{{ $currentPlan?->target_calories ?? '-' }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.plan_target_calories') }}</p>
                <div class="workspace-progress-track">
                    <div class="workspace-progress-fill w-3/4"></div>
                </div>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_goal') }}</div>
                <div class="workspace-stat-value text-3xl">{{ $goalLabel }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.dashboard_plan_text') }}</p>
                <div class="workspace-progress-track">
                    <div class="h-2 rounded-full bg-sky-500 w-1/2"></div>
                </div>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.nav_weekly_plans') }}</div>
                <div class="workspace-stat-value">{{ $weeklyPlansCount }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                <div class="workspace-progress-track">
                    <div class="h-2 rounded-full bg-amber-400 w-2/3"></div>
                </div>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.nav_progress') }}</div>
                <div class="workspace-stat-value">{{ $metricsCount }}</div>
                <p class="mt-2 text-sm text-slate-600">{{ __('messages.progress_description') }}</p>
                <div class="workspace-progress-track">
                    <div class="h-2 rounded-full bg-emerald-500 w-1/3"></div>
                </div>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-[minmax(0,1.8fr),340px]">
            <div class="workspace-card">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.weekly_plans_title') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.weekly_plans_description') }}</p>
                    </div>

                    <a href="{{ route('weekly-plans.index') }}" class="btn btn-outline btn-sm rounded-full border-slate-200 px-4 normal-case text-slate-700 hover:border-green-200 hover:bg-green-50">
                        {{ __('messages.weekly_plan_open_planner') }}
                    </a>
                </div>

                <div class="mt-6 grid gap-3 md:grid-cols-7">
                    @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <div class="rounded-[1.25rem] border border-slate-200 bg-slate-50 p-3">
                            <div class="text-sm font-semibold text-slate-900">{{ __('messages.day_' . $day) }}</div>
                            <div class="mt-3 space-y-2 text-xs text-slate-500">
                                <div class="rounded-xl bg-white px-3 py-2">{{ __('messages.meal_type_breakfast') }}</div>
                                <div class="rounded-xl bg-white px-3 py-2">{{ __('messages.meal_type_lunch') }}</div>
                                <div class="rounded-xl bg-white px-3 py-2">{{ __('messages.meal_type_dinner') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <div class="workspace-card">
                    <h2 class="text-xl font-semibold text-slate-900">{{ app()->getLocale() === 'zh_CN' ? '快捷操作' : 'Quick Actions' }}</h2>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('plans.create') }}" class="flex items-center justify-between rounded-2xl bg-green-600 px-4 py-4 text-sm font-medium text-white shadow-sm transition hover:bg-green-700">
                            <span>{{ __('messages.plan_generate_button') }}</span>
                            <span>&gt;</span>
                        </a>
                        <a href="{{ route('weekly-plans.create') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                            <span>{{ __('messages.weekly_plan_create') }}</span>
                            <span>&gt;</span>
                        </a>
                        <a href="{{ route('progress.index') }}" class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white px-4 py-4 text-sm font-medium text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                            <span>{{ __('messages.progress_add_metric') }}</span>
                            <span>&gt;</span>
                        </a>
                    </div>
                </div>

                <div class="workspace-card">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.progress_title') }}</h2>
                        <a href="{{ route('progress.index') }}" class="text-sm font-medium text-green-700 hover:text-green-800">{{ app()->getLocale() === 'zh_CN' ? '查看全部' : 'View All' }}</a>
                    </div>

                    <div class="mt-5 space-y-4">
                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <div class="text-sm text-slate-500">{{ __('messages.profile_current_weight_kg') }}</div>
                            <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $latestMetric?->weight_kg ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <div class="text-sm text-slate-500">{{ __('messages.progress_body_fat_percentage') }}</div>
                            <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $latestMetric?->body_fat_percentage ?? '-' }}</div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3">
                            <div class="text-sm text-slate-500">{{ __('messages.nav_current_plan') }}</div>
                            <div class="mt-2 text-2xl font-semibold text-slate-900">{{ $currentPlan?->target_calories ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
