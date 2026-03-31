<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('investment_plan_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 16, 2);
            $table->decimal('roi_percentage', 8, 2);
            $table->decimal('expected_payout', 16, 2);
            $table->integer('duration_days');
            $table->string('status')->default('active'); // active, completed, cancelled
            $table->text('admin_note')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
