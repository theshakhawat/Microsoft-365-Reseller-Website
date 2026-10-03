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
        Schema::create('included_apps', function (Blueprint $table) {
            $table->id();
            $table->string('category')->default('productivity'); // 'productivity' or 'security'
            $table->string('name');
            $table->string('tagline');
            $table->text('description');
            $table->string('icon_image')->nullable();
            $table->string('link_url')->nullable()->default('#plans');
            $table->string('link_text')->default('Learn more');
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
        Schema::dropIfExists('included_apps');
    }
};
