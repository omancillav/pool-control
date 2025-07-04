<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membresia;
use Illuminate\Http\Request;

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
                    ->orWhere('clases_ocupadas', 'like', "%{$search}%");
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
                    ->orWhere('clases_ocupadas', 'like', "%{$search}%");
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
}