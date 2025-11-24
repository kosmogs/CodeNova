<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */

    //Redireccion login segun rol
    


    public function store(Request $request)
    {
        // Validación de login
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Intento de login
        if (!Auth::attempt($credentials)) {
            return back()
                ->withErrors(['email' => 'Credenciales incorrectas'])
                ->onlyInput('email');
        }

        // Regenera la sesión por seguridad
        $request->session()->regenerate();

        // Redirección por rol
        switch (auth()->user()->id_rol) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('supervisor.dashboard');
            case 3:
                return redirect()->route('gestor.dashboard');
            case 4:
                return redirect()->route('cliente.dashboard');
            default:
                return redirect()->route('home');
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
