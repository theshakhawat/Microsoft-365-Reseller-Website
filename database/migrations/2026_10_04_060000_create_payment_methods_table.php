<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('payment_methods', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('slug')->unique();
			$table->string('logo')->nullable();
			$table->text('instruction')->nullable();
			$table->unsignedInteger('sort_order')->default(0);
			$table->boolean('status')->default(true);
			$table->timestamps();
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('payment_methods');
	}
};
