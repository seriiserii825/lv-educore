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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->constrained('users');
            $table->foreignId('category_id')->nullable();
            $table->enum('course_type', ['course', 'webinar'])->default('course');
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('seo_description')->nullable();
            $table->string('duration')->nullable();
            $table->string('timezone')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('demo_video_storage', ['upload', 'youtube', 'vimeo', 'external_link'])->default('upload');
            $table->string('demo_video_source')->nullable();
            $table->text('description')->nullable();
            $table->integer('capacity')->nullable();
            $table->double('price')->default(0);
            $table->double('discount')->default(0);
            $table->boolean('certificate')->default(1);
            $table->boolean('qna')->default(1);
            $table->text('message_for_review')->nullable();
            $table->enum('is_approved', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->foreignId('course_level_id')->nullable();
            $table->foreignId('course_language_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
