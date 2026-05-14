<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Muestra la vista del formulario de login
    public function index()
    {
        return view("modules/auth/login");
    }

    // Procesa las credenciales y despacha según el rol del usuario
    public function logear(Request $request)
    {
        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credenciales)) {
            $request->session()->regenerate();

            // Despacho por rol
            if (Auth::user()->rol === 'administrador') {
                return to_route('admin.home');
            }

            return to_route('home');
        }

        return to_route('login')->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    // Cierra la sesión del usuario
    public function logout()
    {
        Session::flush();
        Auth::logout();
        return to_route('login');
    }

    // Dashboard — Veterinario
    public function home()
    {
        return view('modules/dashboard/home');
    }

    // Dashboard — Administrador
    public function adminHome()
    {
        return view('modules/admin/home');
    }
}
