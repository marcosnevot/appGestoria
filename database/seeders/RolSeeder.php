<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role; 

class RolSeeder extends Seeder
{
    public function run()
    {
        // Crea un rol de administrador
        Role::create([
            'nombre' => 'admin',

        ]);

       // Crea un rol de empleado
        Role::create([
            'nombre' => 'employee',
            
        ]);
    }
}
