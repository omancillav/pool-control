<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MembresiaController;
use App\Http\Controllers\HomeController;

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