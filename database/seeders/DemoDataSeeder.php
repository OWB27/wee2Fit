<?php

namespace Database\Seeders;

use App\Models\BodyMetric;
use App\Models\Food;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\User;
use App\Models\WeeklyPlan;
use App\Models\WeeklyPlanFood;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Admin user
        $admin = User::updateOrCreate(
            ['email' => 'admin@wee2fit.test'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 2) Normal user
        $user = User::updateOrCreate(
            ['email' => 'user@wee2fit.test'],
            [
                'name' => 'Demo User',
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        // 3) Foods
        $foodsData = [
            [
                'name' => 'Chicken Breast',
                'name_zh' => '鸡胸肉',
                'category' => 'protein',
                'calories_per_100g' => 165,
                'protein_per_100g' => 31,
                'carbs_per_100g' => 0,
                'fat_per_100g' => 3.6,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Rice',
                'name_zh' => '米饭',
                'category' => 'carb',
                'calories_per_100g' => 130,
                'protein_per_100g' => 2.7,
                'carbs_per_100g' => 28.0,
                'fat_per_100g' => 0.3,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Broccoli',
                'name_zh' => '西兰花',
                'category' => 'vegetable',
                'calories_per_100g' => 34,
                'protein_per_100g' => 2.8,
                'carbs_per_100g' => 6.6,
                'fat_per_100g' => 0.4,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Banana',
                'name_zh' => '香蕉',
                'category' => 'fruit',
                'calories_per_100g' => 89,
                'protein_per_100g' => 1.1,
                'carbs_per_100g' => 22.8,
                'fat_per_100g' => 0.3,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Egg',
                'name_zh' => '鸡蛋',
                'category' => 'protein',
                'calories_per_100g' => 155,
                'protein_per_100g' => 13,
                'carbs_per_100g' => 1.1,
                'fat_per_100g' => 11,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Greek Yogurt',
                'name_zh' => '希腊酸奶',
                'category' => 'dairy',
                'calories_per_100g' => 59,
                'protein_per_100g' => 10.0,
                'carbs_per_100g' => 3.6,
                'fat_per_100g' => 0.4,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Oats',
                'name_zh' => '燕麦',
                'category' => 'carb',
                'calories_per_100g' => 389,
                'protein_per_100g' => 16.9,
                'carbs_per_100g' => 66.3,
                'fat_per_100g' => 6.9,
                'image_path' => null,
                'is_verified' => true,
            ],
            [
                'name' => 'Almonds',
                'name_zh' => '杏仁',
                'category' => 'fat',
                'calories_per_100g' => 579,
                'protein_per_100g' => 21.2,
                'carbs_per_100g' => 21.6,
                'fat_per_100g' => 49.9,
                'image_path' => null,
                'is_verified' => true,
            ],
        ];

        $foods = collect($foodsData)->map(function (array $foodData) {
            return Food::updateOrCreate(
                ['name' => $foodData['name']],
                $foodData
            );
        });

        $foodMap = $foods->keyBy('name');

        // 4) Profile for normal user
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'sex' => 'male',
                'birth_date' => '2004-05-20',
                'height_cm' => 175.5,
                'current_weight_kg' => 70.2,
                'activity_level' => 'moderate',
                'goal' => 'cut',
                'intensity' => 'mild',
            ]
        );

        // 5) Current plan for normal user
        $user->plans()->update(['is_current' => false]);

        Plan::updateOrCreate(
            [
                'user_id' => $user->id,
                'is_current' => true,
            ],
            [
                'age' => 20,
                'sex' => 'male',
                'height_cm' => 175.5,
                'weight_kg' => 70.2,
                'activity_level' => 'moderate',
                'goal' => 'cut',
                'intensity' => 'mild',
                'bmr' => 1671.38,
                'tdee' => 2590.64,
                'target_calories' => 2341,
                'protein_g' => 205,
                'carbs_g' => 234,
                'fat_g' => 65,
            ]
        );

        // 6) Body metrics
        $metricsData = [
            [
                'recorded_on' => '2026-03-01',
                'weight_kg' => 72.0,
                'body_fat_percentage' => 19.5,
                'note' => 'Start of month',
            ],
            [
                'recorded_on' => '2026-03-08',
                'weight_kg' => 71.3,
                'body_fat_percentage' => 19.0,
                'note' => 'Weekly check-in',
            ],
            [
                'recorded_on' => '2026-03-15',
                'weight_kg' => 70.8,
                'body_fat_percentage' => 18.7,
                'note' => 'Progress is stable',
            ],
            [
                'recorded_on' => '2026-03-21',
                'weight_kg' => 70.2,
                'body_fat_percentage' => 18.4,
                'note' => 'Latest measurement',
            ],
        ];

        foreach ($metricsData as $metricData) {
            BodyMetric::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'recorded_on' => $metricData['recorded_on'],
                ],
                [
                    'weight_kg' => $metricData['weight_kg'],
                    'body_fat_percentage' => $metricData['body_fat_percentage'],
                    'note' => $metricData['note'],
                ]
            );
        }

        // 7) Weekly plan
        $weeklyPlan = WeeklyPlan::updateOrCreate(
            [
                'user_id' => $user->id,
                'title' => 'Week 1 Cutting Plan',
            ],
            [
                'week_start_date' => '2026-03-16',
                'is_finalized' => false,
                'note' => 'Demo weekly plan for testing planner UI.',
            ]
        );

        // Clear old demo items for this weekly plan
        $weeklyPlan->weeklyPlanFoods()->delete();

        // 8) Weekly plan foods
        $weeklyPlanFoodsData = [
            [
                'food_id' => $foodMap['Oats']->id,
                'day_of_week' => 1,
                'meal_type' => 'breakfast',
                'amount_g' => 80,
            ],
            [
                'food_id' => $foodMap['Greek Yogurt']->id,
                'day_of_week' => 1,
                'meal_type' => 'breakfast',
                'amount_g' => 150,
            ],
            [
                'food_id' => $foodMap['Chicken Breast']->id,
                'day_of_week' => 1,
                'meal_type' => 'lunch',
                'amount_g' => 180,
            ],
            [
                'food_id' => $foodMap['Rice']->id,
                'day_of_week' => 1,
                'meal_type' => 'lunch',
                'amount_g' => 200,
            ],
            [
                'food_id' => $foodMap['Broccoli']->id,
                'day_of_week' => 1,
                'meal_type' => 'dinner',
                'amount_g' => 120,
            ],
            [
                'food_id' => $foodMap['Egg']->id,
                'day_of_week' => 2,
                'meal_type' => 'breakfast',
                'amount_g' => 120,
            ],
            [
                'food_id' => $foodMap['Banana']->id,
                'day_of_week' => 2,
                'meal_type' => 'lunch',
                'amount_g' => 120,
            ],
            [
                'food_id' => $foodMap['Almonds']->id,
                'day_of_week' => 3,
                'meal_type' => 'dinner',
                'amount_g' => 30,
            ],
        ];

        foreach ($weeklyPlanFoodsData as $itemData) {
            WeeklyPlanFood::create([
                'weekly_plan_id' => $weeklyPlan->id,
                'food_id' => $itemData['food_id'],
                'day_of_week' => $itemData['day_of_week'],
                'meal_type' => $itemData['meal_type'],
                'amount_g' => $itemData['amount_g'],
            ]);
        }
    }
}
