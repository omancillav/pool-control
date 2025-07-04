<?php

use App\Http\Controllers\ClaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\FacebookAuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/membresias', [MembresiaController::class, 'index'])->name('membresias.nueva');
Route::get('/membresias/lista', [MembresiaController::class, 'list'])->name('membresias.list');
Route::post('/membresias/store', [MembresiaController::class, 'store'])->name('membresias.store');
Route::put('/membresias/{membresia}', [MembresiaController::class, 'update'])->name('membresias.update');
Route::delete('/membresias/{id}', [MembresiaController::class, 'destroy'])->name('membresias.destroy');

// Rutas para Usuarios
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.nueva');
Route::get('/usuarios/lista', [UserController::class, 'list'])->name('usuarios.list');
Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
Route::put('/usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');


Route::get('/clases', [ClaseController::class, 'index'])->name('clases.nueva');
Route::get('/clases/lista', [ClaseController::class, 'list'])->name('clases.list');
Route::post('/clases/store', [ClaseController::class, 'store'])->name('clases.store');
Route::put('/clases/{clase}', [ClaseController::class, 'update'])->name('clases.update');
Route::delete('/clases/{id}', [ClaseController::class, 'destroy'])->name('clases.destroy');

// Manda a llamar al metodo redirect en los controlador
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Mandan allamar al metodo callback para procesar la respuesta
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// Rutas de autenticación con Facebook
Route::get('auth/facebook/redirect', [FacebookAuthController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('auth/facebook/callback', [FacebookAuthController::class, 'callback'])->name('auth.facebook.callback');
