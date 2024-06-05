<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Task;
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
        // IDs de clientes existentes
        $clientes = Customer::pluck('id')->toArray();

        // Datos de ejemplo
        $nombres = [
            'Tarea 1', 'Tarea 2', 'Tarea 3', 'Tarea 4', 'Tarea 5',
            'Tarea 6', 'Tarea 7', 'Tarea 8', 'Tarea 9', 'Tarea 10'
        ];
        $descripciones = [
            'Descripción de tarea 1', 'Descripción de tarea 2', 'Descripción de tarea 3',
            'Descripción de tarea 4', 'Descripción de tarea 5', 'Descripción de tarea 6',
            'Descripción de tarea 7', 'Descripción de tarea 8', 'Descripción de tarea 9',
            'Descripción de tarea 10'
        ];
        $facturados = [true, false, true, false, true, false, true, false, true, false];
        $suplidos = [100.00, 200.00, 150.00, 300.00, 250.00, 100.00, 200.00, 150.00, 300.00, 250.00];
        $costes = [500.00, 600.00, 700.00, 800.00, 900.00, 500.00, 600.00, 700.00, 800.00, 900.00];
        $estados = ['pendiente', 'en_progreso', 'completada', 'pendiente', 'en_progreso', 'completada', 'pendiente', 'en_progreso', 'completada', 'pendiente'];
        $tipos = ['tipo1', 'tipo2', 'tipo3', 'tipo1', 'tipo2', 'tipo3', 'tipo1', 'tipo2', 'tipo3', 'tipo1'];
        $observaciones = [
            'Observación de tarea 1', 'Observación de tarea 2', 'Observación de tarea 3',
            'Observación de tarea 4', 'Observación de tarea 5', 'Observación de tarea 6',
            'Observación de tarea 7', 'Observación de tarea 8', 'Observación de tarea 9',
            'Observación de tarea 10'
        ];
        $creado_por = ['Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin', 'Admin'];

        for ($i = 0; $i < count($nombres); $i++) {
            Task::create([
                'id_cliente' => $clientes[array_rand($clientes)],
                'nombre' => $nombres[$i],
                'descripcion' => $descripciones[$i],
                'facturado' => $facturados[$i],
                'suplidos' => $suplidos[$i],
                'coste' => $costes[$i],
                'estado' => $estados[$i],
                'tipo' => $tipos[$i],
                'observaciones' => $observaciones[$i],
                'creado_por' => $creado_por[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
