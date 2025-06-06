<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MembresiaController extends Controller
{
     public function index()
    {
        // Aquí puedes implementar la lógica para mostrar las membresías
        return view('membresias.nueva');
    }
      public function list()
    {
        // Aquí puedes implementar la lógica para mostrar las membresías
        return view('membresias.lista');
    }

}
