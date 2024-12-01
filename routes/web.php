<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [ControladorLogin::class, 'vistaLogin']);

Route::get('login', [ControladorLogin::class, 'vistaLogin'])->name('login');

Route::post('login', [ControladorLogin::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::get('/jefe-cuadrilla', function () {
        return view('inicio-JC');
    });

    Route::get('/encargado-almacen', function () {
        return view('inicio-EA');
    });

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
