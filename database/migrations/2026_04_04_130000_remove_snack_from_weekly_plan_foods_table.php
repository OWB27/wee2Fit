<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('weekly_plan_foods_tmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner']);
            $table->decimal('amount_g', 8, 2);
            $table->timestamps();
        });

        DB::table('weekly_plan_foods_tmp')->insertUsing(
            ['id', 'weekly_plan_id', 'food_id', 'day_of_week', 'meal_type', 'amount_g', 'created_at', 'updated_at'],
            DB::table('weekly_plan_foods')
                ->select('id', 'weekly_plan_id', 'food_id', 'day_of_week', 'meal_type', 'amount_g', 'created_at', 'updated_at')
                ->where('meal_type', '!=', 'snack')
        );

        Schema::drop('weekly_plan_foods');
        Schema::rename('weekly_plan_foods_tmp', 'weekly_plan_foods');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('weekly_plan_foods_tmp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('weekly_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete();
            $table->unsignedTinyInteger('day_of_week');
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);
            $table->decimal('amount_g', 8, 2);
            $table->timestamps();
        });

        DB::table('weekly_plan_foods_tmp')->insertUsing(
            ['id', 'weekly_plan_id', 'food_id', 'day_of_week', 'meal_type', 'amount_g', 'created_at', 'updated_at'],
            DB::table('weekly_plan_foods')
                ->select('id', 'weekly_plan_id', 'food_id', 'day_of_week', 'meal_type', 'amount_g', 'created_at', 'updated_at')
        );

        Schema::drop('weekly_plan_foods');
        Schema::rename('weekly_plan_foods_tmp', 'weekly_plan_foods');

        Schema::enableForeignKeyConstraints();
    }
};
