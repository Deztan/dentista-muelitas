<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'descripcion',
        'unidad_medida',
        'stock_actual',
        'stock_minimo',
        'precio_unitario',
        'proveedor',
        'activo',
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'activo' => 'boolean',
    ];
}
