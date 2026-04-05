<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeeklyPlanFoodRequest;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WeeklyPlanFoodController extends Controller
{
    public function store(
        StoreWeeklyPlanFoodRequest $request,
        WeeklyPlan $weeklyPlan
    ): RedirectResponse {
        $this->ensureWeeklyPlanOwner($request, $weeklyPlan);

        $weeklyPlan->weeklyPlanFoods()->create($request->validated());

        return redirect()
            ->to($this->weeklyPlanShowUrl($weeklyPlan, $request->string('return_anchor')->toString()))
            ->with('success', __('messages.weekly_plan_food_added'));
    }

    public function destroy(Request $request, WeeklyPlanFood $weeklyPlanFood): RedirectResponse
    {
        $weeklyPlanFood->load('weeklyPlan');

        if ($weeklyPlanFood->weeklyPlan->user_id !== $request->user()->id) {
            abort(403);
        }

        $weeklyPlan = $weeklyPlanFood->weeklyPlan;
        $returnAnchor = $this->slotAnchor($weeklyPlanFood->day_of_week, $weeklyPlanFood->meal_type);

        $weeklyPlanFood->delete();

        return redirect()
            ->to($this->weeklyPlanShowUrl($weeklyPlan, $returnAnchor))
            ->with('success', __('messages.weekly_plan_food_deleted'));
    }

    protected function ensureWeeklyPlanOwner(Request $request, WeeklyPlan $weeklyPlan): void
    {
        if ($weeklyPlan->user_id !== $request->user()->id) {
            abort(403);
        }
    }

    protected function weeklyPlanShowUrl(WeeklyPlan $weeklyPlan, string $anchor = ''): string
    {
        $url = route('weekly-plans.show', $weeklyPlan);

        if ($anchor === '') {
            return $url;
        }

        return $url . '#' . ltrim($anchor, '#');
    }

    protected function slotAnchor(int|string $dayOfWeek, string $mealType): string
    {
        return 'slot-' . $dayOfWeek . '-' . $mealType;
    }
}
