<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol; // Asegúrate de importar el modelo Rol si está en un namespace diferente

class RolSeeder extends Seeder
{
    public function run()
    {
        // Crea un rol de administrador
        Rol::create([
            'nombre' => 'admin',
        ]);
    }
}
