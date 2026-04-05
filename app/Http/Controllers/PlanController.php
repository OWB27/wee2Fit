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
        return $this->renderPlanPage($request);
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
        return $this->renderPlanPage($request);
    }

    protected function renderPlanPage(Request $request): View|RedirectResponse
    {
        $profile = $request->user()->profile;

        if (! $profile) {
            return redirect()
                ->route('my-profile.edit')
                ->with('error', __('messages.plan_profile_required'));
        }

        $plan = $this->findCurrentPlanForUser($request);

        return view('plans.show', [
            'profile' => $profile,
            'plan' => $plan,
        ]);
    }

    protected function findCurrentPlanForUser(Request $request)
    {
        return $request->user()
            ->plans()
            ->where('is_current', true)
            ->latest()
            ->first();
    }
}
