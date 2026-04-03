<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeeklyPlanFoodAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_add_a_food_to_their_weekly_plan(): void
    {
        $user = User::factory()->create();
        $weeklyPlan = WeeklyPlan::create([
            'user_id' => $user->id,
            'title' => 'Cut Week',
            'week_start_date' => '2026-04-06',
            'is_finalized' => false,
            'note' => 'Test plan',
        ]);

        $food = Food::create([
            'name' => 'Chicken Breast',
            'name_zh' => 'ji xiong rou',
            'category' => 'protein',
            'calories_per_100g' => 165,
            'protein_per_100g' => 31,
            'carbs_per_100g' => 0,
            'fat_per_100g' => 3.6,
            'image_path' => null,
            'is_verified' => true,
        ]);

        $response = $this
            ->actingAs($user)
            ->post(route('weekly-plan-foods.store', $weeklyPlan), [
                'food_id' => $food->id,
                'day_of_week' => 1,
                'meal_type' => 'lunch',
                'amount_g' => 200,
            ]);

        $response
            ->assertRedirect(route('weekly-plans.show', $weeklyPlan))
            ->assertSessionHas('success', __('messages.weekly_plan_food_added'));

        $this->assertDatabaseHas('weekly_plan_foods', [
            'weekly_plan_id' => $weeklyPlan->id,
            'food_id' => $food->id,
            'day_of_week' => 1,
            'meal_type' => 'lunch',
        ]);

        $item = $weeklyPlan->fresh()->weeklyPlanFoods()->first();

        $this->assertNotNull($item);
        $this->assertEquals(200.0, (float) $item->amount_g);
    }

    public function test_user_cannot_add_food_to_another_users_weekly_plan(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $weeklyPlan = WeeklyPlan::create([
            'user_id' => $owner->id,
            'title' => 'Owner Plan',
            'week_start_date' => '2026-04-06',
            'is_finalized' => false,
            'note' => null,
        ]);

        $food = Food::create([
            'name' => 'Rice',
            'name_zh' => 'mi fan',
            'category' => 'carb',
            'calories_per_100g' => 130,
            'protein_per_100g' => 2.7,
            'carbs_per_100g' => 28,
            'fat_per_100g' => 0.3,
            'image_path' => null,
            'is_verified' => true,
        ]);

        $response = $this
            ->actingAs($intruder)
            ->post(route('weekly-plan-foods.store', $weeklyPlan), [
                'food_id' => $food->id,
                'day_of_week' => 2,
                'meal_type' => 'dinner',
                'amount_g' => 150,
            ]);

        $response->assertForbidden();

        $this->assertDatabaseMissing('weekly_plan_foods', [
            'weekly_plan_id' => $weeklyPlan->id,
            'food_id' => $food->id,
        ]);
    }

    public function test_owner_can_delete_a_food_from_their_weekly_plan(): void
    {
        $user = User::factory()->create();

        $weeklyPlan = WeeklyPlan::create([
            'user_id' => $user->id,
            'title' => 'Delete Test Plan',
            'week_start_date' => '2026-04-06',
            'is_finalized' => false,
            'note' => null,
        ]);

        $food = Food::create([
            'name' => 'Eggs',
            'name_zh' => 'ji dan',
            'category' => 'protein',
            'calories_per_100g' => 155,
            'protein_per_100g' => 13,
            'carbs_per_100g' => 1.1,
            'fat_per_100g' => 11,
            'image_path' => null,
            'is_verified' => true,
        ]);

        $weeklyPlanFood = WeeklyPlanFood::create([
            'weekly_plan_id' => $weeklyPlan->id,
            'food_id' => $food->id,
            'day_of_week' => 3,
            'meal_type' => 'breakfast',
            'amount_g' => 120,
        ]);

        $response = $this
            ->actingAs($user)
            ->delete(route('weekly-plan-foods.destroy', $weeklyPlanFood));

        $response
            ->assertRedirect(route('weekly-plans.show', $weeklyPlan))
            ->assertSessionHas('success', __('messages.weekly_plan_food_deleted'));

        $this->assertDatabaseMissing('weekly_plan_foods', [
            'id' => $weeklyPlanFood->id,
        ]);
    }

    public function test_user_cannot_delete_food_from_another_users_weekly_plan(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $weeklyPlan = WeeklyPlan::create([
            'user_id' => $owner->id,
            'title' => 'Owner Plan',
            'week_start_date' => '2026-04-06',
            'is_finalized' => false,
            'note' => null,
        ]);

        $food = Food::create([
            'name' => 'Avocado',
            'name_zh' => 'niu you guo',
            'category' => 'fat',
            'calories_per_100g' => 160,
            'protein_per_100g' => 2,
            'carbs_per_100g' => 9,
            'fat_per_100g' => 15,
            'image_path' => null,
            'is_verified' => true,
        ]);

        $weeklyPlanFood = WeeklyPlanFood::create([
            'weekly_plan_id' => $weeklyPlan->id,
            'food_id' => $food->id,
            'day_of_week' => 4,
            'meal_type' => 'dinner',
            'amount_g' => 150,
        ]);

        $response = $this
            ->actingAs($intruder)
            ->delete(route('weekly-plan-foods.destroy', $weeklyPlanFood));

        $response->assertForbidden();

        $this->assertDatabaseHas('weekly_plan_foods', [
            'id' => $weeklyPlanFood->id,
        ]);
    }
}
