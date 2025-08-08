<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_reservacion',
        'id_usuario',
        'id_membresia', // Para mantener compatibilidad con pagos de membresías
        'id_clase',
        'monto',
        'fecha',
        'metodo_pago',
        'estado',
        'numero_transaccion',
        'notas'
    ];

    /**
     * Relación con el modelo Reservacion
     */
    public function reservacion()
    {
        return $this->belongsTo(Reservacion::class, 'id_reservacion');
    }

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
     * Relación con el modelo Clase (para pagos directos de clase)
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    /**
     * Generar número de transacción simulado
     */
    public static function generarNumeroTransaccion()
    {
        return 'TXN-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }

    /**
     * Obtener precios por nivel de clase (precios realistas en MXN)
     */
    public static function getPreciosPorNivel()
    {
        return [
            'Principiante' => 250.00,      // Clase básica
            'Intermedio' => 350.00,        // Clase intermedia
            'Avanzado' => 450.00,          // Clase avanzada
            'Competencia' => 550.00,       // Clase de competencia
            'Aqua Aeróbicos' => 280.00,    // Clase de aqua aeróbicos
            'Nado Sincronizado' => 500.00, // Clase especializada
            'Rehabilitación' => 380.00,    // Clase terapéutica
            'Infantil' => 200.00,          // Clase para niños
        ];
    }
}
