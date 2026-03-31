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
        Schema::create('traders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('trader_name');
            $table->text('description')->nullable();
            $table->string('avatar')->nullable();
            $table->decimal('daily_roi', 8, 2);
            $table->decimal('min_amount', 16, 2);
            $table->decimal('max_amount', 16, 2)->nullable();
            $table->enum('risk_level', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('traders');
    }
};
