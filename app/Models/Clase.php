<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Clase extends Model
{
    use LogsActivity;
    protected $fillable = [
        'fecha',
        'id_profesor',
        'tipo',
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
}