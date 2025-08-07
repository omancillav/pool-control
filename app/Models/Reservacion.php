<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Reservacion extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'reservaciones';
    
    protected $fillable = [
        'id_clase',
        'id_usuario',
        'notas'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('Reservacion')
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) { 
            'created' => 'creado', 
            'updated' => 'actualizado', 
            'deleted' => 'eliminado', 
            default => $eventName 
        } . " una reservación");
    }

    /**
     * Relación con la clase
     */
    public function clase()
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    /**
     * Relación con el usuario (cliente)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
