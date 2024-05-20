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
        Schema::create('referral_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained('agent_user');
            $table->decimal('amount', 10, 2);
            $table->string('split_code')->nullable();
            $table->string('status')->default('completed');
            $table->dateTime('payment_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_payments');
    }
};
