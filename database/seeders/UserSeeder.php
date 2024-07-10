<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
class UserSeeder extends Seeder
{
    public function run()
    {
        // Crea un usuario administrador y asigna el rol de administrador
        User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'), 
            'id_rol' => Role::where('nombre', 'admin')->first()->id,
        ]);
        User::create([
            'name' => 'nacho123',
            'email' => 'nacho123@admin.com',
            'password' => Hash::make('12345678'), 
            'id_rol' => Role::where('nombre', 'admin')->first()->id,
        ]);
        
    }
}
