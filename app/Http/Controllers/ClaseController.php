<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class ClaseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $clases = Clase::with('profesor')
            ->when($search, function ($query, $search) {
                return $query->where('nivel', 'like', "%{$search}%")
                    ->orWhere('lugares', 'like', "%{$search}%")
                    ->orWhere('lugares_ocupados', 'like', "%{$search}%")
                    ->orWhere('lugares_disponibles', 'like', "%{$search}%")
                    ->orWhereHas('profesor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        $profesores = User::all();

        return view('clases.nueva', compact('clases', 'profesores'));
    }

    public function list(Request $request)
    {
        $search = $request->input('search');

        $clases = Clase::with('profesor')
            ->when($search, function ($query, $search) {
                return $query->where('nivel', 'like', "%{$search}%")
                    ->orWhere('lugares', 'like', "%{$search}%")
                    ->orWhere('lugares_ocupados', 'like', "%{$search}%")
                    ->orWhere('lugares_disponibles', 'like', "%{$search}%")
                    ->orWhereHas('profesor', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        $profesores = User::all();

        return view('clases.lista', compact('clases', 'profesores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'id_profesor' => 'required|exists:users,id',
            'nivel' => 'required|string|max:255',
            'lugares' => 'required|integer|min:0',
            'lugares_ocupados' => 'required|integer|min:0',
            'lugares_disponibles' => 'required|integer|min:0',
        ]);

        // Crear la clase y asignar precio automáticamente
        $clase = new Clase($validated);
        $clase->asignarPrecioPorNivel();
        $clase->save();

        return redirect()->route('clases.list')
            ->with('success', 'Clase registrada correctamente con precio $' . number_format($clase->precio, 2) . ' MXN.');
    }

    public function edit($id)
    {
        $clase = Clase::findOrFail($id);
        $profesores = User::all();

        return view('clases.edit', compact('clase', 'profesores'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'fecha' => 'required|date',
            'id_profesor' => 'required|exists:users,id',
            'nivel' => 'required|string|max:255',
            'lugares' => 'required|integer|min:0',
            'lugares_ocupados' => 'required|integer|min:0',
            'lugares_disponibles' => 'required|integer|min:0',
        ]);

        $clase = Clase::findOrFail($id);
        $nivelAnterior = $clase->nivel;
        $clase->fill($validated);
        
        // Si cambió el nivel, actualizar el precio
        if ($clase->isDirty('nivel')) {
            $precioAnterior = $clase->precio;
            $clase->asignarPrecioPorNivel();
            $mensaje = "Clase actualizada correctamente. Precio actualizado de $" . number_format($precioAnterior, 2) . " a $" . number_format($clase->precio, 2) . " MXN.";
        } else {
            $mensaje = 'Clase actualizada correctamente.';
        }
        
        $clase->save();

        return redirect()->route('clases.list')->with('success', $mensaje);
    }

    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete();

        return redirect()->route('clases.list')->with('success', 'Clase eliminada correctamente.');
    }
}