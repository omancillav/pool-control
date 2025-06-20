<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;

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