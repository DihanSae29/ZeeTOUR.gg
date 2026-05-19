<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $primaryKey = 'id_player';
    protected $fillable = ['team_id', 'nickname', 'nama_asli', 'role', 'photo', 'bio', 'instagram',];

    public function team()
    {
    return $this->belongsTo(Team::class, 'team_id', 'id_team');
    }
}
