<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WebMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class WebMessageController extends Controller
{
    // Guarda el mensaje recibido en la base de datos
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nombre' => 'required',
            'email' => 'nullable|email',
            'asunto' => 'nullable|string',
            'sede' => 'required|string',
            'g-recaptcha-response' => 'required',
            'mensaje' => 'nullable|string',
            'adjuntos.*' => 'nullable|file|max:2048|mimes:pdf,jpeg,png,jpg,gif', // Archivos adjuntos: máximo 2MB, PDF y fotos
        ]);

        
        $recaptcha = new \ReCaptcha\ReCaptcha(env('RECAPTCHA_SECRET_KEY'));
        $response = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        if ($validator->fails() || !$response->isSuccess()) {
            $errors = $validator->errors()->merge(['g-recaptcha-response' => ['validation.captcha']]);
            return response()->json(['errors' => $errors], 422);
        } 

        // Almacenar los archivos adjuntos y obtener sus rutas
    $adjuntos = [];
    foreach ($request->file('adjuntos') as $file) {
        // Validar el tamaño del archivo (en caso de que la validación de Laravel falle)
        if ($file->getSize() > 2048000) { // Tamaño en bytes (2MB)
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('adjuntos', 'El archivo "' . $file->getClientOriginalName() . '" excede el tamaño permitido de 2MB.');
            return response()->json(['errors' => $errors], 422);
        }

        // Validar el tipo de archivo (PDF y fotos solamente)
        $allowedTypes = ['pdf', 'jpeg', 'png', 'jpg', 'gif'];
        if (!in_array($file->getClientOriginalExtension(), $allowedTypes)) {
            $errors = new \Illuminate\Support\MessageBag;
            $errors->add('adjuntos', 'El archivo "' . $file->getClientOriginalName() . '" no es un PDF ni una imagen válida.');
            return response()->json(['errors' => $errors], 422);
        }

        // Generar un nombre único para el archivo
        $fileName = time() . '_' . $file->getClientOriginalName();

        // Guardar el archivo en el directorio 'public/uploadsWeb' utilizando Storage::putFileAs
        $path = $file->storeAs('public/uploadsWeb', $fileName);

        // Obtener la ruta de almacenamiento relativa
        $adjuntos[] = str_replace('public', 'storage', $path); // Cambiar 'public' por 'storage' en la ruta
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
