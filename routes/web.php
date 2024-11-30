<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/cajaCreateHectareaEA', function () {
    return view('cajaCreateHectareaEA');
});
