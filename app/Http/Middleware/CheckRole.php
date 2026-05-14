<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Verifica que el usuario autenticado tenga el rol requerido.
     * Si no coincide, redirige al dashboard que le corresponde.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (Auth::check() && Auth::user()->rol === $role) {
            return $next($request);
        }

        // Redirigir al dashboard apropiado según su rol real
        if (Auth::check()) {
            return Auth::user()->rol === 'administrador'
                ? redirect()->route('admin.home')
                : redirect()->route('home');
        }

        return redirect()->route('login');
    }
}
