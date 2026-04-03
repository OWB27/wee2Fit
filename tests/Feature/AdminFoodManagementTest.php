<?php

namespace Tests\Feature;

use App\Models\Food;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminFoodManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_food(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($admin)
            ->post(route('admin.foods.store'), [
                'name' => 'Oats',
                'name_zh' => 'yan mai',
                'category' => 'carb',
                'calories_per_100g' => 389,
                'protein_per_100g' => 16.9,
                'carbs_per_100g' => 66.3,
                'fat_per_100g' => 6.9,
                'image_path' => 'foods/oats.jpg',
                'is_verified' => '1',
            ]);

        $response
            ->assertRedirect(route('admin.foods.index'))
            ->assertSessionHas('success', __('messages.admin_food_created'));

        $this->assertDatabaseHas('foods', [
            'name' => 'Oats',
            'category' => 'carb',
            'is_verified' => true,
        ]);
    }

    public function test_admin_can_update_a_food(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $food = $this->createFood([
            'name' => 'Milk',
            'category' => 'dairy',
            'is_verified' => false,
        ]);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.foods.update', $food), [
                'name' => 'Skim Milk',
                'name_zh' => 'tuo zhi niu nai',
                'category' => 'dairy',
                'calories_per_100g' => 34,
                'protein_per_100g' => 3.4,
                'carbs_per_100g' => 5,
                'fat_per_100g' => 0.1,
                'image_path' => null,
                'is_verified' => '1',
            ]);

        $response
            ->assertRedirect(route('admin.foods.index'))
            ->assertSessionHas('success', __('messages.admin_food_updated'));

        $this->assertDatabaseHas('foods', [
            'id' => $food->id,
            'name' => 'Skim Milk',
            'is_verified' => true,
        ]);
    }

    public function test_regular_user_cannot_access_admin_food_management(): void
    {
        $member = User::factory()->create([
            'role' => User::ROLE_USER,
            'is_active' => true,
        ]);

        $response = $this
            ->actingAs($member)
            ->get(route('admin.foods.index'));

        $response->assertForbidden();
    }

    public function test_admin_can_delete_a_food(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $food = $this->createFood([
            'name' => 'Peanut Butter',
            'category' => 'fat',
        ]);

        $response = $this
            ->actingAs($admin)
            ->delete(route('admin.foods.destroy', $food));

        $response
            ->assertRedirect(route('admin.foods.index'))
            ->assertSessionHas('success', __('messages.admin_food_deleted'));

        $this->assertDatabaseMissing('foods', [
            'id' => $food->id,
        ]);
    }

    private function createFood(array $attributes = []): Food
    {
        return Food::create(array_merge([
            'name' => 'Test Food',
            'name_zh' => null,
            'category' => 'other',
            'calories_per_100g' => 100,
            'protein_per_100g' => 10,
            'carbs_per_100g' => 10,
            'fat_per_100g' => 5,
            'image_path' => null,
            'is_verified' => true,
        ], $attributes));
    }
}
