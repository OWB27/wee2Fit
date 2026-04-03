<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WeeklyPlan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyPlanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_a_weekly_plan(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('weekly-plans.store'), [
                'title' => 'Lean Week',
                'week_start_date' => '2026-04-06',
                'note' => 'Keep meals simple.',
                'is_finalized' => '1',
            ]);

        $weeklyPlan = WeeklyPlan::first();

        $response
            ->assertRedirect(route('weekly-plans.show', $weeklyPlan))
            ->assertSessionHas('success', __('messages.weekly_plan_created'));

        $this->assertDatabaseHas('weekly_plans', [
            'user_id' => $user->id,
            'title' => 'Lean Week',
            'is_finalized' => true,
        ]);
    }

    public function test_user_cannot_view_another_users_weekly_plan(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $weeklyPlan = WeeklyPlan::create([
            'user_id' => $owner->id,
            'title' => 'Owner Week',
            'week_start_date' => '2026-04-06',
            'is_finalized' => false,
            'note' => null,
        ]);

        $response = $this
            ->actingAs($intruder)
            ->get(route('weekly-plans.show', $weeklyPlan));

        $response->assertForbidden();
    }
}
