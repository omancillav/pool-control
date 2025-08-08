<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Clase extends Model
{
    use HasFactory, LogsActivity;
    protected $fillable = [
        'fecha',
        'id_profesor',
        'nivel',
        'lugares',
        'lugares_ocupados',
        'lugares_disponibles',
    ];
      public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('Clase')
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) { 'created' => 'creado', 'updated' => 'actualizado', 'deleted' => 'eliminado', default => $eventName } . " una clase");
    }

    protected $casts = [
        'fecha' => 'date',
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'id_profesor');
    }

    /**
     * The users that are enrolled in this class (for clients).
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'asistencias', 'id_clase', 'id_usuario');
    }

    /**
     * Las reservaciones de esta clase.
     */
    public function reservaciones()
    {
        return $this->hasMany(Reservacion::class, 'id_clase');
    }

    /**
     * Las asistencias de la clase.
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_clase');
    }

    /**
     * Los pagos de esta clase a través de las reservaciones.
     */
    public function pagos()
    {
        return $this->hasManyThrough(Pago::class, Reservacion::class, 'id_clase', 'id_reservacion');
    }

    /**
     * Asignar precio automáticamente basado en el nivel
     */
    public function asignarPrecioPorNivel()
    {
        $precios = Pago::getPreciosPorNivel();
        $this->precio = $precios[$this->nivel] ?? 250.00; // Precio por defecto si el nivel no existe
        return $this;
    }

    /**
     * Obtener el precio formateado
     */
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2) . ' MXN';
    }
}