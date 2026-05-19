<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TournamentMatch extends Model
{
    use HasFactory;

    // Paksa model ini buat ngebaca tabel 'matches'
    protected $table = 'matches';
    protected $primaryKey = 'id_match';

    // Daftarin semua kolom lu
    protected $fillable = [
        'tournament_id',
        'team_a_id',
        'team_b_id',
        'score_a',
        'score_b',
        'waktu_tanding',
        'status',
        'keterangan'
    ];

    // Relasi ke Turnamen
    public function tournament()
    {
        return $this->belongsTo(Tournament::class, 'tournament_id', 'id_tournament');
    }

    // Relasi ke Tim A
    public function teamA()
    {
        return $this->belongsTo(Team::class, 'team_a_id', 'id_team');
    }

    // Relasi ke Tim B
    public function teamB()
    {
        return $this->belongsTo(Team::class, 'team_b_id', 'id_team');
    }
}