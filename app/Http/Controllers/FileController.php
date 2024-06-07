<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{

    // Obtiene la lista de archivos de 'public' dentro del directorio 'uploads'
    public function listFiles()
    {
        $files = Storage::disk('public')->files('uploads');

        $filesWithCreationTime = [];
        foreach ($files as $file) {
            $creationTime = filectime(storage_path('app/public/' . $file));
            $filesWithCreationTime[$file] = $creationTime;
        }

        arsort($filesWithCreationTime);

        $sortedFiles = array_keys($filesWithCreationTime);

        return response()->json(['success' => true, 'files' => $sortedFiles]);
    }

    //  Guardar el archivo a una carpeta del proyecto
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $path = $file->storeAs('public/uploads', $fileName);

        return response()->json(['success' => true, 'message' => 'Archivo subido exitosamente', 'path' => $path]);
    }

    // Borrar un archivo según su nombre
    public function delete($fileName)
    {
        if (Storage::disk('public')->exists('uploads/' . $fileName)) {
            Storage::disk('public')->delete('uploads/' . $fileName);
            return response()->json(['success' => true, 'message' => 'Archivo borrado exitosamente']);
        }

        return response()->json(['success' => false, 'message' => 'El archivo no existe']);
    }

    // Descargar un archivo
    public function download($fileName)
    {
        $filePath = storage_path('app/public/uploads/' . $fileName);

        if (file_exists($filePath)) {
            return response()->download($filePath, $fileName);
        }

        return response()->json(['success' => false, 'message' => 'El archivo no existe']);
    }

    // Obtener el contenido de un archivo según su nombre
    public function getFileContent($fileName)
    {
        if (Storage::disk('public')->exists('uploads/' . $fileName)) {
            $fileContent = Storage::disk('public')->get('uploads/' . $fileName);

            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            $mimeType = $this->getMimeType($fileExtension);

            return response($fileContent, 200)
                ->header('Content-Type', $mimeType);
        } else {
            return response()->json(['success' => false, 'message' => 'El archivo no existe'], 404);
        }
    }


    // Obtien el tipo MIME correspondiente a la extensión del archivo
    private function getMimeType($fileExtension)
    {
        $mimeTypes = [
            'txt' => 'text/plain',
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return $mimeTypes[$fileExtension] ?? 'application/octet-stream';
    }
}
