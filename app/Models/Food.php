<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Food extends Model
{
    protected $table = 'foods';

    public const CATEGORY_OPTIONS = [
        'protein',
        'carb',
        'fat',
        'vegetable',
        'fruit',
        'dairy',
        'beverage',
        'snack',
        'other',
    ];

    protected $fillable = [
        'name',
        'name_zh',
        'category',
        'calories_per_100g',
        'protein_per_100g',
        'carbs_per_100g',
        'fat_per_100g',
        'image_path',
        'is_verified',
    ];

    protected function casts(): array
    {
        return [
            'calories_per_100g' => 'decimal:2',
            'protein_per_100g' => 'decimal:2',
            'carbs_per_100g' => 'decimal:2',
            'fat_per_100g' => 'decimal:2',
            'is_verified' => 'boolean',
        ];
    }

    public function weeklyPlanFoods()
    {
        return $this->hasMany(WeeklyPlanFood::class);
    }

    public function displayName(): string
    {
        if (App::currentLocale() === 'zh_CN' && ! empty($this->name_zh)) {
            return $this->name_zh;
        }

        return $this->name;
    }
}