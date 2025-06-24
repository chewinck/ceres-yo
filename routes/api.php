<?php

use App\Http\Controllers\Ciudadano\GenerarCertificadoController;
use Illuminate\Support\Facades\Route;


  // Rutas para el controlador de GenerarCertificado
  Route::post('/certificado', [GenerarCertificadoController::class, 'generar'])
  ->name('certificado.generar');
