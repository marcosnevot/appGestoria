<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de importar el modelo User si está en un namespace diferente

class UserSeeder extends Seeder
{
    public function run()
    {
        // Crea un usuario administrador y asigna el rol de administrador
        User::create([
            'name' => 'm',
            'email' => 'm@n.com',
            'password' => Hash::make('12345678'), // Asegúrate de cambiar 'password' por la contraseña que desees
            'id_rol' => Rol::where('nombre', 'admin')->first()->id,
        ]);
    }
}
