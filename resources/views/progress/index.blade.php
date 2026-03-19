@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div>
            <h1 class="text-3xl font-bold">{{ __('messages.progress_title') }}</h1>
            <p class="text-base-content/70">{{ __('messages.progress_description') }}</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-2">
            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.progress_add_metric') }}</h2>

                    <form action="{{ route('progress.store') }}" method="POST" class="space-y-4 mt-4">
                        @csrf

                        <div>
                            <label for="recorded_on" class="label">
                                <span class="label-text">{{ __('messages.progress_recorded_on') }}</span>
                            </label>
                            <input
                                type="date"
                                name="recorded_on"
                                id="recorded_on"
                                class="input input-bordered w-full"
                                value="{{ old('recorded_on', now()->format('Y-m-d')) }}"
                            >
                            @error('recorded_on')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weight_kg" class="label">
                                <span class="label-text">{{ __('messages.profile_current_weight_kg') }}</span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="weight_kg"
                                id="weight_kg"
                                class="input input-bordered w-full"
                                value="{{ old('weight_kg') }}"
                            >
                            @error('weight_kg')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="body_fat_percentage" class="label">
                                <span class="label-text">{{ __('messages.progress_body_fat_percentage') }}</span>
                            </label>
                            <input
                                type="number"
                                step="0.1"
                                name="body_fat_percentage"
                                id="body_fat_percentage"
                                class="input input-bordered w-full"
                                value="{{ old('body_fat_percentage') }}"
                            >
                            @error('body_fat_percentage')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="note" class="label">
                                <span class="label-text">{{ __('messages.progress_note') }}</span>
                            </label>
                            <textarea
                                name="note"
                                id="note"
                                rows="3"
                                class="textarea textarea-bordered w-full"
                            >{{ old('note') }}</textarea>
                            @error('note')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            {{ __('messages.progress_save_metric') }}
                        </button>
                    </form>
                </div>
            </div>

            <div class="card bg-base-100 shadow">
                <div class="card-body">
                    <h2 class="card-title">{{ __('messages.progress_weight_trend') }}</h2>

                    @if ($chartLabels->isEmpty())
                        <p class="text-base-content/70">{{ __('messages.progress_no_chart_data') }}</p>
                    @else
                        <div class="w-full h-80">
                            <canvas id="weightChart"></canvas>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card bg-base-100 shadow">
            <div class="card-body">
                <h2 class="card-title">{{ __('messages.progress_history') }}</h2>

                <div class="overflow-x-auto mt-4">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('messages.progress_recorded_on') }}</th>
                                <th>{{ __('messages.profile_current_weight_kg') }}</th>
                                <th>{{ __('messages.progress_body_fat_percentage') }}</th>
                                <th>{{ __('messages.progress_note') }}</th>
                                <th>{{ __('messages.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bodyMetrics as $bodyMetric)
                                <tr>
                                    <td>{{ $bodyMetric->recorded_on?->format('Y-m-d') }}</td>
                                    <td>{{ $bodyMetric->weight_kg }}</td>
                                    <td>{{ $bodyMetric->body_fat_percentage ?? '-' }}</td>
                                    <td>{{ $bodyMetric->note ?: '-' }}</td>
                                    <td>
                                        <form action="{{ route('progress.destroy', $bodyMetric) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-error">
                                                {{ __('messages.delete') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">{{ __('messages.progress_empty') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
                        tension: 0.2
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