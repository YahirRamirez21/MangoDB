<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ControladorEncargadoAlmacen;
use App\Http\Controllers\ControladorJefeCuadrilla;

Route::get('/', [ControladorLogin::class, 'vistaLogin']);

Route::get('login', [ControladorLogin::class, 'vistaLogin'])->name('login');

Route::post('login', [ControladorLogin::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/inicioAlmacen', function () {
        return view('inicioEA');
    });

    Route::get('/inicioHectarea', function () {
        return view('inicioJC');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

Route::get('/ingresoCajasAlmacen', function () {
    return view('ingresaCajaCreateEA');
});

Route::get('/informacionHectarea', function () {
    return view('infoHectareaJC');
});

Route::get('/crearCajaMangos/{hectarea_id}', [ControladorJefeCuadrilla::class, 'crearCajas'])->name('cajas.crear');

Route::get('/caja', [ControladorEncargadoAlmacen::class, 'mostrarCaja']);

Route::middleware(['auth'])->group(function () {
    Route::get('/inicioHectarea', [ControladorJefeCuadrilla::class, 'index'])->name('hectareas.index');
});

Route::get('/informacionHectarea/{id}', [ControladorJefeCuadrilla::class, 'informacionHectarea'])->name('hectareas.info');

Route::post('/informacionHectarea/{id}/autorizar', [ControladorJefeCuadrilla::class, 'cambiarEstadoCosecha'])->name('hectareas.autorizar');

Route::post('hectareas/registrarCaja', [ControladorJefeCuadrilla::class, 'registrarCaja'])->name('hectareas.registrarCaja');





