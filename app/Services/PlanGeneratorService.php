<?php

namespace App\Services;

use App\Models\Profile;
use Carbon\Carbon;
use InvalidArgumentException;

class PlanGeneratorService
{
    public function generateFromProfile(Profile $profile): array
    {
        if (! $profile->birth_date) {
            throw new InvalidArgumentException('Profile birth date is required.');
        }

        $age = Carbon::parse($profile->birth_date)->age;
        $weight = (float) $profile->current_weight_kg;
        $height = (float) $profile->height_cm;

        $bmr = $this->calculateBmr(
            sex: $profile->sex,
            weightKg: $weight,
            heightCm: $height,
            age: $age,
        );

        $activityFactor = $this->getActivityFactor($profile->activity_level);
        $tdee = $bmr * $activityFactor;

        $targetCalories = $this->calculateTargetCalories(
            tdee: $tdee,
            goal: $profile->goal,
            intensity: $profile->intensity,
        );

        $macros = $this->calculateMacros(
            targetCalories: $targetCalories,
            goal: $profile->goal,
        );

        return [
            'age' => $age,
            'sex' => $profile->sex,
            'height_cm' => $height,
            'weight_kg' => $weight,
            'activity_level' => $profile->activity_level,
            'goal' => $profile->goal,
            'intensity' => $profile->intensity,
            'bmr' => round($bmr, 2),
            'tdee' => round($tdee, 2),
            'target_calories' => $targetCalories,
            'protein_g' => $macros['protein_g'],
            'carbs_g' => $macros['carbs_g'],
            'fat_g' => $macros['fat_g'],
        ];
    }

    protected function calculateBmr(string $sex, float $weightKg, float $heightCm, int $age): float
    {
        if ($sex === 'male') {
            return (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) + 5;
        }

        if ($sex === 'female') {
            return (10 * $weightKg) + (6.25 * $heightCm) - (5 * $age) - 161;
        }

        throw new InvalidArgumentException('Invalid sex value.');
    }

    protected function getActivityFactor(string $activityLevel): float
    {
        return match ($activityLevel) {
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
            default => throw new InvalidArgumentException('Invalid activity level.'),
        };
    }

    protected function calculateTargetCalories(float $tdee, string $goal, string $intensity): int
    {
        $adjustment = match ($intensity) {
            'mild' => 250,
            'moderate' => 500,
            'aggressive' => 750,
            default => throw new InvalidArgumentException('Invalid intensity value.'),
        };

        $target = match ($goal) {
            'cut' => $tdee - $adjustment,
            'bulk' => $tdee + $adjustment,
            default => throw new InvalidArgumentException('Invalid goal value.'),
        };

        return max(1200, (int) round($target));
    }

    protected function calculateMacros(int $targetCalories, string $goal): array
    {
        $ratios = match ($goal) {
            'cut' => [
                'protein' => 0.35,
                'carbs' => 0.40,
                'fat' => 0.25,
            ],
            'bulk' => [
                'protein' => 0.25,
                'carbs' => 0.50,
                'fat' => 0.25,
            ],
            default => throw new InvalidArgumentException('Invalid goal value.'),
        };

        $proteinCalories = $targetCalories * $ratios['protein'];
        $carbsCalories = $targetCalories * $ratios['carbs'];
        $fatCalories = $targetCalories * $ratios['fat'];

        return [
            'protein_g' => (int) round($proteinCalories / 4),
            'carbs_g' => (int) round($carbsCalories / 4),
            'fat_g' => (int) round($fatCalories / 9),
        ];
    }
}