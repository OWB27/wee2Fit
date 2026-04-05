<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'sex',
        'height_cm',
        'weight_kg',
        'activity_level',
        'goal',
        'intensity',
        'bmr',
        'tdee',
        'target_calories',
        'protein_g',
        'carbs_g',
        'fat_g',
        'is_current',
    ];

    protected function casts(): array
    {
        return [
            'height_cm' => 'decimal:1',
            'weight_kg' => 'decimal:1',
            'bmr' => 'decimal:2',
            'tdee' => 'decimal:2',
            'is_current' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
