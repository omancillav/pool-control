<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;


    protected $table = 'membresias';


    protected $fillable = [
        'id_usuario',
        'clases_adquiridas',
        'clases_disponibles',
        'clases_ocupadas',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }   
}