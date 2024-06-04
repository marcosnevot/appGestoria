<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'rol'; 
    protected $fillable = [
        'nombre',
    ];

    // Relación uno a muchos inversa con la tabla de usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol', 'id');
    }
}
