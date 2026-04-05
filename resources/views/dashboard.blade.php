@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="workspace-page-header-compact">
            <h1 class="workspace-page-title">{{ __('messages.dashboard_welcome', ['name' => $user->name]) }}</h1>
            <p class="workspace-page-description">{{ __('messages.dashboard_overview_intro') }}</p>
        </section>

        <section class="layout-stat-grid">
            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_target_calories') }}</div>
                <div class="workspace-stat-value">{{ $dashboardStats['current_target_calories'] ?? '-' }}</div>
                <p class="stat-card-note">{{ __('messages.plan_target_calories') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.plan_goal') }}</div>
                <div class="workspace-stat-value text-3xl">{{ $dashboardStats['goal_label'] }}</div>
                <p class="stat-card-note">{{ __('messages.dashboard_plan_text') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.nav_weekly_plans') }}</div>
                <div class="workspace-stat-value">{{ $dashboardStats['weekly_plans_count'] }}</div>
                <p class="stat-card-note">{{ __('messages.weekly_plans_description') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.nav_progress') }}</div>
                <div class="workspace-stat-value">{{ $dashboardStats['metrics_count'] }}</div>
                <p class="stat-card-note">{{ __('messages.progress_description') }}</p>
            </div>
        </section>

        <section class="layout-feature-aside">
            <div class="ui-stack-sm">
                <div class="workspace-card">
                    <div class="section-header">
                        <div>
                            <h2 class="display-card-heading">{{ __('messages.weekly_plans_title') }}</h2>
                            <p class="display-card-description">{{ __('messages.dashboard_weekly_plan_description') }}</p>
                        </div>

                        <a href="{{ route('weekly-plans.index') }}" class="btn-ui btn-ui-sm btn-ui-secondary">
                            {{ __('messages.weekly_plan_open_planner') }}
                        </a>
                    </div>

                    @if ($latestWeeklyPlan)
                        <div class="mt-6 dashboard-weekly-plan-grid">
                            @foreach ($weeklyPlanPreviewDays as $day)
                                <div class="dashboard-weekly-plan-card">
                                    <div class="text-sm font-semibold text-slate-900">{{ __('messages.day_' . $day['day_key']) }}</div>
                                    <div class="mt-3 space-y-2">
                                        @foreach ($day['meals'] as $meal)
                                            <div class="dashboard-weekly-plan-meal" title="{{ $meal['calories'] > 0 ? $meal['calories'] . ' kcal' : __('messages.weekly_plan_slot_empty') }}">
                                                <span class="dashboard-weekly-plan-meal-inline">
                                                    <span class="dashboard-weekly-plan-meal-emoji" aria-hidden="true">{{ __('messages.meal_type_' . $meal['type'] . '_emoji') }}</span>
                                                    <span class="dashboard-weekly-plan-meal-value">{{ $meal['display_calories'] }}</span>
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state-card mt-6">
                            <div class="empty-state-icon">WM</div>
                            <h3 class="empty-state-title">{{ __('messages.dashboard_weekly_plan_empty_title') }}</h3>
                            <p class="empty-state-description max-w-md">
                                {{ __('messages.dashboard_weekly_plan_empty_description') }}
                            </p>
                            <a href="{{ route('weekly-plans.create') }}" class="btn-ui btn-ui-md btn-ui-primary mt-5">
                                {{ __('messages.weekly_plan_create') }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="workspace-card">
                    <div class="card-header">
                        <div>
                            <h2 class="display-card-heading">{{ __('messages.progress_trends_title') }}</h2>
                            <p class="display-card-description">{{ __('messages.dashboard_progress_chart_description') }}</p>
                        </div>
                        <a href="{{ route('progress.index') }}" class="text-link-ui">
                            {{ __('messages.dashboard_view_all') }}
                        </a>
                    </div>

                    @if (empty($chartData['labels']))
                        <div class="empty-state-card mt-6">
                            <div class="empty-state-icon">TR</div>
                            <h3 class="empty-state-title">{{ __('messages.progress_no_chart_data') }}</h3>
                            <p class="empty-state-description max-w-md">
                                {{ __('messages.dashboard_progress_chart_description') }}
                            </p>
                        </div>
                    @else
                        <div class="surface-panel-muted mt-6">
                            <div class="h-[260px] w-full">
                                <canvas id="dashboardProgressChart"></canvas>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="ui-stack-sm">
                <div class="workspace-card">
                    <h2 class="display-card-heading text-xl">{{ __('messages.dashboard_quick_actions') }}</h2>
                    <div class="mt-5 space-y-3">
                        <a href="{{ route('plans.current') }}" class="quick-action-tile quick-action-tile-primary">
                            <span>{{ __('messages.nav_plan') }}</span>
                            <span class="quick-action-tile-chevron" aria-hidden="true">&gt;</span>
                        </a>
                        <a href="{{ route('weekly-plans.create') }}" class="quick-action-tile quick-action-tile-secondary">
                            <span>{{ __('messages.weekly_plan_create') }}</span>
                            <span class="quick-action-tile-chevron" aria-hidden="true">&gt;</span>
                        </a>
                        <a href="{{ route('progress.index') }}" class="quick-action-tile quick-action-tile-secondary">
                            <span>{{ __('messages.progress_add_metric') }}</span>
                            <span class="quick-action-tile-chevron" aria-hidden="true">&gt;</span>
                        </a>
                    </div>
                </div>

                <div class="workspace-card">
                    <div class="card-header">
                        <h2 class="display-card-heading text-xl">{{ __('messages.progress_title') }}</h2>
                        <a href="{{ route('progress.index') }}" class="text-link-ui">{{ __('messages.dashboard_view_all') }}</a>
                    </div>

                    <div class="mt-5 ui-stack-sm">
                        <div class="summary-block">
                            <div class="summary-block-label">{{ __('messages.profile_current_weight_kg') }}</div>
                            <div class="summary-block-value">{{ $latestMetric?->weight_kg ?? '-' }}</div>
                        </div>

                        <div class="summary-block">
                            <div class="summary-block-label">{{ __('messages.progress_body_fat_percentage') }}</div>
                            <div class="summary-block-value">{{ $latestMetric?->body_fat_percentage ?? '-' }}</div>
                        </div>

                        <div class="summary-block">
                            <div class="summary-block-label">{{ __('messages.nav_current_plan') }}</div>
                            <div class="summary-block-value">{{ $dashboardStats['current_target_calories'] ?? '-' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @if (! empty($chartData['labels']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const dashboardProgressCtx = document.getElementById('dashboardProgressChart');

            if (dashboardProgressCtx) {
                const weightValues = @json($chartData['weights']);
                const bodyFatValues = @json($chartData['body_fat_values']).filter((value) => value !== null);

                function getSuggestedBounds(values, fallbackPadding = 1) {
                    if (!values.length) {
                        return {};
                    }

                    const min = Math.min(...values);
                    const max = Math.max(...values);
                    const range = max - min;
                    const padding = range === 0 ? fallbackPadding : Math.max(range * 0.35, 0.3);

                    return {
                        suggestedMin: Number((min - padding).toFixed(1)),
                        suggestedMax: Number((max + padding).toFixed(1)),
                    };
                }

                const dashboardDatasets = [
                    {
                        label: @json(__('messages.profile_current_weight_kg')),
                        data: weightValues,
                        tension: 0.24,
                        borderColor: '#3576f6',
                        backgroundColor: 'rgba(53, 118, 246, 0.08)',
                        pointRadius: 2,
                        pointHoverRadius: 4,
                        fill: false,
                        yAxisID: 'yWeight'
                    }
                ];

                if (@json($chartData['has_body_fat_data'])) {
                    dashboardDatasets.push({
                        label: @json(__('messages.progress_body_fat_percentage')),
                        data: @json($chartData['body_fat_values']),
                        tension: 0.24,
                        borderColor: '#f59e0b',
                        backgroundColor: 'rgba(245, 158, 11, 0.10)',
                        pointRadius: 2,
                        pointHoverRadius: 4,
                        fill: false,
                        spanGaps: true,
                        yAxisID: 'yBodyFat'
                    });
                }

                const weightBounds = getSuggestedBounds(weightValues, 1);
                const bodyFatBounds = getSuggestedBounds(bodyFatValues, 0.8);

                new Chart(dashboardProgressCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartData['labels']),
                        datasets: dashboardDatasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true,
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    color: '#475569'
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.12)'
                                }
                            },
                            yWeight: {
                                type: 'linear',
                                position: 'left',
                                ...weightBounds,
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.12)'
                                },
                                ticks: {
                                    color: '#64748b'
                                }
                            },
                            yBodyFat: {
                                type: 'linear',
                                position: 'right',
                                ...bodyFatBounds,
                                display: @json($chartData['has_body_fat_data']),
                                grid: {
                                    drawOnChartArea: false
                                },
                                ticks: {
                                    color: '#c2410c'
                                }
                            }
                        }
                    }
                });
            }
        </script>
    @endif
@endsection
