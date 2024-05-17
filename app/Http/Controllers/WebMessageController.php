<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;

class WebMessageController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'sede' => 'required',
            'asunto' => 'required',
            'mensaje' => 'required',
        ]);

        WebMessage::create($validatedData);

        return response()->json(['success' => true]);
    }
}
