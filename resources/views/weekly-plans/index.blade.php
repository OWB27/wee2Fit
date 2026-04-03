@extends('layouts.workspace')

@section('content')
    @php
        $totalPlans = $weeklyPlans->count();
        $finalizedPlans = $weeklyPlans->where('is_finalized', true)->count();
        $draftPlans = $totalPlans - $finalizedPlans;
    @endphp

    <div class="workspace-content-stack">
        <section class="flex flex-col gap-4 xl:flex-row xl:items-start xl:justify-between">
            <div>
                <div class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-100 text-sm font-semibold text-emerald-700 shadow-sm">
                    WP
                </div>
                <h1 class="workspace-page-title mt-4">{{ __('messages.weekly_plans_title') }}</h1>
                <p class="workspace-page-description">{{ __('messages.weekly_plans_description') }}</p>
            </div>

            <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                {{ __('messages.weekly_plan_create') }}
            </a>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.weekly_plans_title') }}</p>
                <div class="workspace-stat-value">{{ $totalPlans }}</div>
                <p class="mt-3 text-sm text-slate-500">{{ __('messages.weekly_plan_week_start_date') }}</p>
            </div>

            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.weekly_plan_is_finalized') }}</p>
                <div class="workspace-stat-value text-emerald-600">{{ $finalizedPlans }}</div>
                <p class="mt-3 text-sm text-slate-500">{{ __('messages.yes') }}</p>
            </div>

            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.admin_users_status') }}</p>
                <div class="workspace-stat-value text-amber-500">{{ $draftPlans }}</div>
                <p class="mt-3 text-sm text-slate-500">{{ __('messages.no') }}</p>
            </div>
        </section>

        @if ($weeklyPlans->isEmpty())
            <div class="empty-state-card">
                <div class="empty-state-icon">WP</div>
                <h2 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.weekly_plan_empty') }}</h2>
                <p class="mx-auto mt-2 max-w-xl text-sm leading-6 text-slate-600">
                    {{ __('messages.weekly_plans_description') }}
                </p>
                <div class="mt-5">
                    <a href="{{ route('weekly-plans.create') }}" class="btn btn-primary rounded-full border-0 px-5 normal-case shadow-sm">
                        {{ __('messages.weekly_plan_create') }}
                    </a>
                </div>
            </div>
        @else
            <section class="workspace-table-shell">
                <table class="table">
                    <thead>
                        <tr class="text-xs uppercase tracking-[0.16em] text-slate-400">
                            <th>{{ __('messages.weekly_plan_title') }}</th>
                            <th>{{ __('messages.weekly_plan_week_start_date') }}</th>
                            <th>{{ __('messages.weekly_plan_is_finalized') }}</th>
                            <th>Updated</th>
                            <th class="text-right">{{ __('messages.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weeklyPlans as $weeklyPlan)
                            <tr class="align-middle">
                                <td class="py-5">
                                    <div class="flex items-start gap-4">
                                        <div class="inline-flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-emerald-50 text-sm font-semibold text-emerald-700">
                                            {{ strtoupper(substr($weeklyPlan->title, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <div class="font-semibold text-slate-900">{{ $weeklyPlan->title }}</div>
                                            <p class="mt-1 text-sm text-slate-500">
                                                {{ $weeklyPlan->note ?: __('messages.weekly_plans_description') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 text-sm text-slate-600">
                                    {{ $weeklyPlan->week_start_date?->format('Y-m-d') }}
                                </td>
                                <td class="py-5">
                                    <span class="badge rounded-full border-0 px-3 py-3 {{ $weeklyPlan->is_finalized ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                                    </span>
                                </td>
                                <td class="py-5 text-sm text-slate-600">
                                    {{ $weeklyPlan->updated_at?->format('Y-m-d H:i') }}
                                </td>
                                <td class="py-5 text-right">
                                    <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn btn-primary btn-sm rounded-full border-0 px-4 normal-case shadow-sm">
                                        {{ __('messages.weekly_plan_open_planner') }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif
    </div>
@endsection
