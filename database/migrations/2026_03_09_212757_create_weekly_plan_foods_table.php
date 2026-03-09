<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weekly_plan_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();

            $table->unsignedTinyInteger('day_of_week');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->decimal('amount_g', 8, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weekly_plan_foods');
    }
};