<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->enum('category', [
                'protein',
                'carb',
                'fat',
                'vegetable',
                'fruit',
                'dairy',
                'beverage',
                'snack',
                'other',
            ])->nullable();

            $table->decimal('calories_per_100g', 8, 2);
            $table->decimal('protein_per_100g', 8, 2)->default(0);
            $table->decimal('carbs_per_100g', 8, 2)->default(0);
            $table->decimal('fat_per_100g', 8, 2)->default(0);

            $table->string('image_path')->nullable();
            $table->boolean('is_verified')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};