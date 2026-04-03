@extends('layouts.workspace')

@section('content')
    @php
        $latestMetric = $bodyMetrics->first();
    @endphp

    <div class="workspace-content-stack">
        <section>
            <h1 class="workspace-page-title">{{ __('messages.progress_title') }}</h1>
            <p class="workspace-page-description">{{ __('messages.progress_description') }}</p>
        </section>

        <section class="grid gap-4 xl:grid-cols-3">
            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.profile_current_weight_kg') }}</div>
                <div class="workspace-stat-value">{{ $latestMetric?->weight_kg ?? '-' }}</div>
                <p class="mt-2 text-sm text-emerald-600">Latest entry</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">{{ __('messages.progress_body_fat_percentage') }}</div>
                <div class="workspace-stat-value">{{ $latestMetric?->body_fat_percentage ?? '-' }}</div>
                <p class="mt-2 text-sm text-emerald-600">{{ __('messages.progress_description') }}</p>
            </div>

            <div class="workspace-stat-card">
                <div class="workspace-stat-label">Total Entries</div>
                <div class="workspace-stat-value">{{ $bodyMetrics->count() }}</div>
                <p class="mt-2 text-sm text-slate-500">
                    {{ __('messages.progress_recorded_on') }}:
                    {{ $latestMetric?->recorded_on?->format('Y-m-d') ?? '-' }}
                </p>
            </div>
        </section>

        <section class="grid gap-4 xl:grid-cols-[360px,minmax(0,1fr)]">
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
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="weight_kg" :value="__('messages.profile_current_weight_kg')" />
                        <x-text-input
                            type="number"
                            step="0.1"
                            name="weight_kg"
                            id="weight_kg"
                            :value="old('weight_kg')"
                        />
                        @error('weight_kg')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <x-input-label for="body_fat_percentage" :value="__('messages.progress_body_fat_percentage')" />
                        <x-text-input
                            type="number"
                            step="0.1"
                            name="body_fat_percentage"
                            id="body_fat_percentage"
                            :value="old('body_fat_percentage')"
                        />
                        @error('body_fat_percentage')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
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
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-primary-button class="w-full justify-center">{{ __('messages.progress_save_metric') }}</x-primary-button>
                </form>

                <div class="mt-6 rounded-[1.5rem] border border-emerald-100 bg-emerald-50 px-4 py-4 text-sm leading-6 text-emerald-800">
                    Tip: Log measurements at a consistent time of day for cleaner trend lines.
                </div>
            </div>

            <div class="workspace-card">
                <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.progress_weight_trend') }}</h2>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.progress_description') }}</p>
                    </div>

                    <div class="inline-flex rounded-full border border-slate-200 bg-white p-1 text-xs font-medium text-slate-500 shadow-sm">
                        <span class="rounded-full bg-slate-100 px-3 py-1">7 days</span>
                        <span class="px-3 py-1">30 days</span>
                        <span class="px-3 py-1">90 days</span>
                    </div>
                </div>

                @if ($chartLabels->isEmpty())
                    <div class="empty-state-card mt-6">
                        <div class="empty-state-icon">TR</div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.progress_no_chart_data') }}</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">
                            {{ __('messages.progress_description') }}
                        </p>
                    </div>
                @else
                    <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-slate-50 p-4">
                        <div class="h-[420px] w-full">
                            <canvas id="weightChart"></canvas>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <section class="workspace-card">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.progress_history') }}</h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ __('messages.progress_description') }}</p>
                </div>
            </div>

            @if ($bodyMetrics->isEmpty())
                <div class="empty-state-card mt-6">
                    <div class="empty-state-icon">BM</div>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.progress_empty') }}</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">
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
                                            <button type="submit" class="btn btn-error btn-sm rounded-full border-0 normal-case">
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

    @if ($chartLabels->isNotEmpty())
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('weightChart');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: @json(__('messages.profile_current_weight_kg')),
                        data: @json($chartWeights),
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
        </script>
    @endif
@endsection
