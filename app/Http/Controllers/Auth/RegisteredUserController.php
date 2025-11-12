<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    //Registro para clientes
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre_usuario' => ['required', 'string', 'max:255'],
            'apellidos_usuario' =>['required', 'string', 'max:50'],
            'tipo_documento' => ['required', Rule::in(['CC', 'CE', 'NIT', 'PAS'])],
            'numero_documento' =>['required', 'string', 'max:20'],
            'telefono'=>['required', 'string', 'max:20'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $documentos = [
        'CC'  => 'Cedula de ciudadanía',
        'CE'  => 'Cedula de extranjería',
        'NIT' => 'NIT',
        'PAS' => 'Pasaporte',
        ];
       $tipoDocumento = $documentos[$request->tipo_documento] ?? $request->tipo_documento;


        $user = User::create([
            'nombre_usuario' => $request->nombre_usuario,
            'apellidos_usuario' => $request->apellidos_usuario,
            'tipo_documento' => $request->tipo_documento,
            'numero_documento' => $request->numero_documento,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'id_rol' => 4,
        ]);

        event(new Registered($user));

        Auth::login($user);

         // Redirección según rol
        switch ($user->id_rol) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('gestor.dashboard');
            case 3:
                return redirect()->route('supervisor.dashboard');
            default:
                return redirect()->route('cliente.dashboard'); // Cliente
        }

        return redirect(route('dashboard', absolute: false));
    }
}
