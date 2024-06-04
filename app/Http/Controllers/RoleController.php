<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Método para obtener todos los roles
    public function roles()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // Método para editar un rol
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return response()->json($role);
    }

    // Método para añadir un nuevo rol
    public function store(Request $request)
    {
        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    // Método para borrar un rol
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
