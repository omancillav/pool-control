<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class MembresiaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $membresias = Membresia::with('usuario')
            ->when($search, function ($query, $search) {
                return $query->where('id_usuario', 'like', "%{$search}%")
                    ->orWhere('clases_adquiridas', 'like', "%{$search}%")
                    ->orWhere('clases_disponibles', 'like', "%{$search}%")
                    ->orWhere('clases_ocupadas', 'like', "%{$search}%")
                    ->orWhereHas('usuario', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        $usuarios = User::all();

        return view('membresias.nueva', compact('membresias', 'usuarios'));
    }

    public function list(Request $request)
    {
        $usuarios = User::all();
        $search = $request->input('search');

        $membresias = Membresia::with('usuario')
            ->when($search, function ($query, $search) {
                return $query->where('id_usuario', 'like', "%{$search}%")
                    ->orWhere('clases_adquiridas', 'like', "%{$search}%")
                    ->orWhere('clases_disponibles', 'like', "%{$search}%")
                    ->orWhere('clases_ocupadas', 'like', "%{$search}%")
                    ->orWhereHas('usuario', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        return view('membresias.lista', compact('membresias', 'usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'clases_adquiridas' => 'required|integer|min:0',
            'clases_disponibles' => 'required|integer|min:0',
            'clases_ocupadas' => 'required|integer|min:0',
        ]);

        Membresia::create($validated);

        return redirect()->route('membresias.list')->with('success', 'Membresía registrada correctamente.');
    }

    public function edit($id)
    {
        $membresia = Membresia::findOrFail($id);
        $usuarios = User::all();

        return view('membresias.edit', compact('membresia', 'usuarios'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_usuario' => 'required|exists:users,id',
            'clases_adquiridas' => 'required|integer|min:0',
            'clases_disponibles' => 'required|integer|min:0',
            'clases_ocupadas' => 'required|integer|min:0',
        ]);

        $membresia = Membresia::findOrFail($id);
        $membresia->update($validated);

        return redirect()->route('membresias.list')->with('success', 'Membresía actualizada correctamente.');
    }

    public function destroy($id)
    {
        $membresia = Membresia::findOrFail($id);
        $membresia->delete();

        return redirect()->route('membresias.list')->with('success', 'Membresía eliminada correctamente.');
    }

    /**
     * Mostrar la vista para que los clientes compren membresías
     */
    public function comprar()
    {
        $user = Auth::user();
        $membresiaActual = Membresia::where('id_usuario', $user->id)->first();

        // Definir paquetes de membresías disponibles
        $paquetesInfo = $this->getPaquetesInfo();
        $paquetes = array_values($paquetesInfo); // Convertir a array numérico para la vista

        return view('membresias.comprar', compact('paquetes', 'membresiaActual'));
    }

    /**
     * Mostrar la vista de pago antes de procesar la compra de membresía
     */
    public function mostrarPago(Request $request)
    {
        $validated = $request->validate([
            'paquete' => 'required|in:basico,intermedio,premium'
        ]);

        $user = Auth::user();

        // Obtener información de paquetes
        $paquetesInfo = $this->getPaquetesInfo();

        $paquete = $paquetesInfo[$validated['paquete']];
        $tipoPaquete = $validated['paquete'];

        return view('membresias.mostrar-pago', compact('paquete', 'tipoPaquete'));
    }

    /**
     * Procesar la compra de una membresía con pago
     */
    public function procesarCompra(Request $request)
    {
        $validated = $request->validate([
            'paquete' => 'required|in:basico,intermedio,premium',
            'metodo_pago' => 'required|in:online,fisico',
            'notas' => 'nullable|string|max:500'
        ]);

        $user = Auth::user();

        // Obtener información de paquetes
        $paquetesInfo = $this->getPaquetesInfo();

        $paqueteSeleccionado = $paquetesInfo[$validated['paquete']];

        // Simular procesamiento realista para pago online
        if ($validated['metodo_pago'] === 'online') {
            // Simular tiempo de procesamiento
            sleep(2);

            // Simular validación de tarjeta (siempre exitosa para la simulación)
            $transaccionExitosa = true;

            if (!$transaccionExitosa) {
                return redirect()->back()
                    ->with('error', 'Error en el procesamiento del pago. Por favor, verifica tus datos e intenta nuevamente.');
            }
        }

        // Usar transacción de base de datos para seguridad
        $logData = [];
        DB::transaction(function () use ($user, $paqueteSeleccionado, $validated, &$logData) {
            // Verificar si el usuario ya tiene una membresía
            $membresiaExistente = Membresia::where('id_usuario', $user->id)->first();

            if ($membresiaExistente) {
                // Si ya tiene membresía, agregar clases a las disponibles
                $membresiaExistente->update([
                    'clases_adquiridas' => $membresiaExistente->clases_adquiridas + $paqueteSeleccionado['clases'],
                    'clases_disponibles' => $membresiaExistente->clases_disponibles + $paqueteSeleccionado['clases']
                ]);
                $membresia = $membresiaExistente;
                $logData['es_renovacion'] = true;
            } else {
                // Crear nueva membresía
                $membresia = Membresia::create([
                    'id_usuario' => $user->id,
                    'clases_adquiridas' => $paqueteSeleccionado['clases'],
                    'clases_disponibles' => $paqueteSeleccionado['clases'],
                    'clases_ocupadas' => 0
                ]);
                $logData['es_renovacion'] = false;
            }

            // Crear el registro de pago
            $estadoPago = $validated['metodo_pago'] === 'online' ? 'completado' : 'pendiente';
            $numeroTransaccion = $validated['metodo_pago'] === 'online'
                ? $this->generarNumeroTransaccionRealista()
                : null;

            \App\Models\Pago::create([
                'id_usuario' => $user->id,
                'id_membresia' => $membresia->id,
                'monto' => $paqueteSeleccionado['precio'],
                'fecha' => now()->toDateString(),
                'metodo_pago' => $validated['metodo_pago'],
                'estado' => $estadoPago,
                'numero_transaccion' => $numeroTransaccion,
                'notas' => $validated['notas']
            ]);
            
            // Preparar datos para el log
            $logData['estado_pago'] = $estadoPago;
            $logData['numero_transaccion'] = $numeroTransaccion;
        });

        // Log para compra de membresía
        activity('Membresia')
            ->causedBy($user)
            ->withProperties([
                'paquete' => $validated['paquete'],
                'clases_compradas' => $paqueteSeleccionado['clases'],
                'monto' => $paqueteSeleccionado['precio'],
                'metodo_pago' => $validated['metodo_pago'],
                'estado_pago' => $logData['estado_pago'],
                'es_renovacion' => $logData['es_renovacion'],
                'numero_transaccion' => $logData['numero_transaccion']
            ])
            ->log('Membresía ' . $paqueteSeleccionado['nombre'] . ' ' . ($logData['es_renovacion'] ? 'renovada' : 'adquirida'));

        // Mensajes más realistas
        if ($validated['metodo_pago'] === 'online') {
            return redirect()->route('reservaciones.index')
                ->with('success', '¡Pago procesado exitosamente! Tu membresía ha sido activada. Recibirás un email de confirmación en unos minutos.');
        } else {
            return redirect()->route('reservaciones.index')
                ->with('success', 'Membresía reservada exitosamente. Recuerda realizar el pago para activar completamente tu membresía.');
        }
    }

    /**
     * Generar número de transacción que se ve más realista
     */
    private function generarNumeroTransaccionRealista()
    {
        $prefijos = ['MEM', 'PAY', 'PYM', 'TXN'];
        $prefijo = $prefijos[array_rand($prefijos)];
        $timestamp = now()->format('YmdHis');
        $random = str_pad(rand(1000, 9999), 4, '0', STR_PAD_LEFT);

        return $prefijo . '-' . $timestamp . '-' . $random;
    }

    /**
     * Obtener la información de todos los paquetes de membresía
     */
    private function getPaquetesInfo()
    {
        return [
            'basico' => [
                'nombre' => 'Paquete Básico',
                'clases' => 4,
                'precio' => 500.00,
                'descripcion' => 'Ideal para principiantes',
                'beneficios' => ['4 clases', 'Acceso a nivel básico', 'Válido por 1 mes']
            ],
            'intermedio' => [
                'nombre' => 'Paquete Intermedio',
                'clases' => 8,
                'precio' => 750.00,
                'descripcion' => 'Perfecto para practicantes regulares',
                'beneficios' => ['8 clases', 'Acceso a todos los niveles', 'Válido por 2 meses']
            ],
            'premium' => [
                'nombre' => 'Paquete Premium',
                'clases' => 12,
                'precio' => 1000.00,
                'descripcion' => 'La mejor opción para nadadores dedicados',
                'beneficios' => ['12 clases', 'Acceso prioritario', 'Válido por 3 meses']
            ]
        ];
    }
}
