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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 16, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'repaid'])->default('pending');
            $table->text('admin_note')->nullable();
            $table->decimal('outstanding_amount', 16, 2)->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('repaid_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
