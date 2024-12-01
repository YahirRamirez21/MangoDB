<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/crearCajaMangos', function () {
    return view('cajaCreateHectareaEA');
});
