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
    Schema::create('tournaments', function (Blueprint $table) {
        $table->id('id_tournament');
        $table->unsignedBigInteger('game_id');         
        $table->foreign('game_id')                      
              ->references('id_game')
              ->on('games')
              ->onDelete('cascade');
        $table->string('nama_turnamen');
        $table->text('deskripsi')->nullable();
        $table->integer('max_slot');
        $table->string('prizepool')->nullable();
        $table->enum('status', ['Registration', 'Ongoing', 'Completed'])->default('Registration');
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();
        $table->string('banner_path')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tournaments');
    }
};
