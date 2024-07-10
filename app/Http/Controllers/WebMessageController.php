<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class WebMessageController extends Controller
{
    // Guarda el mensaje recibido en la base de datos
    public function store(Request $request)
    {

        // Validar el reCAPTCHA token
        $recaptchaToken = $request->input('recaptchaToken');
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=YOUR_SECRET_KEY&response=" . $recaptchaToken);
        $recaptchaResponse = json_decode($response);

        if (!$recaptchaResponse->success || $recaptchaResponse->score < 0.5) {
            return response()->json(['error' => 'Error de validación reCAPTCHA'], 403);
        }

        // Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required',
            'email' => 'required|email',
            'sede' => 'required',
            'asunto' => 'required',
            'mensaje' => 'required',
            'privacy' => 'accepted',

        ]);

        // Crear y almacenar el mensaje en la base de datos
        WebMessage::create($validatedData);

        return response()->json(['success' => true]);
    }

    // Devuelve los mensajes ordenados por fecha
    public function webMessages()
    {
        $webMessages = WebMessage::orderBy('fecha_creacion', 'desc')->get();
        return response()->json($webMessages);
    }

    // Borra un mensaje
    public function borrarWebMessage($id)
    {

        $webMessage = WebMessage::findOrFail($id);
        $webMessage->delete();

        return response()->json(null, 204);
    }
}
