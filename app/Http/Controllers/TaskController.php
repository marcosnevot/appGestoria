<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // Obtiene las tareas de la base de datos
    public function tareas()
    {
        $tareas = Task::orderBy('fecha_creacion', 'desc')->get();
        return response()->json($tareas);
    }

    // Agrega una tarea
    public function agregarTarea(Request $request)
    {

        // Valida los datos
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
            'id_cliente' => 'required|integer|exists:cliente,id',
            'facturado' => 'nullable|boolean',
            'tipo' => 'nullable|string',
            'suplidos' => 'nullable|numeric',
            'coste' => 'nullable|numeric',
            'precio' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'creado_por' => 'nullable|string',
            'estado' => 'nullable|in:pendiente,en_progreso,completada',

        ]);

        // Crea la tarea con los datos que recibe
        $tarea = Task::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
            'fecha_fin' => $request->fecha_fin,
            'id_cliente' => $request->id_cliente,
            'facturado' => $request->facturado,
            'tipo' => $request->tipo,
            'suplidos' => $request->suplidos,
            'coste' => $request->coste,
            'precio' => $request->precio,
            'observaciones' => $request->observaciones,
            'creado_por' => $request->creado_por,
            'estado' => $request->estado,
        ]);

        return response()->json($tarea, 201);
    }

    // Edita una tarea
    public function editarTarea(Request $request, $id)
    {
        // Busca la tarea por su ID
        $tarea = Task::find($id);

        // Si la tarea no existe, devuelve un error
        if (!$tarea) {
            return response()->json(['error' => 'La tarea no existe.'], 404);
        }

        // Valida los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_fin' => 'nullable|date',
            'tipo' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'facturado' => 'nullable|boolean',
            'suplidos' => 'nullable|numeric',
            'coste' => 'nullable|numeric',
            'precio' => 'nullable|numeric',
             'estado' => 'nullable|in:pendiente,en_progreso,completada',
        ]);

        // Actualiza los campos de la tarea con los datos de la solicitud
        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->fecha_fin = $request->fecha_fin;
        $tarea->tipo = $request->tipo;
        $tarea->observaciones = $request->observaciones;
        $tarea->facturado = $request->facturado;
        $tarea->suplidos = $request->suplidos;
        $tarea->coste = $request->coste;
        $tarea->precio = $request->precio;
        $tarea->estado = $request->estado;

        // Guarda los cambios en la base de datos
        $tarea->save();

        // Devuelve la tarea actualizada en la respuesta JSON
        return response()->json($tarea, 200);
    }


    // Elimina una tarea
    public function borrarTarea($id)
    {
        // Busca la tarea por su ID
        $tarea = Task::findOrFail($id);
        // Borra la tarea
        $tarea->delete();

        return response()->json(null, 204);
    }
}
