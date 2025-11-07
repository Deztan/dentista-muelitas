<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';

    protected $fillable = [
        'paciente_id',
        'usuario_id',
        'tratamiento_id',
        'fecha',
        'hora',
        'duracion_minutos',
        'estado',
        'motivo',
        'notas',
        'recordatorio_enviado',
    ];

    protected $casts = [
        'fecha' => 'date',
        'recordatorio_enviado' => 'boolean',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
