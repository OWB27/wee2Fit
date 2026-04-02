@extends('layouts.app')

@section('content')
    <div class="page-stack">
        <section class="page-header">
            <div>
                <p class="page-kicker">{{ __('messages.app_name') }}</p>
                <h1 class="page-title mt-2">{{ __('messages.progress_title') }}</h1>
                <p class="page-description mt-3">{{ __('messages.progress_description') }}</p>
            </div>
        </section>

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.progress_add_metric') }}</h2>

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
                            class="textarea textarea-bordered min-h-28 w-full rounded-2xl border-slate-200 bg-white text-sm text-slate-900 shadow-sm transition focus:border-green-600 focus:outline-none focus:ring-4 focus:ring-green-100"
                        >{{ old('note') }}</textarea>
                        @error('note')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <x-primary-button>{{ __('messages.progress_save_metric') }}</x-primary-button>
                </form>
            </div>

            <div class="section-card">
                <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.progress_weight_trend') }}</h2>

                @if ($chartLabels->isEmpty())
                    <div class="empty-state-card mt-6">
                        <div class="empty-state-icon">TR</div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.progress_no_chart_data') }}</h3>
                        <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">
                            {{ __('messages.progress_description') }}
                        </p>
                    </div>
                @else
                    <div class="mt-6 h-80 w-full">
                        <canvas id="weightChart"></canvas>
                    </div>
                @endif
            </div>
        </section>

        <section class="section-card">
            <h2 class="text-lg font-semibold text-slate-900">{{ __('messages.progress_history') }}</h2>

            @if ($bodyMetrics->isEmpty())
                <div class="empty-state-card mt-6">
                    <div class="empty-state-icon">BM</div>
                    <h3 class="mt-4 text-lg font-semibold text-slate-900">{{ __('messages.progress_empty') }}</h3>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">
                        {{ __('messages.progress_description') }}
                    </p>
                </div>
            @else
                <div class="mt-6 overflow-x-auto rounded-3xl border border-slate-200">
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
                        tension: 0.2,
                        borderColor: '#16a34a',
                        backgroundColor: 'rgba(22, 163, 74, 0.12)',
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    @endif
@endsection
