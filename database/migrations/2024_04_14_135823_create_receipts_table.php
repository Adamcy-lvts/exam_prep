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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->onDelete('cascade')->unique(); // Reference to the transaction
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('payment_date');
            $table->string('receipt_for');
            $table->decimal('amount', 8, 2);
            $table->text('remarks')->nullable();
            $table->string('qr_code')->nullable(); // if you want to store QR code data/path
            $table->string('receipt_number')->unique(); // Unique receipt number
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
