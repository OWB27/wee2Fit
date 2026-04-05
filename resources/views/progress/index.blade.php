@extends('layouts.workspace')

@section('content')
    <div class="workspace-content-stack">
        <section class="workspace-page-header-compact">
            <h1 class="workspace-page-title">{{ __('messages.progress_title') }}</h1>
            <p class="workspace-page-description">{{ __('messages.progress_description') }}</p>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.profile_current_weight_kg') }}</div>
                <div class="workspace-stat-value">{{ $metricsSummary['latest_metric']?->weight_kg ?? '-' }}</div>
                <p class="mt-2 text-sm text-emerald-600">{{ __('messages.progress_latest_entry') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.progress_body_fat_percentage') }}</div>
                <div class="workspace-stat-value">{{ $metricsSummary['latest_metric']?->body_fat_percentage ?? '-' }}</div>
                <p class="mt-2 text-sm text-emerald-600">{{ __('messages.progress_description') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.progress_total_entries') }}</div>
                <div class="workspace-stat-value">{{ $metricsSummary['total_entries'] }}</div>
                <p class="stat-card-note">
                    {{ __('messages.progress_recorded_on') }}:
                    {{ $metricsSummary['latest_metric']?->recorded_on?->format('Y-m-d') ?? '-' }}
                </p>
            </div>
        </section>

        <section class="layout-sidebar-main">
            <div class="workspace-card">
                <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.progress_add_metric') }}</h2>

                <form action="{{ route('progress.store') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <x-input-label for="recorded_on" :value="__('messages.progress_recorded_on')" />
                        <x-text-input
                            type="date"
                            name="recorded_on"
                            id="recorded_on"
                            :value="old('recorded_on', now()->format('Y-m-d'))"
                        />
                        @error('recorded_on')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="weight_kg" :value="__('messages.profile_current_weight_kg')" />
                        <x-text-input
                            type="number"
                            step="0.1"
                            name="weight_kg"
                            id="weight_kg"
                            :value="old('weight_kg', $metricsSummary['latest_metric']?->weight_kg)"
                        />
                        @error('weight_kg')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="body_fat_percentage" :value="__('messages.progress_body_fat_percentage')" />
                        <x-text-input
                            type="number"
                            step="0.1"
                            name="body_fat_percentage"
                            id="body_fat_percentage"
                            :value="old('body_fat_percentage', $metricsSummary['latest_metric']?->body_fat_percentage)"
                        />
                        @error('body_fat_percentage')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="note" :value="__('messages.progress_note')" />
                        <textarea
                            name="note"
                            id="note"
                            rows="4"
                            class="form-textarea min-h-28"
                        >{{ old('note') }}</textarea>
                        @error('note')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-primary-button class="w-full justify-center">{{ __('messages.progress_save_metric') }}</x-primary-button>
                </form>

                <div class="workspace-helper-card border-emerald-100 bg-emerald-50">
                    <p class="display-card-description mt-0 text-emerald-800">{{ __('messages.progress_logging_tip') }}</p>
                </div>
            </div>

            <div class="workspace-card">
                <div class="section-header">
                    <div>
                        <h2 class="display-card-heading text-xl">{{ __('messages.progress_trends_title') }}</h2>
                        <p class="display-card-description">{{ __('messages.progress_description') }}</p>
                    </div>

                    <div class="toolbar-chip-group">
                        <button type="button" class="progress-range-button rounded-full px-3 py-1 transition" data-range="7">
                            {{ __('messages.progress_range_7_days') }}
                        </button>
                        <button type="button" class="progress-range-button rounded-full bg-slate-100 px-3 py-1 text-slate-700 transition" data-range="30">
                            {{ __('messages.progress_range_30_days') }}
                        </button>
                        <button type="button" class="progress-range-button rounded-full px-3 py-1 transition" data-range="90">
                            {{ __('messages.progress_range_90_days') }}
                        </button>
                    </div>
                </div>

                @if (empty($chartData['labels']))
                    <div class="empty-state-card mt-6">
                        <div class="empty-state-icon">TR</div>
                        <h3 class="empty-state-title">{{ __('messages.progress_no_chart_data') }}</h3>
                        <p class="empty-state-description max-w-md">
                            {{ __('messages.progress_description') }}
                        </p>
                    </div>
                @else
                    <div class="mt-6 space-y-4">
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                            <div>
                                <h3 class="text-base font-semibold text-slate-900">{{ __('messages.progress_weight_trend') }}</h3>
                                <p class="descriptor-text">{{ __('messages.profile_current_weight_kg') }}</p>
                            </div>

                            <div class="mt-4 h-[220px] w-full">
                                <canvas id="weightChart"></canvas>
                            </div>
                        </div>

                        @if ($chartData['has_body_fat_data'])
                            <div class="rounded-[1.5rem] border border-orange-100 bg-orange-50/60 p-4">
                                <div>
                                    <h3 class="text-base font-semibold text-slate-900">{{ __('messages.progress_body_fat_trend') }}</h3>
                                    <p class="descriptor-text">{{ __('messages.progress_body_fat_percentage') }}</p>
                                </div>

                                <div class="mt-4 h-[220px] w-full">
                                    <canvas id="bodyFatChart"></canvas>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        <section class="workspace-card">
                <div class="section-header">
                    <div>
                        <h2 class="display-card-heading text-xl">{{ __('messages.progress_history') }}</h2>
                        <p class="display-card-description">{{ __('messages.progress_description') }}</p>
                </div>
            </div>

            @if ($bodyMetrics->isEmpty())
                <div class="empty-state-card mt-6">
                    <div class="empty-state-icon">BM</div>
                    <h3 class="empty-state-title">{{ __('messages.progress_empty') }}</h3>
                    <p class="empty-state-description max-w-md">
                        {{ __('messages.progress_description') }}
                    </p>
                </div>
            @else
                <div class="workspace-table-shell mt-6">
                    <table class="table">
                        <thead>
                            <tr class="text-slate-500">
                                <th>{{ __('messages.progress_recorded_on') }}</th>
                                <th>{{ __('messages.profile_current_weight_kg') }}</th>
                                <th>{{ __('messages.progress_body_fat_percentage') }}</th>
                                <th>{{ __('messages.progress_note') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bodyMetrics as $bodyMetric)
                                <tr class="hover">
                                    <td>{{ $bodyMetric->recorded_on?->format('Y-m-d') }}</td>
                                    <td>{{ $bodyMetric->weight_kg }}</td>
                                    <td>{{ $bodyMetric->body_fat_percentage ?? '-' }}</td>
                                    <td>{{ $bodyMetric->note ?: '-' }}</td>
                                    <td>
                                        <form action="{{ route('progress.destroy', $bodyMetric) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-ui btn-ui-sm btn-ui-danger">
                                                {{ __('messages.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>
    </div>

    @if (! empty($chartData['labels']))
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const allLabels = @json($chartData['labels']);
            const allWeights = @json($chartData['weights']);
            const allBodyFatValues = @json($chartData['body_fat_values']);
            const rangeButtons = document.querySelectorAll('.progress-range-button');

            function filterChartSeries(days) {
                if (days >= 90 || allLabels.length <= 1) {
                    return {
                        labels: allLabels,
                        weights: allWeights,
                        bodyFatLabels: allLabels.filter((_, index) => allBodyFatValues[index] !== null),
                        bodyFatValues: allBodyFatValues.filter(value => value !== null),
                    };
                }

                const endDate = new Date(allLabels[allLabels.length - 1]);
                const startDate = new Date(endDate);
                startDate.setDate(endDate.getDate() - (days - 1));

                const labels = [];
                const weights = [];
                const bodyFatLabels = [];
                const bodyFatValues = [];

                allLabels.forEach((label, index) => {
                    const pointDate = new Date(label);

                    if (pointDate < startDate || pointDate > endDate) {
                        return;
                    }

                    labels.push(label);
                    weights.push(allWeights[index]);

                    if (allBodyFatValues[index] !== null) {
                        bodyFatLabels.push(label);
                        bodyFatValues.push(allBodyFatValues[index]);
                    }
                });

                return { labels, weights, bodyFatLabels, bodyFatValues };
            }

            function setActiveRangeButton(days) {
                rangeButtons.forEach((button) => {
                    const isActive = Number(button.dataset.range) === days;

                    button.classList.toggle('bg-slate-100', isActive);
                    button.classList.toggle('text-slate-700', isActive);
                    button.classList.toggle('text-slate-500', ! isActive);
                });
            }

            const ctx = document.getElementById('weightChart');
            const initialSeries = filterChartSeries(30);

            const weightChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: initialSeries.labels,
                    datasets: [{
                        label: @json(__('messages.profile_current_weight_kg')),
                        data: initialSeries.weights,
                        tension: 0.24,
                        borderColor: '#3576f6',
                        backgroundColor: 'rgba(53, 118, 246, 0.08)',
                        pointRadius: 2,
                        pointHoverRadius: 4,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(148, 163, 184, 0.12)'
                            }
                        },
                        y: {
                            grid: {
                                color: 'rgba(148, 163, 184, 0.12)'
                            }
                        }
                    }
                }
            });

            const bodyFatCtx = document.getElementById('bodyFatChart');
            let bodyFatChart = null;

            if (bodyFatCtx) {
                bodyFatChart = new Chart(bodyFatCtx, {
                    type: 'line',
                    data: {
                        labels: initialSeries.bodyFatLabels,
                        datasets: [{
                            label: @json(__('messages.progress_body_fat_percentage')),
                            data: initialSeries.bodyFatValues,
                            tension: 0.24,
                            borderColor: '#f59e0b',
                            backgroundColor: 'rgba(245, 158, 11, 0.10)',
                            pointRadius: 2,
                            pointHoverRadius: 4,
                            fill: false
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.12)'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(148, 163, 184, 0.12)'
                                }
                            }
                        }
                    }
                });
            }

            rangeButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const days = Number(button.dataset.range);
                    const nextSeries = filterChartSeries(days);

                    weightChart.data.labels = nextSeries.labels;
                    weightChart.data.datasets[0].data = nextSeries.weights;
                    weightChart.update();

                    if (bodyFatChart) {
                        bodyFatChart.data.labels = nextSeries.bodyFatLabels;
                        bodyFatChart.data.datasets[0].data = nextSeries.bodyFatValues;
                        bodyFatChart.update();
                    }

                    setActiveRangeButton(days);
                });
            });

            setActiveRangeButton(30);
        </script>
    @endif
@endsection
