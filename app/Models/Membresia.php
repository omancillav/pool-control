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
}