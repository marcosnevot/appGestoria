<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;


class WebMessageController extends Controller
{
    // Guarda el mensaje recibido en la base de datos
    public function store(Request $request)
    {
          // Validar los datos del formulario, incluido el token de reCAPTCHA
          $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'sede' => 'required',
            'g-recaptcha-response' => 'required',
        ]);

        // Verificar la validez del token de reCAPTCHA
        $recaptcha = new \ReCaptcha\ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if ($validator->fails() || !$response->isSuccess()) {
            $errors = $validator->errors()->merge(['g-recaptcha-response' => ['validation.captcha']]);
            return response()->json(['errors' => $errors], 422);
        }

        // Crear y almacenar el mensaje en la base de datos
        WebMessage::create($request->all());

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
