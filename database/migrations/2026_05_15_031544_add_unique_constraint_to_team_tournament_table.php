<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('team_tournament', function (Blueprint $table) {
            // Nambahin proteksi di tabel yang udah ada
            $table->unique(['team_id', 'tournament_id'], 'team_tourney_unique');
        });
    }

    public function down(): void
    {
        Schema::table('team_tournament', function (Blueprint $table) {
            // Buat jaga-jaga kalau di-rollback
            $table->dropUnique('team_tourney_unique');
        });
    }
};