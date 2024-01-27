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
        Schema::create('quiz_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->nullableMorphs('quizzable');
            $table->timestamp('start_time');
            $table->unsignedInteger('duration')->default(0);
            $table->integer('allowed_attempts')->default(0);
            $table->boolean('completed')->default(false);
            $table->unique(['user_id', 'quizzable_type', 'quizzable_id'], 'user_quizzable_unique');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_sessions');
    }
};
