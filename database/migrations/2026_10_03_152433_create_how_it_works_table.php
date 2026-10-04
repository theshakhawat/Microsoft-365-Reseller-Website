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
        Schema::create('how_it_works', function (Blueprint $table) {
            $table->id();
            $table->string('step_number')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('icon')->default('fa-solid fa-cart-shopping');
            $table->string('icon_bg_color')->default('sky');
            $table->string('badge_text')->nullable();
            $table->string('badge_icon')->default('fa-solid fa-circle-check');
            $table->string('badge_color')->default('emerald');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('how_it_works');
    }
};
