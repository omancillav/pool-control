<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Asistencia extends Model
{
    use HasFactory;

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
