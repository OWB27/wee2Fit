<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public const SEX_OPTIONS = ['male', 'female'];
    public const ACTIVITY_LEVEL_OPTIONS = [
        'sedentary',
        'light',
        'moderate',
        'active',
        'very_active',
    ];
    public const GOAL_OPTIONS = ['cut', 'bulk'];
    public const INTENSITY_OPTIONS = ['mild', 'moderate', 'aggressive'];

    protected $fillable = [
        'user_id',
        'sex',
        'birth_date',
        'height_cm',
        'current_weight_kg',
        'activity_level',
        'goal',
        'intensity',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'height_cm' => 'decimal:1',
            'current_weight_kg' => 'decimal:1',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
