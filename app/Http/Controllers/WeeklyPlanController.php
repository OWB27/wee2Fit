<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeeklyPlanRequest;
use App\Http\Requests\UpdateWeeklyPlanRequest;
use App\Models\Food;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeeklyPlanController extends Controller
{
    public function index(Request $request): View
    {
        $weeklyPlans = $request->user()
            ->weeklyPlans()
            ->orderByDesc('week_start_date')
            ->orderByDesc('id')
            ->get();

        return view('weekly-plans.index', [
            'weeklyPlans' => $weeklyPlans,
            'weeklyPlanSummary' => $this->buildWeeklyPlanIndexSummary($weeklyPlans),
        ]);
    }

    public function create(): View
    {
        return view('weekly-plans.create');
    }

    public function store(StoreWeeklyPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_finalized'] = $request->boolean('is_finalized');

        $weeklyPlan = $request->user()->weeklyPlans()->create($data);

        return redirect()
            ->route('weekly-plans.show', $weeklyPlan)
            ->with('success', __('messages.weekly_plan_created'));
    }

    public function show(Request $request, WeeklyPlan $weeklyPlan): View
    {
        $this->ensureOwner($request, $weeklyPlan);

        $weeklyPlan->load(['weeklyPlanFoods.food']);

        $foods = Food::query()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $slots = $this->buildSlots($weeklyPlan);
        $plannerSummary = $this->buildWeeklySummaryData($request, $weeklyPlan);
        $plannerDays = $this->buildPlannerDaySummaries($slots);

        return view('weekly-plans.show', [
            'weeklyPlan' => $weeklyPlan,
            'foods' => $foods,
            'dayOptions' => WeeklyPlan::DAY_OPTIONS,
            'mealTypeOptions' => WeeklyPlanFood::MEAL_TYPE_OPTIONS,
            'slots' => $slots,
            'plannerSummary' => $plannerSummary,
            'foodPickerOptions' => $this->buildFoodPickerOptions($foods),
            'plannerDays' => $plannerDays,
        ]);
    }

    public function update(
        UpdateWeeklyPlanRequest $request,
        WeeklyPlan $weeklyPlan
    ): RedirectResponse {
        $this->ensureOwner($request, $weeklyPlan);

        $data = $request->validated();
        $data['is_finalized'] = $request->boolean('is_finalized');

        $weeklyPlan->update($data);

        return redirect()
            ->route('weekly-plans.show', $weeklyPlan)
            ->with('success', __('messages.weekly_plan_updated'));
    }

    public function destroy(Request $request, WeeklyPlan $weeklyPlan): RedirectResponse
    {
        $this->ensureOwner($request, $weeklyPlan);

        $weeklyPlan->delete();

        return redirect()
            ->route('weekly-plans.index')
            ->with('success', __('messages.weekly_plan_deleted'));
    }

    protected function ensureOwner(Request $request, WeeklyPlan $weeklyPlan): void
    {
        if ($weeklyPlan->user_id !== $request->user()->id) {
            abort(403);
        }
    }

    protected function buildSlots(WeeklyPlan $weeklyPlan): array
    {
        $slots = [];

        foreach (WeeklyPlan::DAY_OPTIONS as $dayNumber => $dayKey) {
            foreach (WeeklyPlanFood::MEAL_TYPE_OPTIONS as $mealType) {
                $slots[$dayNumber][$mealType] = [];
            }
        }

        foreach ($weeklyPlan->weeklyPlanFoods as $item) {
            if (! isset($slots[$item->day_of_week][$item->meal_type])) {
                continue;
            }

            $slots[$item->day_of_week][$item->meal_type][] = $item;
        }

        return $slots;
    }

    protected function buildWeeklyPlanIndexSummary($weeklyPlans): array
    {
        return [
            'total' => $weeklyPlans->count(),
            'finalized' => $weeklyPlans->where('is_finalized', true)->count(),
            'draft' => $weeklyPlans->where('is_finalized', false)->count(),
        ];
    }

    protected function buildFoodPickerOptions($foods): array
    {
        return $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->displayName(),
                'category' => __('messages.food_category_' . $food->category),
            ];
        })->values()->all();
    }

    protected function buildWeeklySummaryData(Request $request, WeeklyPlan $weeklyPlan): array
    {
        $items = $weeklyPlan->weeklyPlanFoods;

        $weeklyCalories = $items->sum(fn ($item) => $item->calories());
        $weeklyProtein = $items->sum(fn ($item) => $item->proteinGrams());
        $weeklyCarbs = $items->sum(fn ($item) => $item->carbsGrams());
        $weeklyFat = $items->sum(fn ($item) => $item->fatGrams());

        $averageDailyCalories = $weeklyCalories / 7;

        $currentPlan = $request->user()
            ->plans()
            ->where('is_current', true)
            ->latest()
            ->first();

        $targetCalories = $currentPlan?->target_calories;
        $avgVsTarget = $targetCalories
            ? $averageDailyCalories - $targetCalories
            : null;
        $targetWeeklyProtein = $currentPlan?->protein_g ? round($currentPlan->protein_g * 7, 1) : null;
        $targetWeeklyCarbs = $currentPlan?->carbs_g ? round($currentPlan->carbs_g * 7, 1) : null;
        $targetWeeklyFat = $currentPlan?->fat_g ? round($currentPlan->fat_g * 7, 1) : null;

        return [
            'weekly_calories' => round($weeklyCalories, 1),
            'average_daily_calories' => round($averageDailyCalories, 1),
            'target_calories' => $targetCalories,
            'avg_vs_target' => $avgVsTarget !== null ? round($avgVsTarget, 1) : null,
            'avg_progress_percent' => $targetCalories ? min(100, round(($averageDailyCalories / $targetCalories) * 100, 1)) : 0,
            'weekly_protein_g' => round($weeklyProtein, 1),
            'weekly_carbs_g' => round($weeklyCarbs, 1),
            'weekly_fat_g' => round($weeklyFat, 1),
            'target_weekly_protein_g' => $targetWeeklyProtein,
            'target_weekly_carbs_g' => $targetWeeklyCarbs,
            'target_weekly_fat_g' => $targetWeeklyFat,
            'protein_progress_percent' => $targetWeeklyProtein ? min(100, round(($weeklyProtein / $targetWeeklyProtein) * 100, 1)) : 0,
            'carbs_progress_percent' => $targetWeeklyCarbs ? min(100, round(($weeklyCarbs / $targetWeeklyCarbs) * 100, 1)) : 0,
            'fat_progress_percent' => $targetWeeklyFat ? min(100, round(($weeklyFat / $targetWeeklyFat) * 100, 1)) : 0,
        ];
    }

    protected function buildPlannerDaySummaries(array $slots): array
    {
        $plannerDays = [];

        foreach (WeeklyPlan::DAY_OPTIONS as $dayNumber => $dayKey) {
            $dayItems = collect($slots[$dayNumber])->flatten(1);

            $plannerDays[$dayNumber] = [
                'day_number' => $dayNumber,
                'day_key' => $dayKey,
                'item_count' => $dayItems->count(),
                'day_calories' => round($dayItems->sum(fn ($item) => $item->calories()), 1),
                'meals' => $slots[$dayNumber],
            ];
        }

        return $plannerDays;
    }
}
