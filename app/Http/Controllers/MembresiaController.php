<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Membresia;

class MembresiaController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');

        $membresias = Membresia::query()
            ->when($search, function ($query, $search) {
                return $query->where('id_usuario', 'like', "%{$search}%")
                    ->orWhere('clases_adquiridas', 'like', "%{$search}%")
                    ->orWhere('clases_disponibles', 'like', "%{$search}%")
                    ->orWhere('clases_ocupadas', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('membresias.nueva', compact('membresias'));
    }
    public function list(Request $request)
    {
        $usuarios = User::all();
        $search = $request->input('search');

        $membresias = Membresia::query()
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

        Membresia::create([
            'id_usuario' => $validated['id_usuario'],
            'clases_adquiridas' => $validated['clases_adquiridas'],
            'clases_disponibles' => $validated['clases_disponibles'],
            'clases_ocupadas' => $validated['clases_ocupadas'],
        ]);

        return redirect()->route('membresias.list')->with('success', 'Membresía registrada correctamente.');
    }
}