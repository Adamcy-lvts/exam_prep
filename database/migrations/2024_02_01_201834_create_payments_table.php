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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->decimal('amount', 8, 2);
            $table->decimal('split_amount_agent', 10, 2)->nullable();
            $table->decimal('net_amount', 10, 2)->nullable();
            $table->decimal('paystack_fee', 8, 2)->nullable();
            $table->string('split_code')->nullable();
            $table->string('method'); // 'bank_transfer', 'card'
            $table->foreignId('plan_id')->nullable()->constrained('plans');
            $table->string('payment_for')->nullable();
            $table->string('card_type')->nullable();
            $table->string('bank')->nullable();
            $table->string('authorization_code')->nullable();
            $table->string('last_4_digits')->nullable();
            $table->integer('attempts_purchased')->nullable();
            $table->string('status'); // 'pending', 'completed', 'failed'
            $table->string('transaction_ref')->nullable();
            $table->string('proof_of_payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
