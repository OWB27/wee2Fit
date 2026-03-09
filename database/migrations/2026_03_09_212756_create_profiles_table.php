<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('sex', ['male', 'female'])->nullable();
            $table->date('birth_date')->nullable();
            $table->decimal('height_cm', 5, 2)->nullable();
            $table->decimal('current_weight_kg', 5, 2)->nullable();

            $table->enum('activity_level', [
                'sedentary',
                'light',
                'moderate',
                'active',
                'very_active',
            ])->nullable();

            $table->enum('goal', ['cut', 'bulk'])->nullable();
            $table->enum('intensity', ['mild', 'moderate', 'aggressive'])->nullable();

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};