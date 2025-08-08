<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membresia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $paquetes = [
            [
                'nombre' => 'Paquete Básico',
                'clases' => 4,
                'precio' => 80,
                'descripcion' => 'Ideal para principiantes',
                'beneficios' => ['4 clases', 'Acceso a nivel básico', 'Válido por 1 mes']
            ],
            [
                'nombre' => 'Paquete Intermedio',
                'clases' => 8,
                'precio' => 140,
                'descripcion' => 'Perfecto para practicantes regulares',
                'beneficios' => ['8 clases', 'Acceso a todos los niveles', 'Válido por 2 meses']
            ],
            [
                'nombre' => 'Paquete Premium',
                'clases' => 12,
                'precio' => 180,
                'descripcion' => 'La mejor opción para nadadores dedicados',
                'beneficios' => ['12 clases', 'Acceso prioritario', 'Válido por 3 meses']
            ]
        ];
        
        return view('membresias.comprar', compact('paquetes', 'membresiaActual'));
    }

    /**
     * Procesar la compra de una membresía
     */
    public function procesarCompra(Request $request)
    {
        $validated = $request->validate([
            'paquete' => 'required|in:basico,intermedio,premium',
            'metodo_pago' => 'required|in:online,fisico'
        ]);

        $user = Auth::user();
        
        // Definir los paquetes
        $paquetesInfo = [
            'basico' => ['clases' => 4, 'precio' => 80],
            'intermedio' => ['clases' => 8, 'precio' => 140],
            'premium' => ['clases' => 12, 'precio' => 180]
        ];
        
        $paqueteSeleccionado = $paquetesInfo[$validated['paquete']];
        
        // Verificar si el usuario ya tiene una membresía
        $membresiaExistente = Membresia::where('id_usuario', $user->id)->first();
        
        if ($membresiaExistente) {
            // Si ya tiene membresía, agregar clases a las disponibles
            $membresiaExistente->update([
                'clases_adquiridas' => $membresiaExistente->clases_adquiridas + $paqueteSeleccionado['clases'],
                'clases_disponibles' => $membresiaExistente->clases_disponibles + $paqueteSeleccionado['clases']
            ]);
            $mensaje = 'Membresía renovada exitosamente. Se han agregado ' . $paqueteSeleccionado['clases'] . ' clases a tu cuenta.';
        } else {
            // Crear nueva membresía
            Membresia::create([
                'id_usuario' => $user->id,
                'clases_adquiridas' => $paqueteSeleccionado['clases'],
                'clases_disponibles' => $paqueteSeleccionado['clases'],
                'clases_ocupadas' => 0
            ]);
            $mensaje = 'Membresía adquirida exitosamente. Ahora puedes reservar clases.';
        }

        if ($validated['metodo_pago'] === 'online') {
            return redirect()->route('reservaciones.index')
                ->with('success', $mensaje . ' Tu pago ha sido procesado correctamente.');
        } else {
            return redirect()->route('reservaciones.index')
                ->with('success', $mensaje . ' Recuerda realizar el pago antes de tu primera clase.');
        }
    }
}