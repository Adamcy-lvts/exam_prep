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
        Schema::create('topics', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->morphs('topicable');
            $table->foreignId('unit_id')->nullable()->constrained()->onDelete('cascade');
            $table->integer('order')->nullable();
            $table->timestamps();
            $table->unique(['name', 'topicable_id', 'topicable_type'], 'unique_topic_per_quizzable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topics');
    }
};
