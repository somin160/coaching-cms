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
    Schema::create('faqs', function (Blueprint $table) {
        $table->bigIncrements('id');

        $table->foreignId('page_section_id')
            ->constrained('page_sections')->cascadeOnDelete();

        $table->string('question', 255);
        $table->text('answer')->nullable();

        $table->integer('sort_order')->default(0);
        $table->tinyInteger('status')->default(1);
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
