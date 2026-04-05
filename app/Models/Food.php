<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

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

    public function imageUrl(): ?string
    {
        if (empty($this->image_path)) {
            return null;
        }

        if (Str::startsWith($this->image_path, ['http://', 'https://', '/'])) {
            return $this->image_path;
        }

        if (Str::startsWith($this->image_path, 'storage/')) {
            return asset($this->image_path);
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }

    public function categoryPillClass(): string
    {
        return match ($this->category) {
            'protein' => 'border-rose-200 bg-rose-50 text-rose-600',
            'carb' => 'border-amber-200 bg-amber-50 text-amber-600',
            'fat' => 'border-lime-200 bg-lime-50 text-lime-600',
            'vegetable' => 'border-emerald-200 bg-emerald-50 text-emerald-600',
            'fruit' => 'border-orange-200 bg-orange-50 text-orange-600',
            'dairy' => 'border-sky-200 bg-sky-50 text-sky-600',
            'beverage' => 'border-cyan-200 bg-cyan-50 text-cyan-600',
            'snack' => 'border-yellow-200 bg-yellow-50 text-yellow-700',
            default => 'border-slate-200 bg-slate-50 text-slate-600',
        };
    }

    public function categoryPlaceholderClass(): string
    {
        return match ($this->category) {
            'protein' => 'text-rose-500',
            'carb' => 'text-amber-500',
            'fat' => 'text-lime-500',
            'vegetable' => 'text-emerald-500',
            'fruit' => 'text-orange-500',
            'dairy' => 'text-sky-500',
            'beverage' => 'text-cyan-500',
            'snack' => 'text-yellow-500',
            default => 'text-slate-500',
        };
    }

    public function categoryPlaceholderLabel(): string
    {
        return match ($this->category) {
            'protein' => 'P',
            'carb' => 'C',
            'fat' => 'F',
            'vegetable' => 'V',
            'fruit' => 'FR',
            'dairy' => 'D',
            'beverage' => 'B',
            'snack' => 'S',
            default => 'O',
        };
    }

    public function formattedCaloriesPer100g(): string
    {
        return $this->formatNutritionNumber($this->calories_per_100g);
    }

    public function formattedProteinPer100g(): string
    {
        return $this->formatNutritionNumber($this->protein_per_100g);
    }

    public function formattedCarbsPer100g(): string
    {
        return $this->formatNutritionNumber($this->carbs_per_100g);
    }

    public function formattedFatPer100g(): string
    {
        return $this->formatNutritionNumber($this->fat_per_100g);
    }

    protected function formatNutritionNumber(string|float|int|null $value): string
    {
        return rtrim(rtrim((string) $value, '0'), '.');
    }
}
