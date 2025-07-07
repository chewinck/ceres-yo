<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Ciudadano\GenerarCertificadoController;

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
  
});


Route::get('/users', [UserController::class, 'index'])->name('users.index');

  // Rutas para el controlador de GenerarCertificado

  Route::get('/certificado', [GenerarCertificadoController::class, 'solicitar'])
  ->name('certificado.solicitar');
  Route::get('/certificado/{uuid}', [GenerarCertificadoController::class, 'buscarPorUuid'])
  ->name('certificado.buscarPorUuid');
Route::post('/certificado/generar', [GenerarCertificadoController::class, 'generar'])
->name('certificado.generar');

require __DIR__.'/auth.php';
