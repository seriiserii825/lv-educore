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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->foreignId('instructor_id')->constrained('users');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained('course_chapters')->onDelete('cascade');
            $table->enum('file_type', ['video', 'audio', 'text', 'pdf'])->default('video');
            $table->enum('storage', ['upload', 'youtube', 'vimeo', 'external_link'])->default('upload');
            $table->string('file_path')->nullable();
            $table->integer('volume')->default(0);
            $table->integer('duration')->default(0);
            $table->boolean('downloadable')->default(0);
            $table->integer('order')->default(0);
            $table->boolean('is_preview')->default(0);
            $table->boolean('status')->default(1);
            $table->enum('lesson_type', ['lesson', 'live'])->default('lesson');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
