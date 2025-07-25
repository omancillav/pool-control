<?php

use App\Http\Controllers\ClaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;
use App\Http\Controllers\LogController;

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rutas de Membresías
Route::get('/membresias', [MembresiaController::class, 'index'])
    ->name('membresias.nueva')
    ->middleware(['auth', 'rol:Administrador']);
Route::get('/membresias/lista', [MembresiaController::class, 'list'])
    ->name('membresias.list')
    ->middleware(['auth', 'rol:Administrador,Cliente']);
Route::post('/membresias/store', [MembresiaController::class, 'store'])
    ->name('membresias.store')
    ->middleware(['auth', 'rol:Administrador']);
Route::put('/membresias/{membresia}', [MembresiaController::class, 'update'])
    ->name('membresias.update')
    ->middleware(['auth', 'rol:Administrador']);
Route::delete('/membresias/{id}', [MembresiaController::class, 'destroy'])
    ->name('membresias.destroy')
    ->middleware(['auth', 'rol:Administrador']);

// Rutas para Usuarios
Route::get('/usuarios', [UserController::class, 'index'])
    ->name('usuarios.nueva')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::get('/usuarios/lista', [UserController::class, 'list'])
    ->name('usuarios.list')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::post('/usuarios/store', [UserController::class, 'store'])
    ->name('usuarios.store')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::put('/usuarios/{usuario}', [UserController::class, 'update'])
    ->name('usuarios.update')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])
    ->name('usuarios.destroy')
    ->middleware(['auth', 'rol:Administrador,Profesor']);


// Rutas de Clases
Route::get('/clases', [ClaseController::class, 'index'])
    ->name('clases.nueva')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::get('/clases/lista', [ClaseController::class, 'list'])
    ->name('clases.list')
    ->middleware(['auth', 'rol:Administrador,Cliente,Profesor']);
Route::post('/clases/store', [ClaseController::class, 'store'])
    ->name('clases.store')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::put('/clases/{clase}', [ClaseController::class, 'update'])
    ->name('clases.update')
    ->middleware(['auth', 'rol:Administrador,Profesor']);
Route::delete('/clases/{id}', [ClaseController::class, 'destroy'])
    ->name('clases.destroy')
    ->middleware(['auth', 'rol:Administrador,Profesor']);

// Ruta para el Aviso de Privacidad
Route::get('/aviso-de-privacidad', function () {
    return view('privacy.notice');
})->name('privacy.notice');

// Manda a llamar al metodo redirect en los controlador
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Mandan allamar al metodo callback para procesar la respuesta
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// Rutas de autenticación con Facebook
Route::get('auth/facebook/redirect', [FacebookAuthController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('auth/facebook/callback', [FacebookAuthController::class, 'callback'])->name('auth.facebook.callback');

// Ruta para ver los logs de actividad
Route::get('/logs', [LogController::class, 'index'])
    ->name('logs.index')
    ->middleware(['auth', 'rol:Administrador']);