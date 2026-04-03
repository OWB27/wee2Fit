<?php

namespace Tests\Unit;

use App\Models\Profile;
use App\Services\PlanGeneratorService;
use Carbon\Carbon;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PlanGeneratorServiceTest extends TestCase
{
    #[Test]
    public function it_generates_expected_plan_values_from_a_profile(): void
    {
        Carbon::setTestNow('2026-04-03');

        $profile = new Profile([
            'sex' => 'male',
            'birth_date' => '2000-04-03',
            'height_cm' => '180.0',
            'current_weight_kg' => '80.0',
            'activity_level' => 'moderate',
            'goal' => 'cut',
            'intensity' => 'moderate',
        ]);

        $service = new PlanGeneratorService();

        $plan = $service->generateFromProfile($profile);

        $this->assertSame(26, $plan['age']);
        $this->assertSame(1800.0, $plan['bmr']);
        $this->assertSame(2790.0, $plan['tdee']);
        $this->assertSame(2290, $plan['target_calories']);
        $this->assertSame(200, $plan['protein_g']);
        $this->assertSame(229, $plan['carbs_g']);
        $this->assertSame(64, $plan['fat_g']);

        Carbon::setTestNow();
    }

    #[Test]
    public function it_requires_a_birth_date_to_generate_a_plan(): void
    {
        $profile = new Profile([
            'sex' => 'female',
            'height_cm' => '165.0',
            'current_weight_kg' => '55.0',
            'activity_level' => 'light',
            'goal' => 'bulk',
            'intensity' => 'mild',
        ]);

        $service = new PlanGeneratorService();

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Profile birth date is required.');

        $service->generateFromProfile($profile);
    }
}
