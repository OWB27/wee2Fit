<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePlanRequest;
use App\Services\PlanGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct(
        protected PlanGeneratorService $planGeneratorService
    ) {
    }

    public function create(Request $request): View|RedirectResponse
    {
        $profile = $request->user()->profile;

        if (! $profile) {
            return redirect()
                ->route('my-profile.edit')
                ->with('error', __('messages.plan_profile_required'));
        }

        return view('plans.create', [
            'profile' => $profile,
        ]);
    }

    public function store(StorePlanRequest $request): RedirectResponse
    {
        $user = $request->user();
        $profile = $user->profile;

        if (! $profile) {
            return redirect()
                ->route('my-profile.edit')
                ->with('error', __('messages.plan_profile_required'));
        }

        $generatedPlan = $this->planGeneratorService->generateFromProfile($profile);

        $user->plans()->where('is_current', true)->update([
            'is_current' => false,
        ]);

        $user->plans()->create([
            ...$generatedPlan,
            'is_current' => true,
        ]);

        return redirect()
            ->route('plans.current')
            ->with('success', __('messages.plan_generated_success'));
    }

    public function showCurrent(Request $request): View|RedirectResponse
    {
        $plan = $request->user()
            ->plans()
            ->where('is_current', true)
            ->latest()
            ->first();

        if (! $plan) {
            return redirect()
                ->route('plans.create')
                ->with('error', __('messages.plan_not_found'));
        }

        return view('plans.current', [
            'plan' => $plan,
        ]);
    }
}