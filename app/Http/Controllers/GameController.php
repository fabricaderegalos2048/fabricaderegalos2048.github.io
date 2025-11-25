<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Score;

class GameController extends Controller
{
    // 1. Mostrar la vista del juego
    public function index()
    {
        // Verificar si hay un usuario en sesión
        if (!session()->has('player_id')) {
            return redirect()->route('welcome');
        }

        // Buscar al jugador para pasar su nombre a la vista
        $player = Player::find(session('player_id'));

        return view('game', ['currentPlayer' => $player]);
    }

    // 2. Guardar la puntuación (MODIFICADO PARA USAR SESIÓN)
    public function saveScore(Request $request)
    {
        // 1. Validar
        $request->validate([
            'score' => 'required|integer'
        ]);

        // 2. Obtener jugador de la sesión
        $playerId = session('player_id');
        
        if (!$playerId) {
            return response()->json(['status' => 'error', 'message' => 'Sesión expirada']);
        }

        $player = Player::find($playerId);

        // 3. GUARDAR SIEMPRE (Sin comprobar nada)
        // Esto crea un registro nuevo cada vez, guardando el historial completo.
        $player->scores()->create([
            'points' => $request->score
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Puntuación registrada', 
            'points' => $request->score
        ]);
    }
}