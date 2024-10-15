<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('instructions');
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->integer('cook_time_minutes')->nullable();
            $table->integer('prep_time_minutes')->nullable();
            $table->integer('num_servings')->nullable();
            $table->integer('calories')->nullable();
            $table->json('nutrition')->nullable();
            $table->string('original_video_url')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};
