<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorLogin::class, 'vistaLogin']);

Route::get('login', [ControladorLogin::class, 'vistaLogin'])->name('login');


Route::middleware(['auth'])->get('/principal', function () {
    return view('principal'); 
});


Route::get('/cajaCreateHectareaEA', function () {
    return view('cajaCreateHectareaEA');
});

Route::get('/estadoHectareaEA', function () {
    return view('estadoHectareaEA');
});