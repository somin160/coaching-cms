<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('home_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->json('hero_slider')->nullable();
            $table->json('courses')->nullable();
            $table->json('rankers')->nullable();
            $table->json('image_content')->nullable();
            $table->json('videos')->nullable();
            $table->json('img_grid')->nullable();
            $table->json('achievers')->nullable();
            $table->json('testimonials')->nullable();
            $table->json('faqs')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('home_pages');
    }
};

