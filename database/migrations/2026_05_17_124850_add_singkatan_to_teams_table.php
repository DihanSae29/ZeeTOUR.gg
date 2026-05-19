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
        Schema::table('teams', function (Blueprint $table) {
            // Kita bikin nullable() biar data tim lu yang lama (Paper Rex dkk) ga bikin database error
            $table->string('singkatan', 10)->nullable()->after('nama_tim'); 
        });
    }

    public function down(): void
    {
        Schema::table('teams', function (Blueprint $table) {
            $table->dropColumn('singkatan');
        });
    }
};
