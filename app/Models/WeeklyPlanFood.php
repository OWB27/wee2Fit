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
}