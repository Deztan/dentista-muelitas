<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $table = 'tratamientos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_base',
        'duracion_minutos',
    ];

    protected $casts = [
        'precio_base' => 'decimal:2',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
