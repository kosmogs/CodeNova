<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Rol;
use Hash;
use Illuminate\Validation\Rule;


class UsersController extends Controller {
    public function index(){
        $usuarios = User::whereIn('id_rol',[1,2,3])->with('rol')->paginate(10);
        return view('admin.users.index', compact('usuarios'));
    }

    public function create(){
        $roles = Rol::whereIn('id_rol',[1,2,3])->get();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request){
        $request->validate([
            'nombre_usuario'=>'required|string|max:50',
            'apellidos_usuario'=>'required|string|max:50',
            'tipo_documento'=>'required', Rule::in(['CC', 'CE', 'NIT', 'PAS']),
            'numero_documento'=>'required|string|max:50',
            'telefono'=>'required|string|max:50',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:6|',
            'id_rol'=>'required|in:1,2,3',
        ]);
        $documentos = [
        'CC'  => 'Cedula de ciudadanía',
        'CE'  => 'Cedula de extranjería',
        'NIT' => 'NIT',
        'PAS' => 'Pasaporte',
        ];
       $tipoDocumento = $documentos[$request->tipo_documento] ?? $request->tipo_documento;

        User::create([
            'nombre_usuario'=>$request->nombre_usuario,
            'apellidos_usuario'=>$request->apellidos_usuario,
            'tipo_documento'=>$tipoDocumento,
            'numero_documento'=>$request->numero_documento,
            'telefono'=>$request->telefono,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'id_rol'=>$request->id_rol
        ]);

        return redirect()->route('admin.users.index')->with('success','Usuario creado');
    }

    public function edit(User $user) {
        $roles = Rol::whereIn('id_rol',[1,2,3])->get();
        return view('admin.users.edit', compact('user','roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:50',
            'apellidos_usuario' => 'required|string|max:50',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $user->id_users . ',id_users',
            'id_rol' => 'required|in:1,2,3',
        ]);

        $data = $request->only(['nombre_usuario','apellidos_usuario','numero_documento','telefono','email','id_rol']);
        if ($request->filled('password')) {
            $request->validate(['password'=>'min:6|confirmed']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success','Usuario actualizado');
    }

    public function destroy($id)
    {
        $usuario = User::where('id_users', $id)->firstOrFail();
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'Usuario eliminado correctamente.');
    }

}

