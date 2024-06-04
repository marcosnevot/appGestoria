<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de importar el modelo User si está en un namespace diferente

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crea un usuario administrador y asigna el rol de administrador
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'), // Asegúrate de cambiar 'password' por la contraseña que desees
            'id_rol' => Role::where('nombre', 'admin')->first()->id,
        ]);
        
    }
}
