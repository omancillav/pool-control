<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    protected $fillable = [
        'fecha',
        'id_profesor',
        'tipo',
        'lugares',
        'lugares_ocupados',
        'lugares_disponibles',
    ];
      protected $casts = [
        'fecha' => 'date',
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor');
    }
}