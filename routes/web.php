<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GameController;
use Illuminate\Support\Facades\Route;



// Muestra la portada (welcome.blade.php)
Route::get('/', [PlayerController::class, 'welcome'])->name('welcome');
// Recibe los datos del formulario de REGISTRO
Route::post('/register', [PlayerController::class, 'register'])->name('player.register');
// Recibe los datos del formulario de LOGIN
Route::post('/login', [PlayerController::class, 'login'])->name('player.login');
// Cierra la sesión del jugador
Route::get('/logout', [PlayerController::class, 'logout'])->name('player.logout');
// Ruta para ver el juego 
Route::get('/game', [GameController::class, 'index'])->name('game');

// Ruta para guardar 
Route::post('/save-score', [GameController::class, 'saveScore']);

// Ruta para ver el ranking
Route::get('/leaderboard', [GameController::class, 'leaderboard']);




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//require __DIR__.'/auth.php';
