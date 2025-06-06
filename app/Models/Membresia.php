<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membresia extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención)
    protected $table = 'membresias';

    // Los campos que se pueden asignar de forma masiva
    protected $fillable = [
        'id_usuario',
        'clases_adquiridas',
        'clases_disponibles',
        'clases_ocupadas',
    ];

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}