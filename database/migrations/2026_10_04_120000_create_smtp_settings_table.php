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
        Schema::create('smtp_settings', function (Blueprint $table) {
            $table->id();
            $table->string('mail_mailer')->default('smtp');
            $table->string('mail_host')->default('mail.microsoftoffice.club');
            $table->integer('mail_port')->default(465);
            $table->string('mail_username')->nullable("support@microsoftoffice.club");
            $table->text('mail_password')->nullable("P4Tifv05Ib3N2apf");
            $table->string('mail_encryption')->nullable()->default('tls');
            $table->string('mail_from_address')->default('support@microsoftoffice.club');
            $table->string('mail_from_name')->default('Microsoft Office Club');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_settings');
    }
};
