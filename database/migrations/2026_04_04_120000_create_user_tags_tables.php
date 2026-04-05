<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        Schema::create('user_tag_user', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_tag_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'user_tag_id']);
        });

        DB::table('user_tags')->insert([
            [
                'name' => 'New User',
                'slug' => 'new_user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Highly Active',
                'slug' => 'highly_active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Inactive Risk',
                'slug' => 'inactive_risk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test Account',
                'slug' => 'test_account',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('user_tag_user');
        Schema::dropIfExists('user_tags');
    }
};
