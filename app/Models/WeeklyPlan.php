<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyPlan extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'week_start_date',
        'is_finalized',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'week_start_date' => 'date',
            'is_finalized' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function weeklyPlanFoods()
    {
        return $this->hasMany(WeeklyPlanFood::class);
    }

    public function foods()
    {
        return $this->belongsToMany(Food::class, 'weekly_plan_foods')
            ->withPivot(['day_of_week', 'meal_type', 'amount_g'])
            ->withTimestamps();
    }
}