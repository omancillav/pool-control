<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    public function index()
    {
        return view('usuarios.nueva');
    }

    public function list(Request $request)
    {
        $search = $request->input('search');

        $usuarios = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('rol', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('usuarios.lista', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol' => $validated['rol'],
        ]);

        // Log para creación de usuario por administrador
        activity('User')
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'created_by_admin' => true,
                'user_role' => $validated['rol'],
                'user_email' => $validated['email']
            ])
            ->log('Usuario creado por administrador');

        return redirect()->route('usuarios.list')->with('success', 'Usuario registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|string|max:255',
        ]);

        $cambiosRealizados = [];
        $originalData = $user->toArray();

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->rol = $validated['rol'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
            $cambiosRealizados[] = 'password';
        }
        
        // Detectar cambios
        if ($originalData['name'] !== $validated['name']) $cambiosRealizados[] = 'name';
        if ($originalData['email'] !== $validated['email']) $cambiosRealizados[] = 'email';
        if ($originalData['rol'] !== $validated['rol']) $cambiosRealizados[] = 'rol';
        
        $user->save();

        // Log para actualización de usuario por administrador
        if (!empty($cambiosRealizados)) {
            activity('User')
                ->causedBy(Auth::user())
                ->performedOn($user)
                ->withProperties([
                    'updated_by_admin' => true,
                    'changes_made' => $cambiosRealizados,
                    'original_role' => $originalData['rol'],
                    'new_role' => $validated['rol']
                ])
                ->log('Usuario actualizado por administrador');
        }

        return redirect()->route('usuarios.list')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Log para eliminación de usuario por administrador
        activity('User')
            ->causedBy(Auth::user())
            ->performedOn($user)
            ->withProperties([
                'deleted_by_admin' => true,
                'deleted_user_name' => $user->name,
                'deleted_user_email' => $user->email,
                'deleted_user_role' => $user->rol
            ])
            ->log('Usuario eliminado por administrador');
        
        $user->delete();

        return redirect()->route('usuarios.list')->with('success', 'Usuario eliminado correctamente.');
    }
}
