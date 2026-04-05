<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBodyMetricRequest;
use App\Models\BodyMetric;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BodyMetricController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $bodyMetrics = $user->bodyMetrics()
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->get();

        $chartMetrics = $user->bodyMetrics()
            ->orderBy('recorded_on')
            ->orderBy('id')
            ->get();

        return view('progress.index', [
            'bodyMetrics' => $bodyMetrics,
            'metricsSummary' => $this->buildMetricsSummary($bodyMetrics),
            'chartData' => $this->buildMetricChartData($chartMetrics),
        ]);
    }

    public function store(StoreBodyMetricRequest $request): RedirectResponse
    {
        $request->user()->bodyMetrics()->create($request->validated());

        return redirect()
            ->route('progress.index')
            ->with('success', __('messages.progress_metric_created'));
    }

    public function destroy(Request $request, BodyMetric $bodyMetric): RedirectResponse
    {
        if ($bodyMetric->user_id !== $request->user()->id) {
            abort(403);
        }

        $bodyMetric->delete();

        return redirect()
            ->route('progress.index')
            ->with('success', __('messages.progress_metric_deleted'));
    }

    protected function buildMetricsSummary(Collection $bodyMetrics): array
    {
        return [
            'latest_metric' => $bodyMetrics->first(),
            'total_entries' => $bodyMetrics->count(),
        ];
    }

    protected function buildMetricChartData(Collection $metrics): array
    {
        return [
            'labels' => $metrics
                ->pluck('recorded_on')
                ->map(fn ($date) => $date->format('Y-m-d'))
                ->values()
                ->all(),
            'weights' => $metrics
                ->pluck('weight_kg')
                ->map(fn ($value) => (float) $value)
                ->values()
                ->all(),
            'body_fat_values' => $metrics
                ->pluck('body_fat_percentage')
                ->map(fn ($value) => is_null($value) ? null : (float) $value)
                ->values()
                ->all(),
            'has_body_fat_data' => $metrics->contains(fn ($metric) => ! is_null($metric->body_fat_percentage)),
        ];
    }
}
