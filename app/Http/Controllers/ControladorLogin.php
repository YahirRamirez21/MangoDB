<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ControladorLogin extends Controller
{
    public function vistaLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt([
            'nombre' => $request->nombre,
            'password' => $request->password
        ], $request->has('remember'))) {
            return redirect()->intended('/principal');
        }

        return back()->withErrors(['nombre' => 'Las credenciales no coinciden.']);
    }
}
