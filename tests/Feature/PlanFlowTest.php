<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_generate_plan_page_redirects_users_without_profile(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('plans.create'));

        $response
            ->assertRedirect(route('my-profile.edit'))
            ->assertSessionHas('error', __('messages.plan_profile_required'));
    }

    public function test_storing_a_plan_creates_a_new_current_plan_and_clears_the_old_one(): void
    {
        $user = User::factory()->create();

        $user->profile()->create([
            'sex' => 'male',
            'birth_date' => '2000-04-03',
            'height_cm' => '180.0',
            'current_weight_kg' => '80.0',
            'activity_level' => 'moderate',
            'goal' => 'cut',
            'intensity' => 'moderate',
        ]);

        $oldPlan = $user->plans()->create([
            'age' => 20,
            'sex' => 'male',
            'height_cm' => 180,
            'weight_kg' => 80,
            'activity_level' => 'light',
            'goal' => 'bulk',
            'intensity' => 'mild',
            'bmr' => 1700,
            'tdee' => 2300,
            'target_calories' => 2550,
            'protein_g' => 160,
            'carbs_g' => 319,
            'fat_g' => 71,
            'is_current' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('plans.store'));

        $response
            ->assertRedirect(route('plans.current'))
            ->assertSessionHas('success', __('messages.plan_generated_success'));

        $oldPlan->refresh();

        $this->assertFalse($oldPlan->is_current);
        $this->assertEquals(2, $user->plans()->count());

        $this->assertDatabaseCount('plans', 2);
        $this->assertDatabaseHas('plans', [
            'user_id' => $user->id,
            'is_current' => true,
            'goal' => 'cut',
            'intensity' => 'moderate',
        ]);
    }
}
