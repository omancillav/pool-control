<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/membresias', [App\Http\Controllers\MembresiaController::class, 'index'])->name('membresias.nueva');
Route::get('/membresias/lista', [App\Http\Controllers\MembresiaController::class, 'list'])->name('membresias.lista');
