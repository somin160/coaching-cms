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
       Schema::create('navbars', function (Blueprint $table) {
    $table->id();
    $table->string('title');           // Display text
    $table->string('slug')->unique();  // For URL / routing
    $table->foreignId('parent_id')->nullable()->constrained('navbars')->nullOnDelete(); // For multi-level dropdown
    $table->integer('order')->default(0); // Order in menu
    $table->boolean('status')->default(true); // Active / Inactive
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbars');
    }
};
