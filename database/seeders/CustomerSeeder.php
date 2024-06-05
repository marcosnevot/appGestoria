<?php

namespace Database\Seeders;

use App\Models\Customer;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Datos de ejemplo
        $nombres = ['Juan Pérez', 'María García', 'Carlos López', 'Ana Martínez', 'Luis Fernández'];
        $telefonos = ['555-1234', '555-5678', '555-9012', '555-3456', '555-7890'];
        $emails = ['juan.perez@example.com', 'maria.garcia@example.com', 'carlos.lopez@example.com', 'ana.martinez@example.com', 'luis.fernandez@example.com'];
        $direcciones = [
            'Calle Falsa 123, Madrid',
            'Avenida Siempre Viva 456, Barcelona',
            'Plaza Mayor 789, Valencia',
            'Calle Luna 101, Sevilla',
            'Avenida Sol 202, Bilbao'
        ];
        $numerosCuentaBancaria = [
            'ES1234567890123456789012',
            'ES2345678901234567890123',
            'ES3456789012345678901234',
            'ES4567890123456789012345',
            'ES5678901234567890123456'
        ];
        $nifs = ['12345678A', '23456789B', '34567890C', '45678901D', '56789012E'];
        $observaciones = [
            'Cliente preferente',
            'Cliente nuevo',
            'Cliente frecuente',
            'Cliente VIP',
            'Cliente con descuento especial'
        ];

        for ($i = 0; $i < count($nombres); $i++) {
            Customer::create([
                'nombre' => $nombres[$i],
                'telefono' => $telefonos[$i],
                'email' => $emails[$i],
                'direccion' => $direcciones[$i],
                'numeroCuentaBancaria' => $numerosCuentaBancaria[$i],
                'nif' => $nifs[$i],
                'observaciones' => $observaciones[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}