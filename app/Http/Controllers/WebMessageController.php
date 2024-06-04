<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;
use Illuminate\Support\Facades\Auth;

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

    public function webMessages()
    {

        $webMessages = WebMessage::orderBy('fecha_creacion', 'desc')->get();
        return response()->json($webMessages);
    }

    public function borrarWebMessage($id)
    {

        $webMessage = WebMessage::findOrFail($id);
        $webMessage->delete();

        return response()->json(null, 204);
    }
}
