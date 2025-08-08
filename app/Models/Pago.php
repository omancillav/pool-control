<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Pago extends Model
{
    use HasFactory, LogsActivity;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('Pago')
            ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) {
                'created' => 'registrado',
                'updated' => 'actualizado',
                'deleted' => 'eliminado',
                default => $eventName
            } . " un pago");
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
     * Generar número de transacción simulado
     */
    public static function generarNumeroTransaccion()
    {
        return 'TXN-' . strtoupper(uniqid()) . '-' . rand(1000, 9999);
    }
}
