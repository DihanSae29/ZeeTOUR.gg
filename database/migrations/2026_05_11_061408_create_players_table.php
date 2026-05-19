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
    Schema::create('players', function (Blueprint $table) {
        $table->id('id_player');
        // Foreign Key ke tabel teams
        $table->foreignId('team_id')->constrained('teams', 'id_team')->onDelete('cascade');
        $table->string('nickname');
        $table->string('nama_asli');
        $table->string('role'); // Contoh: Duelist, IGL, Support, dsb.
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};
