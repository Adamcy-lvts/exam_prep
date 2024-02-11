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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['subject', 'course','composite'])->nullable(); // Type of the pricing plan
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 8, 2);
            $table->string('currency', 3)->default('NGN');
            $table->unsignedInteger('number_of_attempts')->nullable();
            $table->string('plan_basis')->default('attempts'); 
            $table->json('features')->nullable(); // Ensure your DB supports JSON columns
            $table->integer('validity_days')->nullable();
            $table->string('cto')->default('Purchase');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
