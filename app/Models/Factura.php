<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [
        'numero_factura',
        'paciente_id',
        'tratamiento_id',
        'fecha_emision',
        'monto_total',
        'monto_pagado',
        'estado',
        'metodo_pago',
        'notas',
    ];

    protected $casts = [
        'fecha_emision' => 'date',
        'monto_total' => 'decimal:2',
        'monto_pagado' => 'decimal:2',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    public function tratamiento()
    {
        return $this->belongsTo(Tratamiento::class);
    }
}
