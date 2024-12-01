<?php

use App\Http\Controllers\ControladorLogin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [ControladorLogin::class, 'vistaLogin']);

Route::get('login', [ControladorLogin::class, 'vistaLogin'])->name('login');



    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});
