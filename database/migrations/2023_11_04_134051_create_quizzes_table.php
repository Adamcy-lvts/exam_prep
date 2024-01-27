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
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->morphs('quizzable'); // Polymorphic relation to either a course or subject
            $table->unsignedInteger('duration');
            $table->unsignedInteger('total_marks');
            $table->unsignedInteger('total_questions');
            $table->unsignedInteger('max_attempts')->default(1);
            $table->json('additional_config')->nullable(); // Store additional JSON config if needed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
