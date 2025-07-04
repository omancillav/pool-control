<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\HomeController;
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

// Manda a llamar al metodo redirect en los controlador
Route::get('auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
// Mandan allamar al metodo callback para procesar la respuesta
Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

// Rutas de autenticación con Facebook
Route::get('auth/facebook/redirect', [FacebookAuthController::class, 'redirect'])->name('auth.facebook.redirect');
Route::get('auth/facebook/callback', [FacebookAuthController::class, 'callback'])->name('auth.facebook.callback');