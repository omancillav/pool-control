<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Clase;
use App\Models\Reservacion;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = User::find(Auth::id());
        $viewData = [];

        switch ($user->rol) {
            case 'Administrador':
                $viewData['totalUsuarios'] = User::count();
                $viewData['totalMembresias'] = Membresia::count();
                $viewData['totalClases'] = Clase::count();
                break;

            case 'Cliente':
                $membresia = Membresia::where('id_usuario', $user->id)->first();
                $reservaciones = Reservacion::with(['clase.profesor'])
                    ->where('id_usuario', $user->id)
                    ->whereHas('clase', function ($query) {
                        $query->where('fecha', '>=', now()->toDateString());
                    })
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                
                $proximasClases = $reservaciones->map(function ($reservacion) {
                    return $reservacion->clase;
                })->sortBy('fecha');
                
                $viewData['membresia'] = $membresia;
                $viewData['reservaciones'] = $reservaciones;
                $viewData['clases'] = $proximasClases;
                break;

            case 'Profesor':
                $user->load(['clasesImpartidas' => function ($query) {
                    $query->orderBy('fecha', 'asc');
                }]);
                $viewData['clasesImpartidas'] = $user->clasesImpartidas;
                break;
        }

        return view('home', $viewData);
    }
}
