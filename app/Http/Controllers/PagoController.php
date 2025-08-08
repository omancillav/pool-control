<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Clase;
use App\Models\Reservacion;
use App\Models\Membresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    /**
     * Mostrar la vista de pago antes de realizar la reservación
     */
    public function mostrarPago($id_clase)
    {
        $clase = Clase::with('profesor')->findOrFail($id_clase);
        
        // Verificar que la clase esté disponible
        if ($clase->fecha < now()->toDateString() || $clase->lugares_disponibles <= 0) {
            return redirect()->route('reservaciones.index')
                ->with('error', 'Esta clase no está disponible para reservar.');
        }

        // Verificar que el usuario no tenga ya una reservación para esta clase
        $reservacionExistente = Reservacion::where('id_clase', $id_clase)
            ->where('id_usuario', Auth::id())
            ->exists();

        if ($reservacionExistente) {
            return redirect()->route('reservaciones.index')
                ->with('error', 'Ya tienes una reservación para esta clase.');
        }

        return view('pagos.mostrar-pago', compact('clase'));
    }

    /**
     * Procesar el pago (simulado de manera realista)
     */
    public function procesarPago(Request $request, $id_clase)
    {
        $request->validate([
            'metodo_pago' => 'required|in:online,fisico',
            'notas' => 'nullable|string|max:500'
        ]);

        $clase = Clase::findOrFail($id_clase);
        
        // Verificaciones de seguridad
        if ($clase->fecha < now()->toDateString() || $clase->lugares_disponibles <= 0) {
            return redirect()->route('reservaciones.index')
                ->with('error', 'Esta clase no está disponible para reservar.');
        }

        $reservacionExistente = Reservacion::where('id_clase', $id_clase)
            ->where('id_usuario', Auth::id())
            ->exists();

        if ($reservacionExistente) {
            return redirect()->route('reservaciones.index')
                ->with('error', 'Ya tienes una reservación para esta clase.');
        }

        // Simular procesamiento realista para pago online
        if ($request->metodo_pago === 'online') {
            // Simular tiempo de procesamiento
            sleep(2);
            
            // Simular validación de tarjeta (siempre exitosa para la simulación)
            $transaccionExitosa = true; // En un sistema real, aquí se conectaría con el procesador de pagos
            
            if (!$transaccionExitosa) {
                return redirect()->back()
                    ->with('error', 'Error en el procesamiento del pago. Por favor, verifica tus datos e intenta nuevamente.');
            }
        }

        DB::transaction(function () use ($request, $clase) {
            // Crear la reservación
            $reservacion = Reservacion::create([
                'id_clase' => $clase->id,
                'id_usuario' => Auth::id(),
                'notas' => $request->notas
            ]);

            // Crear el pago con datos más realistas
            $estadoPago = $request->metodo_pago === 'online' ? 'completado' : 'pendiente';
            $numeroTransaccion = $request->metodo_pago === 'online' 
                ? $this->generarNumeroTransaccionRealista() 
                : null;

            Pago::create([
                'id_reservacion' => $reservacion->id,
                'id_usuario' => Auth::id(),
                'id_clase' => $clase->id,
                'monto' => $clase->precio,
                'fecha' => now()->toDateString(),
                'metodo_pago' => $request->metodo_pago,
                'estado' => $estadoPago,
                'numero_transaccion' => $numeroTransaccion,
                'notas' => $request->notas
            ]);

            // Actualizar lugares disponibles
            $clase->decrement('lugares_disponibles');
            $clase->increment('lugares_ocupados');
            
            // Si es un cliente, descontar de su membresía
            $user = Auth::user();
            if ($user->rol === 'Cliente') {
                $membresia = Membresia::where('id_usuario', $user->id)->first();
                if ($membresia) {
                    $membresia->decrement('clases_disponibles');
                    $membresia->increment('clases_ocupadas');
                }
            }
        });

        // Mensajes más realistas
        if ($request->metodo_pago === 'online') {
            return redirect()->route('reservaciones.mis-reservaciones')
                ->with('success', '¡Pago procesado exitosamente! Tu reservación ha sido confirmada. Recibirás un email de confirmación en unos minutos.');
        } else {
            return redirect()->route('reservaciones.mis-reservaciones')
                ->with('success', 'Reservación creada exitosamente. Tu lugar está asegurado. Recuerda realizar el pago el día de la clase.');
        }
    }

    /**
     * Generar número de transacción que se ve más realista
     */
    private function generarNumeroTransaccionRealista()
    {
        $prefijos = ['TXN', 'PAY', 'PYM', 'TRX'];
        $prefijo = $prefijos[array_rand($prefijos)];
        $timestamp = now()->format('YmdHis');
        $random = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);
        
        return $prefijo . '-' . $timestamp . '-' . $random;
    }

    /**
     * Ver todos los pagos (solo administradores)
     */
    public function index(Request $request)
    {
        if (!in_array(Auth::user()->rol, ['admin', 'profesor'])) {
            abort(403, 'No tienes permisos para ver esta página.');
        }

        $search = $request->input('search');
        $metodo = $request->input('metodo_pago');
        $estado = $request->input('estado');

        $pagos = Pago::with(['reservacion.clase.profesor', 'usuario'])
            ->when($search, function ($query, $search) {
                return $query->whereHas('usuario', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('reservacion.clase', function ($q) use ($search) {
                    $q->where('nivel', 'like', "%{$search}%");
                })
                ->orWhere('numero_transaccion', 'like', "%{$search}%");
            })
            ->when($metodo, function ($query, $metodo) {
                return $query->where('metodo_pago', $metodo);
            })
            ->when($estado, function ($query, $estado) {
                return $query->where('estado', $estado);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pagos.index', compact('pagos'));
    }

    /**
     * Marcar pago físico como completado
     */
    public function marcarCompletado($id)
    {
        if (!in_array(Auth::user()->rol, ['admin', 'profesor'])) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $pago = Pago::findOrFail($id);
        
        if ($pago->metodo_pago !== 'fisico') {
            return redirect()->back()
                ->with('error', 'Solo se pueden marcar como completados los pagos físicos.');
        }

        $pago->update([
            'estado' => 'completado',
            'numero_transaccion' => Pago::generarNumeroTransaccion()
        ]);

        return redirect()->back()
            ->with('success', 'Pago marcado como completado exitosamente.');
    }

    /**
     * Cancelar pago
     */
    public function cancelar($id)
    {
        if (!in_array(Auth::user()->rol, ['admin', 'profesor'])) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }

        $pago = Pago::with(['reservacion.clase'])->findOrFail($id);
        
        DB::transaction(function () use ($pago) {
            // Liberar el lugar en la clase
            $clase = $pago->reservacion->clase;
            $clase->increment('lugares_disponibles');
            $clase->decrement('lugares_ocupados');

            // Cancelar el pago y la reservación
            $pago->update(['estado' => 'cancelado']);
            $pago->reservacion->delete();
        });

        return redirect()->back()
            ->with('success', 'Pago y reservación cancelados exitosamente.');
    }
}
