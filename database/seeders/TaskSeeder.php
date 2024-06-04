<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define los datos de ejemplo para expedientes
        $tasks = [
            [
                'id_cliente' => 1, // ID del cliente al que pertenece el expediente
                'nombre' => 'Tarea Uno',
                'descripcion' => 'Descripción de la tarea Uno',
                'fecha_creacion' => now(), // Fecha y hora actual
                'facturado' => false, // No facturado
            ],
            [
                'id_cliente' => 1,
                'nombre' => 'Tarea Dos',
                'descripcion' => 'Descripción de la tarea Dos',
                'fecha_creacion' => now(), // Fecha y hora actual
                'facturado' => true, // No facturado
            ],

            [
                'id_cliente' => 3,
                'nombre' => 'Tarea Tres',
                'descripcion' => 'Descripción de la tarea Tres',
                'fecha_creacion' => now(), // Fecha y hora actual
                'facturado' => false, // No facturado
            ],
            [
                'id_cliente' => 4,
                'nombre' => 'Tarea Cuatro',
                'descripcion' => 'Descripción de la tarea Cuatro',
                'fecha_creacion' => now(), // Fecha y hora actual
                'facturado' => false, // No facturado
            ],
            [
                'id_cliente' => 5,
                'nombre' => 'Tarea Cinco',
                'descripcion' => 'Descripción de la tarea Cinco',
                'fecha_creacion' => now(), // Fecha y hora actual
                'facturado' => false, // No facturado
            ],
        ];

        // Inserta los datos en la tabla tarea
        DB::table('tarea')->insert($tasks);
    }
}
