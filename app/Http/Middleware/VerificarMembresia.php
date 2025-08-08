<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Membresia;

class VerificarMembresia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Solo verificar membresía para clientes
        if ($user->rol !== 'Cliente') {
            return $next($request);
        }

        // Verificar si el usuario tiene una membresía activa
        $membresia = Membresia::where('id_usuario', $user->id)->first();
        
        if (!$membresia) {
            return redirect()->route('membresias.list')
                ->with('error', 'Necesitas adquirir una membresía para poder reservar clases.');
        }

        // Verificar si tiene clases disponibles
        if ($membresia->clases_disponibles <= 0) {
            return redirect()->route('membresias.list')
                ->with('error', 'No tienes clases disponibles en tu membresía. Adquiere una nueva membresía o renueva la existente.');
        }

        return $next($request);
    }
}
