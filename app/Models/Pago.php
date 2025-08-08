<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_usuario',
        'id_membresia',
        'monto',
        'fecha',
        'metodo_pago',
        'estado',
        'numero_transaccion',
        'notas'
    ];

    /**
     * Relación con el modelo User
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    /**
     * Relación con el modelo Membresia (para pagos de membresías)
     */
    public function membresia()
    {
        return $this->belongsTo(Membresia::class, 'id_membresia');
    }

    /**
     * Generar número de transacción simulado
     */
    public static function generarNumeroTransaccion()
    {
        return 'TXN-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }
}
