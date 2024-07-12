<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ReCaptcha\ReCaptcha;

class WebMessageController extends Controller
{
    // Guarda el mensaje recibido en la base de datos
    public function store(Request $request)
    {

        // Validación de los campos del formulario
        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'nullable|email',
            'asunto' => 'nullable|string',
            'sede' => 'required|string',
            'mensaje' => 'nullable|string',
            'adjuntos.*' => 'nullable|file|max:2048|mimes:pdf,jpeg,png,jpg,gif',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Almacenamiento de archivos adjuntos
        $adjuntos = [];
         // Verificar si se adjuntaron archivos
    if ($request->hasFile('adjuntos')) {
        foreach ($request->file('adjuntos') as $file) {
            // Validación de tamaño y tipo de archivo
            $validator = Validator::make(['adjunto' => $file], [
                'adjunto' => 'required|file|max:2048|mimes:pdf,jpeg,png,jpg,gif',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Generar un nombre único para el archivo
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Guardar el archivo en el directorio 'public/uploadsWeb'
            $path = $file->storeAs('public/uploadsWeb', $fileName);

            // Obtener la ruta de almacenamiento relativa
            $adjuntos[] = str_replace('public', 'storage', $path); // Cambiar 'public' por 'storage' en la ruta
        }
    }

        // Crear y almacenar el mensaje en la base de datos
        $webMessage = new WebMessage();
        $webMessage->nombre = $request->input('nombre');
        $webMessage->email = $request->input('email');
        $webMessage->asunto = $request->input('asunto');
        $webMessage->sede = $request->input('sede');
        $webMessage->mensaje = $request->input('mensaje');
        $webMessage->adjuntos = json_encode($adjuntos); // Convertir array a JSON
        $webMessage->save();

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
