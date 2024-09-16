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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('full_name')->virtualAs('concat(first_name, \' \', last_name)');
            $table->string('email')->unique();
            $table->enum('status', ['Active','Banned', 'Suspended', 'Blocked']);
            $table->string('phone')->nullable();
            $table->string('registration_status')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('is_on_trial')->default(true); // Indicates if the user is currently on a trial
            $table->date('trial_ends_at')->nullable(); //
            $table->string('password');
            $table->timestamp('subject_attempts_initialized_at')->nullable();
            $table->timestamp('course_attempts_initialized_at')->nullable();
            $table->foreignId('exam_id')->nullable();
            $table->string('user_type')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
