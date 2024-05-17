<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    public function clientes()
    {
        try {
            // Verifica si el usuario autenticado tiene el rol con id 1
            $user = Auth::user();
            if ($user->id_rol !== 1) {
                return response()->json(['error' => 'No tienes permiso para acceder a esta funcionalidad'], 403);
            }

            // Recupera los datos de los clientes
            $clientes = Cliente::all();

            // Devuelve los datos de los clientes en formato JSON
            return response()->json($clientes);
        } catch (\Exception $e) {
            // Manejo de excepciones
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    public function agregarCliente(Request $request)
    {
        // Verifica si el usuario autenticado tiene id_rol = 1
        $user = Auth::user();
        if ($user->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'direccion' => 'nullable|string',
            'numeroCuentaBancaria' => 'nullable|string',
            'nif' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'direccion' => $request->direccion,
            'numeroCuentaBancaria' => $request->numeroCuentaBancaria,
            'nif' => $request->nif,
            'observaciones' => $request->observaciones,
        ]);

        return response()->json($cliente, 201);
    }


    public function editarCliente(Request $request, $id)
{
    // Verifica si el usuario autenticado tiene id_rol = 1
    if (Auth::user()->id_rol !== 1) {
        return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
    }

    $cliente = Cliente::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:50',
        'direccion' => 'nullable|string|max:255',
        'numeroCuentaBancaria' => 'nullable|string|max:20',
        'nif' => 'nullable|string|max:20',
        'observaciones' => 'nullable|string',
    ]);

    $cliente->update([
        'nombre' => $request->nombre,
        'telefono' => $request->telefono,
        'email' => $request->email,
        'direccion' => $request->direccion,
        'numeroCuentaBancaria' => $request->numeroCuentaBancaria,
        'nif' => $request->nif,
        'observaciones' => $request->observaciones,
    ]);

    return response()->json($cliente, 200);
}


    public function borrarCliente($id)
    {
        // Verifica si el usuario autenticado tiene id_rol = 1
        if (Auth::user()->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        return response()->json(null, 204);
    }

    public function obtenerNombreCliente($id)
    {
        $cliente = Cliente::find($id);
        
        if ($cliente) {
            return response()->json(['nombre' => $cliente->nombre]);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    public function show($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }
}
