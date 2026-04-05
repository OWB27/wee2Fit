@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="workspace-page-header">
            <div>
                <h1 class="workspace-page-title">{{ __('messages.weekly_plans_title') }}</h1>
                <p class="workspace-page-description">{{ __('messages.weekly_plans_description') }}</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('weekly-plans.create') }}" class="btn-ui btn-ui-md btn-ui-primary">
                    {{ __('messages.weekly_plan_create') }}
                </a>
            </div>
        </section>

        <section class="grid gap-4 lg:grid-cols-3">
            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.weekly_plans_title') }}</p>
                <div class="workspace-stat-value">{{ $weeklyPlanSummary['total'] }}</div>
            </div>

            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.weekly_plan_is_finalized') }}</p>
                <div class="workspace-stat-value text-emerald-600">{{ $weeklyPlanSummary['finalized'] }}</div>
            </div>

            <div class="workspace-stat-card">
                <p class="workspace-stat-label">{{ __('messages.weekly_plan_draft_label') }}</p>
                <div class="workspace-stat-value text-amber-500">{{ $weeklyPlanSummary['draft'] }}</div>
            </div>
        </section>

        @if ($weeklyPlans->isEmpty())
            <div class="empty-state-card">
                <div class="empty-state-icon">WP</div>
                <h2 class="empty-state-title">{{ __('messages.weekly_plan_empty') }}</h2>
                <p class="empty-state-description">
                    {{ __('messages.weekly_plans_description') }}
                </p>
                <div class="mt-5">
                    <a href="{{ route('weekly-plans.create') }}" class="btn-ui btn-ui-md btn-ui-primary">
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
                            <th>{{ __('messages.weekly_plan_updated_label') }}</th>
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
                                            <div class="list-item-title">{{ $weeklyPlan->title }}</div>
                                            <p class="list-item-meta">
                                                {{ $weeklyPlan->note ?: __('messages.weekly_plans_description') }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-5 meta-text-strong">
                                    {{ $weeklyPlan->week_start_date?->format('Y-m-d') }}
                                </td>
                                <td class="py-5">
                                    <span class="badge-ui {{ $weeklyPlan->is_finalized ? 'badge-ui-success' : 'badge-ui-warning' }}">
                                        {{ $weeklyPlan->is_finalized ? __('messages.yes') : __('messages.no') }}
                                    </span>
                                </td>
                                <td class="py-5 meta-text-strong">
                                    {{ $weeklyPlan->updated_at?->format('Y-m-d H:i') }}
                                </td>
                                <td class="py-5">
                                    <div class="table-action-cell">
                                        <a href="{{ route('weekly-plans.show', $weeklyPlan) }}" class="btn-ui btn-ui-sm btn-ui-primary">
                                            {{ __('messages.weekly_plan_open_planner') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif
    </div>
@endsection
