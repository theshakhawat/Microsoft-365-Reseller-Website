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
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->text('merchant_key')->nullable()->after('instruction');
            $table->string('base_url')->nullable()->after('merchant_key');
            $table->text('api_secret')->nullable()->after('base_url');
            $table->string('mode')->default('live')->after('api_secret'); // sandbox / live
            $table->json('additional_settings')->nullable()->after('mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->dropColumn(['merchant_key', 'base_url', 'api_secret', 'mode', 'additional_settings']);
        });
    }
};
