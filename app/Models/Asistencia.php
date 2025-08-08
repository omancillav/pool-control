<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Asistencia extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'asistencias';

    protected $fillable = [
        'id_clase',
        'id_usuario',
        'presente',
        'observaciones',
        'fecha_marcado',
    ];

    protected $casts = [
        'presente' => 'boolean',
        'fecha_marcado' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('Asistencia')
            ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) {
                'created' => 'registrado',
                'updated' => 'actualizado',
                'deleted' => 'eliminado',
                default => $eventName
            } . " una asistencia");
    }

    /**
     * Get the clase that owns the Asistencia
     */
    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class, 'id_clase');
    }

    /**
     * Get the usuario that owns the Asistencia
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
