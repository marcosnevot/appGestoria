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

        // Validar reCAPTCHA
        $recaptchaToken = $request->input('recaptcha_token');
        $recaptchaSecret = env('RECAPTCHA_SECRET_KEY');

        if (!$recaptchaSecret) {
            return response()->json(['errors' => ['recaptcha' => 'reCAPTCHA secret key not configured']], 500);
        }

        $client = new Client();

        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => $recaptchaSecret,
                'response' => $recaptchaToken,
            ],
        ]);

        $body = json_decode((string) $response->getBody());

        if (!$body->success) {
            return response()->json(['errors' => ['recaptcha' => 'reCAPTCHA verification failed']], 422);
        }

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
    public function webMessages(Request $request)
    {
        // Obtiene los parámetros de búsqueda y filtro desde la solicitud
        $search = $request->input('search', null); // Búsqueda general
        $sede = $request->input('sede', null);     // Filtro por sede

        // Construcción de la consulta
        $query = WebMessage::query();

        // Filtra por texto de búsqueda (nombre, asunto, mensaje o email)
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                    ->orWhere('asunto', 'like', '%' . $search . '%')
                    ->orWhere('mensaje', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Filtra por sede si se proporciona un valor distinto de 'all'
        if (!empty($sede) && $sede !== 'all') {
            $query->where('sede', $sede);
        }

        // Ordena por fecha de creación y obtiene los resultados
        $webMessages = $query->orderBy('fecha_creacion', 'desc')->get();

        // Decodifica los adjuntos en cada mensaje
        foreach ($webMessages as $message) {
            $message->adjuntos = json_decode($message->adjuntos);
        }

        return response()->json($webMessages);
    }


    // Borra un mensaje
    public function borrarWebMessage($id)
    {

        $webMessage = WebMessage::findOrFail($id);
        $webMessage->delete();

        return response()->json(null, 204);
    }

    public function downloadAttachment($fileName)
    {
        // Decodifica el nombre del archivo recibido
        $decodedFileName = urldecode($fileName);
        $filePath = storage_path('app/public/uploadsWeb/' . $decodedFileName);

        // Log::info('Token válido. Procesando la descarga para el archivo: ' . $decodedFileName);

        // Verificar si el archivo existe
        if (file_exists($filePath)) {
            return response()->download($filePath, $decodedFileName);
        }

        Log::error('El archivo no existe: ' . $filePath);
        return response()->json(['success' => false, 'message' => 'El archivo no existe'], 404);
    }
}
