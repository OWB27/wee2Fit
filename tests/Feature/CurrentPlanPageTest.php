<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CurrentPlanPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_current_plan_page_redirects_when_user_has_no_current_plan(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('plans.current'));

        $response
            ->assertRedirect(route('plans.create'))
            ->assertSessionHas('error', __('messages.plan_not_found'));
    }

    public function test_current_plan_page_displays_the_users_current_plan(): void
    {
        $user = User::factory()->create();

        $user->plans()->create([
            'age' => 22,
            'sex' => 'female',
            'height_cm' => 168,
            'weight_kg' => 60,
            'activity_level' => 'moderate',
            'goal' => 'cut',
            'intensity' => 'mild',
            'bmr' => 1400,
            'tdee' => 2100,
            'target_calories' => 1850,
            'protein_g' => 120,
            'carbs_g' => 190,
            'fat_g' => 52,
            'is_current' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->get(route('plans.current'));

        $response
            ->assertOk()
            ->assertSeeText(__('messages.plan_current_title'))
            ->assertSeeText('1850')
            ->assertSeeText(__('messages.goal_cut'));
    }
}
