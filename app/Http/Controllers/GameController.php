<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player; // Importante: Importar el modelo Player
use App\Models\Score;  // Importante: Importar el modelo Score

class GameController extends Controller
{
    // 1. Mostrar la vista del juego
    public function index()
    {
        return view('game');
    }

    // 2. Guardar la puntuación
    public function saveScore(Request $request)
    {
        // Validamos los datos que vienen del navegador
        $request->validate([
            'nickname' => 'required|string|max:20',
            'score' => 'required|integer'
        ]);

        // Buscamos al jugador por su nickname.
        // Si no existe, Laravel lo crea automáticamente gracias a firstOrCreate.
        $player = Player::firstOrCreate(
            ['nickname' => $request->nickname]
        );

        // Creamos la puntuación vinculada a ese jugador
        $score = $player->scores()->create([
            'points' => $request->score
        ]);

        return response()->json([
            'status' => 'success',
            'message' => '¡Puntuación guardada correctamente!',
            'player' => $player->nickname,
            'points' => $score->points
        ]);
    }

    // 3. (Opcional) Obtener ranking para mostrar en pantalla
    public function leaderboard()
    {
        $scores = Score::with('player')
                    ->orderBy('points', 'desc')
                    ->take(10)
                    ->get();

        return response()->json($scores);
    }
}
