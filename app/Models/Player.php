<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{

    protected $fillable = ['nickname', 'scores'];

    // Un jugador tiene muchas puntuaciones
    public function scores()
    {
        return $this->hasMany(Score::class);
    }
}
