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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('quiz_id')->constrained('quizzes');
            $table->foreignId('composite_quiz_session_id')->nullable()->constrained();
            $table->foreignId('quiz_session_id')->nullable()->constrained();
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            $table->unsignedInteger('score')->default(0);
            $table->integer('total_questions')->default(50);
            $table->decimal('total_marks', 8, 2)->default(0);
            $table->decimal('scored_marks', 8, 2)->default(0);
            $table->enum('status', ['in progress', 'completed'])->default('in progress');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};
