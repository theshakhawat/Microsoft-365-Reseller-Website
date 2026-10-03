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
        Schema::create('pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // e.g. Microsoft 365 Basic
            $table->string('badge')->nullable();         // e.g. Most Popular
            $table->string('price_bdt');                 // e.g. ৳2,490 or 2490
            $table->string('billing_period')->default('year'); // e.g. year / month
            $table->string('price_usd')->nullable();     // e.g. $19.99/yr
            $table->text('terms_text')->nullable();      // e.g. Subscription automatically renews...
            $table->string('button_text')->default('Buy now');
            $table->string('button_url')->nullable();    // WhatsApp link or checkout url
            $table->string('features_heading')->nullable(); // e.g. Microsoft 365 Basic includes:
            $table->json('features');                    // array of feature strings
            $table->json('included_apps')->nullable();   // array of app icon keys or paths (e.g. ['onedrive', 'outlook'])
            $table->boolean('is_featured')->default(false); // Highlight card with border / badge
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pricing_plans');
    }
};
