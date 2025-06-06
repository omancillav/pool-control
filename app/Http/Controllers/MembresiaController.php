<?php

namespace App\Http\Controllers;

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

        // Asegúrate de pasar la variable a la vista
        return view('membresias.lista', compact('membresias'));
    }



}