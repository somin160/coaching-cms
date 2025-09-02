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
    Schema::create('page_sections', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->foreignId('page_id')
            ->constrained('pages')->cascadeOnDelete();

        $table->enum('section_type', [
            'TextWithImageGrid',
            'ImageGrid',
            'Carousel',
            'FAQs',
            'TextEditor',
            'HeroSection',
        ]);

        $table->json('section_data');
        $table->foreignId('form_id')->nullable()
            ->constrained('forms')->nullOnDelete();

        $table->integer('sort_order')->default(0);
        $table->tinyInteger('status')->default(1);
        $table->timestamps();
          $table->json('sections')->nullable();

    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_sections');
    }
};
