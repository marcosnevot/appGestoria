<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();
        return response()->json($users);
    }


    /**
     * Set user's online status to true.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setOnline($id)
    {
        $user = User::findOrFail($id);
        $user->online = true;
        $user->save();

        return response()->json(['message' => 'User online status set to true'], 200);
    }

    /**
     * Set user's online status to false.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setOffline($id)
    {
        $user = User::findOrFail($id);
        $user->online = false;
        $user->save();

        return response()->json(['message' => 'User online status set to false'], 200);
    }



    // Método para añadir un nuevo usuario
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        $request->validate([
            'name' => ['required', 'string', 'unique:' . User::class],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'id_rol' => 'required|integer|exists:rol,id',
            'password' => ['required', Rules\Password::defaults()],

        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'id_rol' => $request->id_rol,
            'password' => Hash::make($request->password),

        ]);

        return response()->json($user, 201);
    }

    // Método para editar un usuario existente

    public function update(Request $request, $id)
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser || $authenticatedUser->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        // Verificar si el usuario está intentando editar su propio usuario
        if ($authenticatedUser->id === (int)$id) {
            return response()->json(['error' => 'No puedes editar tu propio usuario.'], 403);
        }

        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'El usuario no existe.'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|string|email',
            'id_rol' => 'required|numeric|exists:rol,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->id_rol = $request->id_rol;

        $user->save();

        return response()->json($user, 200);
    }


    // Método para borrar un usuario existente
    public function destroy($id)
    {
        $authenticatedUser = Auth::user();
        if (!$authenticatedUser || $authenticatedUser->id_rol !== 1) {
            return response()->json(['error' => 'No tienes permiso para realizar esta acción.'], 403);
        }

        // Verificar si el usuario está intentando editar su propio usuario
        if ($authenticatedUser->id === (int)$id) {
            return response()->json(['error' => 'No puedes borrar tu propio usuario.'], 403);
        }

        User::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
