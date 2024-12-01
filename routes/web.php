<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorLogin::class, 'vistaLogin']);

Route::get('login', [ControladorLogin::class, 'vistaLogin'])->name('login');

Route::get('/inicioAlmacen', function () {
    return view('inicioEA');
});

Route::get('/ingresoCajasAlmacen', function () {
    return view('ingresaCajaCreateEA');
});

Route::get('/inicioHectarea', function () {
    return view('inicioJC');
});

Route::get('/informacionHectarea', function () {
    return view('infoHectareaJC');
});

Route::get('/crearCajaMangos', function () {
    return view('cajaCreateHectareaEA');
});

Route::middleware(['auth'])->get('/principal', function () {
    return view('principal');
});

