<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource for current user.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->rol == 'Cliente') {
            // Los clientes ven sus propias asistencias
            $asistencias = Asistencia::with(['clase', 'usuario'])
                ->where('id_usuario', $user->id)
                ->orderBy('fecha_marcado', 'desc')
                ->paginate(10);
        } else {
            // Administrador y Profesor ven todas las asistencias
            $asistencias = Asistencia::with(['clase', 'usuario'])
                ->orderBy('fecha_marcado', 'desc')
                ->paginate(15);
        }
        
        return view('asistencias.index', compact('asistencias'));
    }

    /**
     * Gestión de asistencias (solo para admin/profesor)
     */
    public function gestion()
    {
        // Obtener clases ordenadas por fecha
        $clases = Clase::with(['profesor'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        
        return view('asistencias.gestion', compact('clases'));
    }

    /**
     * Marcar asistencias de una clase específica
     */
    public function marcarAsistencia($claseId)
    {
        $clase = Clase::with(['reservaciones.usuario'])->findOrFail($claseId);
        
        // Obtener usuarios reservados en la clase
        $usuariosReservados = $clase->reservaciones->map(function($reservacion) {
            return $reservacion->usuario;
        });
        
        // Obtener asistencias ya marcadas
        $asistenciasMarcadas = Asistencia::where('id_clase', $claseId)->get()->keyBy('id_usuario');
        
        return view('asistencias.marcar', compact('clase', 'usuariosReservados', 'asistenciasMarcadas'));
    }

    /**
     * Guardar asistencias marcadas
     */
    public function guardarAsistencias(Request $request, $claseId)
    {
        $clase = Clase::findOrFail($claseId);
        $asistencias = $request->input('asistencias', []);
        
        foreach ($asistencias as $usuarioId => $data) {
            Asistencia::updateOrCreate(
                [
                    'id_clase' => $claseId,
                    'id_usuario' => $usuarioId,
                ],
                [
                    'presente' => isset($data['presente']) ? true : false,
                    'observaciones' => $data['observaciones'] ?? null,
                    'fecha_marcado' => now(),
                ]
            );
        }
        
        return redirect()->route('asistencias.gestion')
            ->with('success', 'Asistencias guardadas correctamente para la clase de ' . $clase->nivel . ' del ' . $clase->fecha->format('d/m/Y'));
    }

    /**
     * Mis asistencias (para clientes)
     */
    public function misAsistencias()
    {
        $user = Auth::user();
        
        if ($user->rol !== 'Cliente') {
            return redirect()->route('asistencias.index');
        }
        
        $asistencias = Asistencia::with(['clase'])
            ->where('id_usuario', $user->id)
            ->orderBy('fecha_marcado', 'desc')
            ->paginate(10);
        
        return view('asistencias.mis-asistencias', compact('asistencias'));
    }

    /**
     * Ver detalle de asistencia
     */
    public function show($id)
    {
        $asistencia = Asistencia::with(['clase', 'usuario'])->findOrFail($id);
        
        // Los clientes solo pueden ver sus propias asistencias
        if (Auth::user()->rol == 'Cliente' && $asistencia->id_usuario != Auth::id()) {
            abort(403);
        }
        
        return view('asistencias.show', compact('asistencia'));
    }
}
