<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $table = 'tarea';

    protected $fillable = [
        'id_cliente',
        'nombre',
        'descripcion',
        'fecha_creacion',
        'fecha_fin',
        'facturado',
        'suplidos',
        'coste',
        'precio',
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
        'fecha_fin' => 'datetime',
        'facturado' => 'boolean',
        'suplidos' => 'decimal:2',
        'coste' => 'decimal:2',
        'precio' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Customer::class, 'id_cliente');
    }
}
