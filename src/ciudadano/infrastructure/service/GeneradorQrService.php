<?php

namespace Src\ciudadano\infrastructure\service;

use SimpleSoftwareIO\QrCode\Facades\QrCode;   // facade recomendado

class GeneradorQrService
{
    public static function generarQR(string $dominio, string $uuid): string
    {
        $urlConUuid = "{$dominio}/certificado/{$uuid}";
    
        // 1. Generar la imagen QR (binario PNG)
        $qrBinary = QrCode::format('png')      // Salida PNG
            ->size(100)                        // 100 px
            ->errorCorrection('H')             // Nivel de corrección (opcional)
            ->eye('circle')                    // Estilo visual (opcional, v4 lo soporta)
            ->generate($urlConUuid);           // Contenido
    
        // 2. Guardar en un archivo temporal
        $tempPath = tempnam(sys_get_temp_dir(), 'qr_') . '.png';
        file_put_contents($tempPath, $qrBinary);
    
        return $tempPath;                      // Ruta que luego usarás en setImageValue
    }

}