<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileStoreFormRequest;


class FileController extends Controller
{   
    public function index()
    {
        return view('upload.cargar');
    }

    public function show(Request $request, $nombreArchivo)
    {
        
    $request->merge(['nombreArchivo' => $nombreArchivo]);

    $request->validate([
        'nombreArchivo' => ['required', 'string', 'regex:/^[a-zA-Z0-9_\-\.]+$/'],
    ]);

        $path = 'pdfs/' . $nombreArchivo. '.pdf';
        $filePath = storage_path('app/private/' . $path);
        
        if (!file_exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"'
        ]);
    }



    public function store(FileStoreFormrequest $request)
    {
        // Aquí puedes manejar el archivo subido

        if ($request->hasFile('documento_pdf')) {

            $nombreArchivo = 'certificado_' . time() . '.pdf'; // ejemplo dinámico
            $path = $request->file('documento_pdf')->storeAs('pdfs', $nombreArchivo, 'local');

            return response()->json([
                'status' => 'success',
                'message' => 'Archivo cargado correctamente.',
                'file_path' => $path
            ], 200);
            // Guardar $path en la base de datos si es necesario
        }
        return response()->json([
            'status' => 'error',
            'message' => 'No se recibió el archivo.'
        ], 400);
    }
}