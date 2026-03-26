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

        $foodPickerItems = $foods->map(function ($food) {
            return [
                'id' => $food->id,
                'name' => $food->displayName(),
                'category' => __('messages.food_category_' . $food->category),
            ];
        })->values();

        $slots = $this->buildSlots($weeklyPlan);
        $summary = $this->buildWeeklySummary($request, $weeklyPlan);

        return view('weekly-plans.show', [
            'weeklyPlan' => $weeklyPlan,
            'foods' => $foods,
            'dayOptions' => WeeklyPlan::DAY_OPTIONS,
            'mealTypeOptions' => WeeklyPlanFood::MEAL_TYPE_OPTIONS,
            'slots' => $slots,
            'summary' => $summary,
            'foodPickerItems' => $foodPickerItems,
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
            $slots[$item->day_of_week][$item->meal_type][] = $item;
        }

        return $slots;
    }

    protected function buildWeeklySummary(Request $request, WeeklyPlan $weeklyPlan): array
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

        return [
            'weekly_calories' => round($weeklyCalories, 1),
            'average_daily_calories' => round($averageDailyCalories, 1),
            'target_calories' => $targetCalories,
            'avg_vs_target' => $avgVsTarget !== null ? round($avgVsTarget, 1) : null,
            'weekly_protein_g' => round($weeklyProtein, 1),
            'weekly_carbs_g' => round($weeklyCarbs, 1),
            'weekly_fat_g' => round($weeklyFat, 1),
        ];
    }
}