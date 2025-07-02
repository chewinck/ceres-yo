<?php


namespace Src\ciudadano\infrastructure\service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Carbon\Carbon;





class UtilService
{
    public static function logCertificadoGeneration(string $categoria, string $tipo): void
    {
        Log::info("Este es el certificado de categoría {$categoria} y tipo {$tipo}");
    }
    public static function generateUniqueId(): string
    {
        return (string) Str::uuid();
    }
}