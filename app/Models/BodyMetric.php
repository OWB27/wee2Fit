<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    protected $fillable = [
        'user_id',
        'recorded_on',
        'weight_kg',
        'body_fat_percentage',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'recorded_on' => 'date',
            'weight_kg' => 'decimal:1',
            'body_fat_percentage' => 'decimal:1',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
