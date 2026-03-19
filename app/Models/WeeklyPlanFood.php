<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlanFood extends Model
{
    protected $table = 'weekly_plan_foods';

    public const MEAL_TYPE_OPTIONS = ['breakfast', 'lunch', 'dinner', 'snack'];

    protected $fillable = [
        'weekly_plan_id',
        'food_id',
        'day_of_week',
        'meal_type',
        'amount_g',
    ];

    protected function casts(): array
    {
        return [
            'amount_g' => 'decimal:2',
        ];
    }

    public function weeklyPlan()
    {
        return $this->belongsTo(WeeklyPlan::class);
    }

    public function food()
    {
        return $this->belongsTo(Food::class);
    }

    public function calories(): float
    {
        return ((float) $this->food->calories_per_100g) * ((float) $this->amount_g) / 100;
    }

    public function proteinGrams(): float
    {
        return ((float) $this->food->protein_per_100g) * ((float) $this->amount_g) / 100;
    }

    public function carbsGrams(): float
    {
        return ((float) $this->food->carbs_per_100g) * ((float) $this->amount_g) / 100;
    }

    public function fatGrams(): float
    {
        return ((float) $this->food->fat_per_100g) * ((float) $this->amount_g) / 100;
    }
}