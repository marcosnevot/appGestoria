<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function loginUser(Request $request)
    {

        if (!Auth::attempt($request->only('name', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('name', $request['name'])->firstOrFail();

    
        

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()
            ->json([
                'message' => 'Hello, ' . $user->name,
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
    }
}
