<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Membresia extends Model
{
    use HasFactory, LogsActivity;


    protected $table = 'membresias';


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('Membresia')
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) { 'created' => 'creado', 'updated' => 'actualizado', 'deleted' => 'eliminado', default => $eventName } . " una membresía");
    }

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

    /**
     * Verificar si la membresía tiene clases disponibles
     */
    public function tieneClasesDisponibles()
    {
        return $this->clases_disponibles > 0;
    }

    /**
     * Obtener el porcentaje de clases utilizadas
     */
    public function porcentajeUtilizado()
    {
        if ($this->clases_adquiridas == 0) {
            return 0;
        }
        return round(($this->clases_ocupadas / $this->clases_adquiridas) * 100, 1);
    }

    /**
     * Scope para membresías activas (con clases disponibles)
     */
    public function scopeActivas($query)
    {
        return $query->where('clases_disponibles', '>', 0);
    }   
}