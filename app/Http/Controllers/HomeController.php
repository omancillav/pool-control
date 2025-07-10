<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membresia;
use App\Models\Clase;
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
                $user->load(['membresia', 'clases' => function ($query) {
                    $query->orderBy('fecha', 'asc');
                }]);
                $viewData['membresia'] = $user->membresia;
                $viewData['clases'] = $user->clases;
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
