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
                return $query->where('tipo', 'like', "%{$search}%")
                    ->orWhere('lugares', 'like', "%{$search}%")
                    ->orWhere('lugares_ocupados', 'like', "%{$search}%")
                    ->orWhere('lugares_disponibles', 'like', "%{$search}%");
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
                return $query->where('tipo', 'like', "%{$search}%")
                    ->orWhere('lugares', 'like', "%{$search}%")
                    ->orWhere('lugares_ocupados', 'like', "%{$search}%")
                    ->orWhere('lugares_disponibles', 'like', "%{$search}%");
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
            'tipo' => 'required|string|max:255',
            'lugares' => 'required|integer|min:0',
            'lugares_ocupados' => 'required|integer|min:0',
            'lugares_disponibles' => 'required|integer|min:0',
        ]);

        Clase::create($validated);

        return redirect()->route('clases.list')->with('success', 'Clase registrada correctamente.');
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
            'tipo' => 'required|string|max:255',
            'lugares' => 'required|integer|min:0',
            'lugares_ocupados' => 'required|integer|min:0',
            'lugares_disponibles' => 'required|integer|min:0',
        ]);

        $clase = Clase::findOrFail($id);
        $clase->update($validated);

        return redirect()->route('clases.list')->with('success', 'Clase actualizada correctamente.');
    }

    public function destroy($id)
    {
        $clase = Clase::findOrFail($id);
        $clase->delete();

        return redirect()->route('clases.list')->with('success', 'Clase eliminada correctamente.');
    }
}