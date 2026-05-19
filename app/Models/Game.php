<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $primaryKey = 'id_game';

    protected $fillable = [
        'nama_game', 
        'platform', 
        'max_player', 
        'logo_path_game'
    ];
}