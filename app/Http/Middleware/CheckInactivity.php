<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckInactivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo verificar para usuarios autenticados
        if (Auth::check()) {
            $lastActivity = session('last_activity');
            $inactivityTimeout = 1800; // 30 minutos en segundos
            
            if ($lastActivity && (time() - $lastActivity) > $inactivityTimeout) {
                // Cerrar sesión por inactividad
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                                
                return redirect('/login')->with('message', 'Su sesión ha expirado por inactividad.');
            }
            
            // Actualizar la última actividad
            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}