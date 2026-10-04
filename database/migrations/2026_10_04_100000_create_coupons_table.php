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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage'); // 'percentage' or 'fixed' (flat)
            $table->decimal('discount_value', 10, 2); // e.g. 20 (for 20%) or 500 (for 500 BDT)
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->decimal('max_discount_amount', 10, 2)->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('expire_date')->nullable();
            $table->unsignedInteger('max_uses')->nullable(); // null = unlimited total uses
            $table->unsignedInteger('max_uses_per_user')->default(1)->nullable(); // null or number of times per user
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
