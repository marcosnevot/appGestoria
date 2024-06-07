<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    // Obtener los clientes de la base de datos
    public function clientes()
    {
        try {
            $clientes = Customer::all();
            return response()->json($clientes);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ha ocurrido un error al procesar la solicitud'], 500);
        }
    }

    // Agregar un cliente
    public function agregarCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable|string',
            'email' => 'nullable|email',
            'direccion' => 'nullable|string',
            'numeroCuentaBancaria' => 'nullable|string',
            'nif' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ]);

        $cliente = Customer::create([
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


    // Editar un cliente
    public function editarCliente(Request $request, $id)
    {


        $cliente = Customer::findOrFail($id);

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


    // Borrar un cliente
    public function borrarCliente($id)
    {


        $cliente = Customer::findOrFail($id);
        $cliente->delete();

        return response()->json(null, 204);
    }

    // Obtener el nombre de un cliente según su ID
    public function obtenerNombreCliente($id)
    {
        $cliente = Customer::find($id);

        if ($cliente) {
            return response()->json(['nombre' => $cliente->nombre]);
        } else {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }
    }

    // Obtener un cliente según su ID
    public function show($id)
    {
        $cliente = Customer::find($id);

        if (!$cliente) {
            return response()->json(['error' => 'Cliente no encontrado'], 404);
        }

        return response()->json($cliente, 200);
    }
}
