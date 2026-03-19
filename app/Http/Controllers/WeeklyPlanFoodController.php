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
            ->route('weekly-plans.show', $weeklyPlan)
            ->with('success', __('messages.weekly_plan_food_added'));
    }

    public function destroy(Request $request, WeeklyPlanFood $weeklyPlanFood): RedirectResponse
    {
        $weeklyPlanFood->load('weeklyPlan');

        if ($weeklyPlanFood->weeklyPlan->user_id !== $request->user()->id) {
            abort(403);
        }

        $weeklyPlan = $weeklyPlanFood->weeklyPlan;

        $weeklyPlanFood->delete();

        return redirect()
            ->route('weekly-plans.show', $weeklyPlan)
            ->with('success', __('messages.weekly_plan_food_deleted'));
    }

    protected function ensureWeeklyPlanOwner(Request $request, WeeklyPlan $weeklyPlan): void
    {
        if ($weeklyPlan->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}