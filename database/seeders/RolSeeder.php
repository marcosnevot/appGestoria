<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; // Asegúrate de importar el modelo Rol si está en un namespace diferente

class RolSeeder extends Seeder
{
    public function run()
    {
        // Crea un rol de administrador
        Role::create([
            'nombre' => 'admin',

        ]);

        Role::create([
            'nombre' => 'employee',
            
        ]);
    }
}
