<?php

use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ciudadano\GenerarCertificadoController;

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/certificado', [GenerarCertificadoController::class, 'solicitar'])
  ->name('certificado.solicitar');
    Route::post('/certificado', [GenerarCertificadoController::class, 'generar'])
    ->name('certificado.generar');
  
});


Route::get('/users', [UserController::class, 'index'])->name('users.index');

  // Rutas para el controlador de GenerarCertificado

  
  Route::get('/certificado/{uuid}', [GenerarCertificadoController::class, 'buscarPorUuid'])
  ->name('certificado.buscarPorUuid');

Route::get('/cargar-archivos', function () {
    return view('upload.cargar');})->name('upload.archivo');

Route::post('/guardar-archivo', [FileController::class, 'store'])
->name('store.file');

Route::get('/ver-archivo/{nombreArchivo}', [FileController::class, 'show'])
->name('show.file');


