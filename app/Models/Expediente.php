<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $table = 'expedientes';

    protected $fillable = [
        'paciente_id',
        'cita_id',
        'tratamiento_id',
        'odontologo_id',
        'asistente_id',
        'fecha',
        'pieza_dental',
        'diagnostico',
        'descripcion_tratamiento',
        'observaciones',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Relación con el paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con la cita (opcional)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // Relación con el tratamiento
    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }

    // Relación con el odontólogo (Usuario)
    public function odontologo()
    {
        return $this->belongsTo(Usuario::class, 'odontologo_id');
    }

    // Relación con el asistente (Usuario)
    public function asistente()
    {
        return $this->belongsTo(Usuario::class, 'asistente_id');
    }
}
