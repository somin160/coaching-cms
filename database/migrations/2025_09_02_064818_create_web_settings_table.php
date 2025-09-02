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
    Schema::create('web_settings', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('logo', 255)->nullable();
        $table->string('email', 255)->nullable();
        $table->string('job_email', 255)->nullable();
        $table->string('support_email', 255)->nullable();
        $table->string('phone', 50)->nullable();
        $table->text('address')->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('web_settings');
    }
};
