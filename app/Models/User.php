<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'google_id',
        'facebook_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logFillable()
        ->useLogName('User')
        ->setDescriptionForEvent(fn(string $eventName) => "Se ha " . match ($eventName) { 'created' => 'creado', 'updated' => 'actualizado', 'deleted' => 'eliminado', default => $eventName } . " un usuario");
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the membership associated with the user.
     */
    public function membresia()
    {
        return $this->hasOne(Membresia::class, 'id_usuario');
    }

    /**
     * The classes that a user is enrolled in (for clients).
     */
    public function clases()
    {
        return $this->belongsToMany(Clase::class, 'asistencias', 'id_usuario', 'id_clase');
    }

    /**
     * The classes that a user teaches (for professors).
     */
    public function clasesImpartidas()
    {
        return $this->hasMany(Clase::class, 'id_profesor');
    }
}
