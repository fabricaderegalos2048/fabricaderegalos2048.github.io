<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    protected $fillable = ['player_id', 'points'];

    // Una puntuación pertenece a un jugador
    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}
