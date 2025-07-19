<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'rol:Administrador']);
    }

    public function index()
    {
        $activities = \Spatie\Activitylog\Models\Activity::with('causer')->latest()->paginate(50);
        return view('dashboards.logs.index', compact('activities'));
    }
}
