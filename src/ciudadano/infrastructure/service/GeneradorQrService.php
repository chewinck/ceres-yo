<?php

namespace Src\ciudadano\infrastructure\service;

use SimpleSoftwareIO\QrCode\Facades\QrCode;   // facade recomendado

class GeneradorQrService
{
    public static function generarQR(string $dominio, string $uuid): string
    {
        // $urlConUuid = "{$dominio}/certificado/{$uuid}";
        $urlConUuid = rtrim($dominio, '/') . "/certificado/{$uuid}";
        if (!preg_match('/^https?:\/\//', $urlConUuid)) {
            $urlConUuid = "http://{$urlConUuid}";
        }

        // dd($urlConUuid); // Para depurar y ver la URL generada
    
        // 1. Generar la imagen QR (binario PNG)
        $qrBinary = QrCode::format('png')      // Salida PNG
            ->size(70)                        // 100 px
            ->errorCorrection('H')             // Nivel de corrección (opcional)
            ->eye('circle')                    // Estilo visual (opcional, v4 lo soporta)
            ->generate($urlConUuid);           // Contenido
    
        // 2. Guardar en un archivo temporal
        $tempPath = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        // $path = storage_path('app/public/qr_test.png');
        // file_put_contents($path, $qrBinary);
        file_put_contents($tempPath, $qrBinary);
    
        return $tempPath;                     
    }

}