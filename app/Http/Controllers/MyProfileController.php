<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateMyProfileRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MyProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $profile = $request->user()->profile;
        $profileForm = $this->buildProfileFormData($request, $profile);
        $profileOptions = $this->buildProfileOptionData();
        $profilePreview = $this->buildProfilePreviewData($profileForm, $profileOptions);

        return view('my-profile.edit', [
            'profile' => $profile,
            'profileForm' => $profileForm,
            'profileOptions' => $profileOptions,
            'profilePreview' => $profilePreview,
        ]);
    }

    public function update(UpdateMyProfileRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->profile()->updateOrCreate(
            [],
            $request->validated()
        );

        return redirect()
            ->route('my-profile.edit')
            ->with('success', __('messages.my_profile_saved'));
    }

    protected function buildProfileFormData(Request $request, $profile): array
    {
        $oldInput = $request->session()->getOldInput();

        return [
            'sex' => $oldInput['sex'] ?? $profile?->sex,
            'birth_date' => $oldInput['birth_date'] ?? $profile?->birth_date?->format('Y-m-d'),
            'height_cm' => $oldInput['height_cm'] ?? $profile?->height_cm,
            'current_weight_kg' => $oldInput['current_weight_kg'] ?? $profile?->current_weight_kg,
            'activity_level' => $oldInput['activity_level'] ?? $profile?->activity_level,
            'goal' => $oldInput['goal'] ?? $profile?->goal,
            'intensity' => $oldInput['intensity'] ?? $profile?->intensity,
        ];
    }

    protected function buildProfileOptionData(): array
    {
        return [
            'activity_factors' => [
                'sedentary' => 1.2,
                'light' => 1.375,
                'moderate' => 1.55,
                'active' => 1.725,
                'very_active' => 1.9,
            ],
            'intensity_adjustments' => [
                'mild' => 250,
                'moderate' => 500,
                'aggressive' => 750,
            ],
        ];
    }

    protected function buildProfilePreviewData(array $profileForm, array $profileOptions): array
    {
        $age = null;
        if (! empty($profileForm['birth_date'])) {
            try {
                $age = Carbon::parse($profileForm['birth_date'])->age;
            } catch (\Throwable) {
                $age = null;
            }
        }

        $height = is_numeric($profileForm['height_cm']) ? (float) $profileForm['height_cm'] : null;
        $weight = is_numeric($profileForm['current_weight_kg']) ? (float) $profileForm['current_weight_kg'] : null;

        $bmr = null;
        if ($age && $height && $weight && in_array($profileForm['sex'], ['male', 'female'], true)) {
            $bmr = $profileForm['sex'] === 'male'
                ? (10 * $weight) + (6.25 * $height) - (5 * $age) + 5
                : (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        $tdee = $bmr && isset($profileOptions['activity_factors'][$profileForm['activity_level']])
            ? $bmr * $profileOptions['activity_factors'][$profileForm['activity_level']]
            : null;

        $targetCalories = null;
        if (
            $tdee
            && isset($profileOptions['intensity_adjustments'][$profileForm['intensity']])
            && in_array($profileForm['goal'], ['cut', 'bulk'], true)
        ) {
            $targetCalories = $profileForm['goal'] === 'cut'
                ? $tdee - $profileOptions['intensity_adjustments'][$profileForm['intensity']]
                : $tdee + $profileOptions['intensity_adjustments'][$profileForm['intensity']];

            $targetCalories = max(1200, (int) round($targetCalories));
        }

        return [
            'age' => $age,
            'bmr' => $bmr,
            'tdee' => $tdee,
            'target_calories' => $targetCalories,
        ];
    }
}
