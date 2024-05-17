<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function users()
    {
        $users = User::where('id_rol', 1)->get();
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
   
}
