<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'odontologo_id',
        'asistente_id',
        'tratamiento_id',
        'fecha',
        'hora',
        'duracion_minutos',
        'estado',
        'motivo',
        'observaciones',
        'recordatorio_enviado',
        'recordatorio_fecha',
    ];

    protected $casts = [
        'fecha' => 'date',
        'recordatorio_enviado' => 'boolean',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function odontologo()
    {
        return $this->belongsTo(Usuario::class, 'odontologo_id');
    }

    public function asistente()
    {
        return $this->belongsTo(Usuario::class, 'asistente_id');
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
