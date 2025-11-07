<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    /**
     * La tabla asociada con el modelo.
     */
    protected $table = 'pacientes';

    /**
     * Los atributos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'nombre_completo',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'direccion',
        'ciudad',
        'alergias',
        'condiciones_medicas',
        'contacto_emergencia',
        'telefono_emergencia',
    ];

    /**
     * Los atributos que deben ser cast a tipos nativos.
     */
    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Relación: Un paciente tiene muchas citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

    /**
     * Relación: Un paciente tiene muchos expedientes
     */
    public function expedientes()
    {
        return $this->hasMany(Expediente::class);
    }

    /**
     * Relación: Un paciente tiene muchas facturas
     */
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }
}
