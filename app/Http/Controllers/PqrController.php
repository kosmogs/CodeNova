<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Pqr;
use App\Models\TipoPqr;
use App\Models\Estado;
use App\Models\User;
use App\Models\Archivo;
use App\Models\Historial;
use Illuminate\Support\Facades\Auth;

class PqrController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $rol = $user->rol->nombre_rol; // Cliente, Gestor, Supervisor, Admin

        switch ($rol) {

            case 'Cliente':
                // El cliente solo ve sus propias PQR
                $pqrs = Pqr::where('id_users', $user->id)->get();
                return view('cliente.dashboard', compact('pqrs'));

            case 'Gestor':
                // El gestor ve las PQR que le asignaron
                $pqrs = Pqr::where('id_gestor', $user->id)->get();
                return view('gestor.dashboard', compact('pqrs'));

            case 'Supervisor':
                // Supervisor ve todas las PQR
                $pqrs = Pqr::all();
                return view('supervisor.dashboard', compact('pqrs'));

            case 'Admin':
                // Admin también ve todas las PQR pero puede administrarlas
                $pqrs = Pqr::all();
                return view('admin.dashboard', compact('pqrs'));

            default:
                abort(403, 'Rol no autorizado.');
        }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cargar tipos y estados para el formulario
        $tipoPqr = TipoPqr::all();//$estadoInicial = Estado::where('nombre', 'Enviado')->first();

        return view('pqr.create', compact('tipoPqr'));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'asunto' => 'required|string|max:50',
            'descripcion' => 'required',
            'id_tipo'   => 'required|exists:t_tipo_pqrs,id_tipo'
        ]);

        $user = auth()->user();



        // Generar número de radicado único
        $radicado = date('YmdHis') . '-' . rand(10, 99);
        
        // Asignación automática de un gestor
        // IMPORTANTE: Aquí debes poner la lógica de tu sistema
        // Temporal: gestor con ID 5
        $gestorAsignado = 5;
        $pqr = Pqr::create([
            'id_users' => $user->id_users,
            'numero_radicado' => $radicado,
            'descripcion'    => $request->descripcion,
            'asunto' => $request ->asunto,
            'fecha_creacion'  => Carbon::now(),
            'id_gestor'       => $gestorAsignado,
            'id_tipo'      => $request->id_tipo,
            'id_estado'       => 1,   
            'id_archivo'      => null // Aún no se carga archivo
        ]);
        // REGISTRAR HISTORIAL
        Historial::create([
            'id_users'       => auth()->id(),
            'id_pqrs'        => $pqr->id_pqrs,
            'fecha_registro' => Carbon::now(),
            'accion'         => 'PQR creada',
            'descripcion'    => 'El usuario creó la PQR.',
        ]);

        return redirect()->route('cliente.dashboard')
            ->with('success', 'PQR creada exitosamente. Radicado: ' . $radicado);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pqr = Pqr::findOrFail($id);
        return view('pqr.show', compact('pqr'));
    }


    public function editarGestor($id)
    {
        $pqr = Pqr::findOrFail($id);
        return view('pqr.gestor.edit', compact('pqr'));
    }

    /**
     * Guardar respuesta/validación del gestor
     */
    public function actualizarGestor(Request $request, $id)
    {
        $request->validate([
            'respuesta' => 'required',
            'id_estado' => 'required'
        ]);

        $pqr = Pqr::findOrFail($id);

        $pqr->update([
            'respuesta' => $request->respuesta,
            'id_estado' => $request->id_estado
        ]);

        return redirect()->route('gestor.dashboard')
            ->with('success', 'PQR actualizada correctamente.');
    }
    //ver historial
    public function verHistorial($id)
    {
        $pqr = Pqr::with([
            'usuario',  // cliente
            'historial.usuario' => function ($q) {   // usuario que hizo la acción
                $q->select('id_users', 'nombre_usuario');
            }
        ])
        ->where('id_pqrs', $id)
        ->firstOrFail();

        // Ordenamos el historial de más nuevo a más viejo
        $pqr->historial = $pqr->historial->sortByDesc('fecha_registro');

        // Última acción
        $ultimaAccion = $pqr->historial->first();

        return view('pqr.historial', compact('pqr', 'ultimaAccion'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pqr = Pqr::findOrFail($id);
        $pqr->delete();

        return redirect()->back()->with('success', 'PQR eliminada correctamente.');
    }
}
