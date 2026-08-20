<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('position');
            $table->text('question_text');
            $table->string('image_path')->nullable();
            $table->string('audio_path')->nullable();
            $table->json('options');
            $table->unsignedTinyInteger('correct_option');
            $table->timestamps();
            $table->unique(['exam_id', 'position']);
        });

        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('score');
            $table->unsignedInteger('total_questions')->default(30);
            $table->boolean('passed');
            $table->json('answers');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
        Schema::dropIfExists('questions');
    }
};
