<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_tournament';

    protected $fillable = [
        'game_id', 'nama_turnamen', 'deskripsi', 'max_slot',
        'prizepool', 'status', 'start_date', 'end_date', 'banner_path'
    ];

    public function game()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id_game');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_tournament', 'tournament_id', 'team_id')
                    ->withPivot('status_pendaftaran')
                    ->withTimestamps();
    }
    // Relasi ke Match
    public function matches()
    {
        return $this->hasMany(TournamentMatch::class, 'tournament_id', 'id_tournament');
    }
}