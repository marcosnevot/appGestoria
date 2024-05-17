<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TareaController extends Controller
{
    public function tareas()
    {
        $tareas = Tarea::orderBy('fecha_creacion', 'desc')->get();
        return response()->json($tareas);
    }

    public function agregarTarea(Request $request)
    {
        // Verifica si el usuario autenticado tiene id_rol = 1
        $user = Auth::user();
        if ($user->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'fecha_creacion' => 'nullable|date',
            'id_cliente' => 'required|integer|exists:cliente,id',
            'facturado' => 'nullable|boolean',
            'tipo' => 'nullable|string',
            'suplidos' => 'nullable|numeric',
            'coste' => 'nullable|numeric',
            'observaciones' => 'nullable|string',
            'creado_por' => 'nullable|string',
            'estado' => 'nullable|in:pendiente,en_progreso,completada',

        ]);

        $tarea = Tarea::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'fecha_creacion' => $request->fecha_creacion,
            'id_cliente' => $request->id_cliente,
            'facturado' => $request->facturado,
            'tipo' => $request->tipo,
            'suplidos' => $request->suplidos,
            'coste' => $request->coste,
            'observaciones' => $request->observaciones,
            'creado_por' => $request->creado_por,
            'estado' => $request->estado,
        ]);

        return response()->json($tarea, 201);
    }

    public function editarTarea(Request $request, $id)
    {
        // Verifica si el usuario está autenticado y tiene el rol necesario
        $user = Auth::user();
        if (!$user || $user->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        // Busca la tarea por su ID
        $tarea = Tarea::find($id);

        // Si la tarea no existe, devuelve un error
        if (!$tarea) {
            return response()->json(['error' => 'La tarea no existe.'], 404);
        }

        // Valida los datos de la solicitud
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'tipo' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'facturado' => 'nullable|boolean',
            'suplidos' => 'nullable|numeric',
            'coste' => 'nullable|numeric',
             'estado' => 'nullable|in:pendiente,en_progreso,completada',
        ]);

        // Actualiza los campos de la tarea con los datos de la solicitud
        $tarea->nombre = $request->nombre;
        $tarea->descripcion = $request->descripcion;
        $tarea->tipo = $request->tipo;
        $tarea->observaciones = $request->observaciones;
        $tarea->facturado = $request->facturado;
        $tarea->suplidos = $request->suplidos;
        $tarea->coste = $request->coste;
        $tarea->estado = $request->estado;

        // Guarda los cambios en la base de datos
        $tarea->save();

        // Devuelve la tarea actualizada en la respuesta JSON
        return response()->json($tarea, 200);
    }


    public function borrarTarea($id)
    {
        // Verifica si el usuario autenticado tiene id_rol = 1
        if (Auth::user()->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        $tarea = Tarea::findOrFail($id);
        $tarea->delete();

        return response()->json(null, 204);
    }
}
