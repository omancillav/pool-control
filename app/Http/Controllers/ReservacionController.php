<?php

namespace App\Http\Controllers;

use App\Models\Reservacion;
use App\Models\Clase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservacionController extends Controller
{
    /**
     * Mostrar la lista de clases disponibles para reservar (para clientes)
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $today = now()->toDateString();

        $clases = Clase::with(['profesor', 'reservaciones'])
            ->where('fecha', '>=', $today)
            ->where('lugares_disponibles', '>', 0)
            ->when($search, function ($query, $search) {
                return $query->where('nivel', 'like', "%{$search}%")
                    ->orWhereHas('profesor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->orderBy('fecha')
            ->paginate(10);

        return view('reservaciones.index', compact('clases'));
    }

    /**
     * Mostrar las reservaciones del usuario autenticado
     */
    public function misReservaciones(Request $request)
    {
        $search = $request->input('search');

        $reservaciones = Reservacion::with(['clase.profesor', 'pago'])
            ->where('id_usuario', Auth::id())
            ->when($search, function ($query, $search) {
                return $query->whereHas('clase', function ($q) use ($search) {
                    $q->where('nivel', 'like', "%{$search}%")
                        ->orWhereHas('profesor', function ($p) use ($search) {
                            $p->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('reservaciones.mis-reservaciones', compact('reservaciones'));
    }

    /**
     * Redirigir al proceso de pago para crear una reservación
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_clase' => 'required|exists:clases,id',
        ]);

        $clase = Clase::findOrFail($validated['id_clase']);
        
        // Verificar que la clase no sea en el pasado
        if ($clase->fecha < now()->toDateString()) {
            return redirect()->back()->with('error', 'No puedes reservar una clase que ya pasó.');
        }

        // Verificar que haya lugares disponibles
        if ($clase->lugares_disponibles <= 0) {
            return redirect()->back()->with('error', 'No hay lugares disponibles en esta clase.');
        }

        // Verificar que el usuario no tenga ya una reservación para esta clase
        $reservacionExistente = Reservacion::where('id_clase', $validated['id_clase'])
            ->where('id_usuario', Auth::id())
            ->exists();

        if ($reservacionExistente) {
            return redirect()->back()->with('error', 'Ya tienes una reservación para esta clase.');
        }

        // Redirigir al proceso de pago
        return redirect()->route('pagos.mostrar', $validated['id_clase']);
    }

    /**
     * Cancelar una reservación
     */
    public function cancelar(Request $request, $id)
    {
        $reservacion = Reservacion::findOrFail($id);

        // Verificar que la reservación pertenece al usuario autenticado
        if ($reservacion->id_usuario !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        // Verificar que la clase no haya empezado ya
        if ($reservacion->clase->fecha < now()->toDateString()) {
            return redirect()->back()->with('error', 'No puedes cancelar una reservación para una clase que ya pasó.');
        }

        // Eliminar la reservación y liberar el lugar
        DB::transaction(function () use ($reservacion) {
            $reservacion->clase->increment('lugares_disponibles');
            $reservacion->clase->decrement('lugares_ocupados');
            $reservacion->delete();
        });

        return redirect()->back()->with('success', 'Reservación cancelada exitosamente.');
    }

    /**
     * Gestión de reservaciones para administradores y profesores
     */
    public function gestion(Request $request)
    {
        $search = $request->input('search');
        $user = Auth::user();

        $reservaciones = Reservacion::with(['clase.profesor', 'usuario'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('usuario', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('clase', function ($q) use ($search) {
                    $q->where('nivel', 'like', "%{$search}%");
                });
            })
            ->when($user->rol === 'Profesor', function ($query) use ($user) {
                // Si es profesor, solo mostrar reservaciones de sus clases
                return $query->whereHas('clase', function ($q) use ($user) {
                    $q->where('id_profesor', $user->id);
                });
            })
            ->latest()
            ->paginate(10);

        return view('reservaciones.gestion', compact('reservaciones'));
    }

    /**
     * Cancelar una reservación desde la gestión (admin/profesor)
     */
    public function cancelarAdmin($id)
    {
        $reservacion = Reservacion::with('clase')->findOrFail($id);
        $user = Auth::user();

        // Si es profesor, verificar que la clase le pertenezca
        if ($user->rol === 'Profesor' && $reservacion->clase->id_profesor !== $user->id) {
            abort(403, 'No autorizado para cancelar esta reservación.');
        }

        // Verificar que la clase no haya empezado ya
        if ($reservacion->clase->fecha < now()->toDateString()) {
            return redirect()->back()->with('error', 'No se puede cancelar una reservación para una clase que ya pasó.');
        }

        // Eliminar la reservación y liberar el lugar
        DB::transaction(function () use ($reservacion) {
            $reservacion->clase->increment('lugares_disponibles');
            $reservacion->clase->decrement('lugares_ocupados');
            $reservacion->delete();
        });

        return redirect()->back()->with('success', 'Reservación cancelada exitosamente.');
    }
}
