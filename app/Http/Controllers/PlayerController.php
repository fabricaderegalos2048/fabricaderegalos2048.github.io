<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; // Para manejar la sesión

class PlayerController extends Controller
{
    /** 
     * Muestra la portada con los 2 formularios Y el Top 10. 
     */
    public function welcome()
    {
        // Esto se queda igual: si ya está logueado, al juego. 
        if (session()->has('players_id')) {
            return redirect()->route('game');
        }
        // --- INICIO DE LA MODIFICACIÓN --- 
        // 1. Buscamos el Top 10 de puntuaciones 
        // CÓDIGO CORRECTO
        $highScores = Score::with('player')
            ->orderBy('points', 'desc')
            ->take(10)
            ->get();  // <--- ¡Asegúrate de que esto esté aquí!// 'player' es el nombre del método-relación ->orderBy('points', 'desc') // Ordenar por 'points', de más a menos ->take(10) // Tomar solo los 10 primeros ->get(); 
        
        // 2. Pasamos los scores a la vista 
        return view('welcome', [
            'highScores' => $highScores
        ]);
        // --- FIN DE LA MODIFICACIÓN --- 
    }
    // ... (El resto de métodos: register, login, logout se quedan igual) ... 
    // ... (tu función welcome y otras funciones) ...

    /**
     * Procesa el formulario de REGISTRO.
     */
    public function register(Request $request)
    {
        // 1. Validar los datos
        $validated = $request->validate([
            'nickname' => 'required|string|max:20|unique:players,nickname',
        ]);

        // 2. Crear el jugador en la base de datos
        $player = Player::create([
            'nickname' => $validated['nickname'],
            // 'points' => 0   <--- ¡BORRA ESTA LÍNEA! El jugador no tiene puntos aquí.
        ]);

        // 3. Guardar el ID en sesión
        session(['player_id' => $player->id]); // Ojo: asegúrate de usar 'player_id' (singular) si es lo que usas en el resto de tu código.

        // 4. Redirigir
        return redirect()->route('game');
    }
    public function login(Request $request)
    {
        // 1. Validar que el nombre existe en la tabla 'players'
        $validated = $request->validate([
            'nickname' => 'required|string|exists:players,nickname',
        ]);

        // 2. Recuperar el jugador de la base de datos
        $player = Player::where('nickname', $validated['nickname'])->first();

        // 3. Guardar el ID en la sesión (Login)
        // NOTA: Uso 'players_id' porque es lo que usaste en tu función welcome y register.
        session(['player_id' => $player->id]);

        // 4. Redirigir al juego
        return redirect()->route('game');
    }

    /**
     * Cierra la sesión.
     */
    public function logout()
    {
        // Borramos el ID de la sesión
        session()->forget('players_id');

        // Volvemos a la portada
        return redirect()->route('welcome');
    }
} // <--- Esta es la llave final de la clase
