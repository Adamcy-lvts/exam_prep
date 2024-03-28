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
        Schema::create('topic_quiz_time_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('topic_quiz_attempt_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('time_spent')->default(0); // Time spent on the question in seconds
            $table->timestamp('question_start_time')->nullable(); // When the user started the question
            $table->timestamp('question_end_time')->nullable(); // When the user ended/submitted the question
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topic_quiz_time_trackings');
    }
};
