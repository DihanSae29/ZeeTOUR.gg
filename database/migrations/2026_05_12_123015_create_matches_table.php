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
        Schema::create('matches', function (Blueprint $table) {
            $table->id('id_match'); // Primary key
            
            // Relasi ke Turnamen (Turnamen dihapus = Match ikut dihapus, ini WAJAR)
            $table->foreignId('tournament_id')->constrained('tournaments', 'id_tournament')->onDelete('cascade');
            
            // Relasi ke Tim A dan Tim B (Tim dihapus = Cuma jadi NULL, sejarah skor turnamen TETEP AMAN)
            $table->unsignedBigInteger('team_a_id')->nullable();
            $table->foreign('team_a_id')->references('id_team')->on('teams')->onDelete('set null');
            
            $table->unsignedBigInteger('team_b_id')->nullable();
            $table->foreign('team_b_id')->references('id_team')->on('teams')->onDelete('set null');
            
            // Skor & Jadwal
            $table->integer('score_a')->default(0);
            $table->integer('score_b')->default(0);
            $table->dateTime('waktu_tanding')->nullable();
            
            // Status & Keterangan Bracket
            $table->enum('status', ['Upcoming', 'Live', 'Completed'])->default('Upcoming');
            $table->string('keterangan', 100)->nullable(); // Misal: "Semi-Final", "Grand Final"
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('matches');
    }
};
