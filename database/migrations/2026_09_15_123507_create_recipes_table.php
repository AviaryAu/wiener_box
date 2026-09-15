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
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category');
            $table->text('description');
            $table->string('image');
            $table->string('image_alt');
            $table->unsignedSmallInteger('prep_minutes');
            $table->unsignedSmallInteger('cook_minutes');
            $table->unsignedSmallInteger('servings');
            $table->json('ingredients');
            $table->json('method');
            $table->text('tip');
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false)->index();
            $table->unsignedSmallInteger('position')->default(0);
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
