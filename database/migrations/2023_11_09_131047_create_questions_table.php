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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->nullable()->constrained()->onDelete('cascade');
            $table->morphs('quizzable');
            $table->foreignId('topic_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('question_instruction_id')->nullable()->constrained('question_instructions')->onDelete('set null');
            $table->integer('duration')->nullable();
            $table->text('question');
            $table->enum('type', ['mcq', 'saq', 'tf'])->default('mcq'); // mcq = Multiple Choice Questions, saq = Short Answer Questions
            $table->text('answer_text')->nullable(); // Correct answer For storing short answers
            $table->text('explanation')->nullable();
            $table->string('question_image')->nullable();
            $table->integer('marks')->default(1);
            $table->year('year')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
