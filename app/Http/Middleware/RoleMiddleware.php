<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // 1. Primero obtenemos el usuario autenticado:
        $user = Auth::user();

        // 2. Verificamos si existe (por si accede sin login)
        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión.');
        }

        // 3. Validamos si el rol del usuario está dentro de los roles permitidos
        if (!in_array($user->id_rol, $roles)) {
            return abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}
