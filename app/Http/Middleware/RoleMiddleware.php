<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        // Verifica si el usuario tiene rol
        $userRole = auth()->user()->rol->nombre_rol ?? null;

        if ($userRole !== $role) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
