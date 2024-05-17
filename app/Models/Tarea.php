<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{

    protected $table = 'tarea';

    protected $fillable = [
        'id_cliente',
        'nombre',
        'descripcion',
        'fecha_creacion',
        'facturado',
        'suplidos',
        'coste',
        'estado',
        'observaciones',
        'tipo',
        'creado_por',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'fecha_creacion' => 'datetime',
        'facturado' => 'boolean',
        'suplidos' => 'decimal:2',
        'coste' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
