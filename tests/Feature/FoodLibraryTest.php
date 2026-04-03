<?php

namespace Tests\Feature;

use App\Models\Food;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoodLibraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_the_food_library(): void
    {
        $food = $this->createFood([
            'name' => 'Greek Yogurt',
            'category' => 'dairy',
        ]);

        $response = $this->get(route('foods.index'));

        $response
            ->assertOk()
            ->assertSeeText('Greek Yogurt')
            ->assertSee(route('foods.show', $food), false);
    }

    public function test_food_library_can_be_filtered_by_category(): void
    {
        $proteinFood = $this->createFood([
            'name' => 'Chicken Breast',
            'category' => 'protein',
        ]);

        $carbFood = $this->createFood([
            'name' => 'Brown Rice',
            'category' => 'carb',
        ]);

        $response = $this->get(route('foods.index', ['category' => 'protein']));

        $response
            ->assertOk()
            ->assertSeeText($proteinFood->name)
            ->assertDontSeeText($carbFood->name);
    }

    public function test_guest_can_view_a_food_detail_page(): void
    {
        $food = $this->createFood([
            'name' => 'Salmon',
            'name_zh' => 'san wen yu',
            'category' => 'protein',
            'protein_per_100g' => 20,
            'fat_per_100g' => 13,
        ]);

        $response = $this->get(route('foods.show', $food));

        $response
            ->assertOk()
            ->assertSeeText('Salmon')
            ->assertSeeText('20.00 g')
            ->assertSeeText('13.00 g');
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
