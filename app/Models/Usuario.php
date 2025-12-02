<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'telefono',
        'rol',
        'activo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Laravel 11 automáticamente hashea el password
    ];

    // Citas como odontólogo
    public function citasComoOdontologo()
    {
        return $this->hasMany(Cita::class, 'odontologo_id');
    }

    // Citas como asistente
    public function citasComoAsistente()
    {
        return $this->hasMany(Cita::class, 'asistente_id');
    }

    // Todas las citas relacionadas (odontólogo o asistente)
    public function citas()
    {
        return $this->citasComoOdontologo();
    }

    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'odontologo_id');
    }
}
