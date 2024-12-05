<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ControladorAPI;

Route::post('usuarios', [ControladorAPI::class, 'log']); 

Route::post('vender', [ControladorAPI::class, 'retirar']);