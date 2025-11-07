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

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }
}
