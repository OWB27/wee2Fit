<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // snapshot fields
            $table->unsignedInteger('age');
            $table->enum('sex', ['male', 'female']);
            $table->decimal('height_cm', 5, 2);
            $table->decimal('weight_kg', 5, 2);
            $table->string('activity_level');
            $table->enum('goal', ['cut', 'bulk']);
            $table->enum('intensity', ['mild', 'moderate', 'aggressive']);

            $table->decimal('bmr', 8, 2);
            $table->decimal('tdee', 8, 2);
            $table->unsignedInteger('target_calories');
            $table->unsignedInteger('protein_g');
            $table->unsignedInteger('carbs_g');
            $table->unsignedInteger('fat_g');

            $table->boolean('is_current')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};