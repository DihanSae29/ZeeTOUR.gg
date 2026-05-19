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
    Schema::create('team_tournament', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('tournament_id');
        $table->foreign('tournament_id')->references('id_tournament')->on('tournaments')->onDelete('cascade');

        $table->unsignedBigInteger('team_id');
        $table->foreign('team_id')->references('id_team')->on('teams')->onDelete('cascade');

        $table->enum('status_pendaftaran', ['Pending', 'Approved', 'Rejected'])->default('Pending');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_tournament');
    }
};
