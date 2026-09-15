<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->unique()->constrained('lunar_products')->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('category');
            $table->string('eyebrow');
            $table->string('colour')->default('mustard');
            $table->string('cadence')->default('one-off');
            $table->text('story');
            $table->json('highlights');
            $table->json('contents');
            $table->boolean('featured')->default(false);
            $table->boolean('published')->default(false);
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });
        Schema::create('delivery_areas', function (Blueprint $table) {
            $table->id();
            $table->string('postcode', 4)->unique();
            $table->string('suburb');
            $table->string('status')->default('planned');
            $table->unsignedInteger('price')->default(1200);
            $table->timestamps();
        });
        Schema::create('waitlist_entries', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('postcode', 4);
            $table->string('interest')->default('subscription');
            $table->timestamp('consented_at');
            $table->string('consent_version')->default('launch-v1');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('waitlist_entries');
        Schema::dropIfExists('delivery_areas');
        Schema::dropIfExists('product_listings');
    }
};
