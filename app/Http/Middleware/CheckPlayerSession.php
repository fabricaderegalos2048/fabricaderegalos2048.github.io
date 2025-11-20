<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CheckPlayerSession
{
 /**
 * Handle an incoming request.
 *
 * @param \Closure(\Illuminate\Http\Request):
(\Symfony\Component\HttpFoundation\Response) $next
 */
 public function handle(Request $request, Closure $next): Response
 {
 // 1. Comprueba si la sesión NO tiene 'player_id'
 if (!session()->has('player_id')) {
 // 2. Si no lo tiene, redirige a la portada
 return redirect('/');
 }

 // 3. Si SÍ lo tiene, déjalo continuar hacia el controlador
 return $next($request);
 }
}