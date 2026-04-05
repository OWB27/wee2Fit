<?php

namespace App\Http\Controllers;

use App\Models\BodyMetric;
use App\Models\Plan;
use App\Models\User;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $currentPlan = $this->findCurrentPlanForUser($user);
        $latestMetric = $this->findLatestMetricForUser($user);
        $latestWeeklyPlan = $this->findLatestWeeklyPlanForUser($user);
        $chartData = $this->buildMetricChartData(
            $user->bodyMetrics()
                ->whereDate('recorded_on', '>=', Carbon::today()->subDays(29))
                ->orderBy('recorded_on')
                ->orderBy('id')
                ->get()
        );

        return view('dashboard', [
            'user' => $user,
            'currentPlan' => $currentPlan,
            'latestMetric' => $latestMetric,
            'latestWeeklyPlan' => $latestWeeklyPlan,
            'dashboardStats' => $this->buildDashboardStats($user, $currentPlan),
            'chartData' => $chartData,
            'weeklyPlanPreviewDays' => $this->buildWeeklyPlanPreviewDays($latestWeeklyPlan),
        ]);
    }

    protected function findCurrentPlanForUser(User $user): ?Plan
    {
        return $user->plans()
            ->where('is_current', true)
            ->latest()
            ->first();
    }

    protected function findLatestMetricForUser(User $user): ?BodyMetric
    {
        return $user->bodyMetrics()
            ->orderByDesc('recorded_on')
            ->orderByDesc('id')
            ->first();
    }

    protected function findLatestWeeklyPlanForUser(User $user): ?WeeklyPlan
    {
        return $user->weeklyPlans()
            ->with(['weeklyPlanFoods.food'])
            ->orderByDesc('week_start_date')
            ->orderByDesc('id')
            ->first();
    }

    protected function buildDashboardStats(User $user, ?Plan $currentPlan): array
    {
        return [
            'current_target_calories' => $currentPlan?->target_calories,
            'goal_label' => $user->profile?->goal
                ? __('messages.goal_' . $user->profile->goal)
                : __('messages.nav_my_profile'),
            'weekly_plans_count' => $user->weeklyPlans()->count(),
            'metrics_count' => $user->bodyMetrics()->count(),
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
                ->map(fn ($metric) => is_null($metric->body_fat_percentage) ? null : (float) $metric->body_fat_percentage)
                ->values()
                ->all(),
            'has_body_fat_data' => $metrics->contains(fn ($metric) => ! is_null($metric->body_fat_percentage)),
        ];
    }

    protected function buildWeeklyPlanPreviewDays(?WeeklyPlan $weeklyPlan): array
    {
        if (! $weeklyPlan) {
            return [];
        }

        $days = [];

        foreach (WeeklyPlan::DAY_OPTIONS as $dayNumber => $dayKey) {
            $dayItems = $weeklyPlan->weeklyPlanFoods->where('day_of_week', $dayNumber);

            $meals = [];

            foreach (WeeklyPlanFood::MEAL_TYPE_OPTIONS as $mealType) {
                $mealCalories = $dayItems
                    ->where('meal_type', $mealType)
                    ->sum(fn ($item) => $item->calories());

                $meals[] = [
                    'type' => $mealType,
                    'calories' => round($mealCalories, 1),
                    'display_calories' => $this->formatDashboardMealCalories($mealCalories),
                ];
            }

            $days[] = [
                'day_key' => $dayKey,
                'meals' => $meals,
            ];
        }

        return $days;
    }

    protected function formatDashboardMealCalories(float $calories): string
    {
        if ($calories <= 0) {
            return '-';
        }

        if ($calories >= 1000) {
            return round($calories / 1000, 1) . 'k';
        }

        if ($calories >= 100) {
            return (string) round($calories);
        }

        return rtrim(rtrim(number_format($calories, 1, '.', ''), '0'), '.');
    }
}
