<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // Ngasih tau Laravel kalau PK-nya custom
    protected $primaryKey = 'id_team';

    // Kolom apa aja yang boleh diisi lewat form (Mass Assignment)
    protected $fillable = [
        'user_id',
        'nama_tim',
        'singkatan',
        'logo_path',
        'captain_id',
        'game_id',
    ];

    // Relasi: Satu tim punya satu kapten (dari tabel users)
    public function captain()
    {
        return $this->belongsTo(User::class, 'captain_id');
    }

    public function players()
    {
    return $this->hasMany(Player::class, 'team_id', 'id_team');
    }

    public function game()
{
    return $this->belongsTo(Game::class, 'game_id', 'id_game');
    //                                    ↑ FK di teams   ↑ PK di games
}
public function tournaments()
    {
        return $this->belongsToMany(Tournament::class, 'team_tournament', 'team_id', 'tournament_id')
                    ->withPivot('status_pendaftaran')
                    ->withTimestamps();
    }

    public function kapten()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
}