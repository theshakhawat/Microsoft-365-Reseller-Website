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
        Schema::create('app_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete(); // null for super admins/system-wide
            $table->string('target_role')->nullable(); // 'admin', 'user', or null
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // 'order', 'payment', 'ticket', 'subscription', 'system', 'info'
            $table->string('action_url')->nullable();
            $table->string('icon')->default('fa-solid fa-bell');
            $table->string('color')->default('blue'); // 'blue', 'emerald', 'amber', 'rose', 'purple'
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_notifications');
    }
};
