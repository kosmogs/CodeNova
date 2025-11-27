<?php

namespace App\Http\Controllers;
use App\Models\Pqr;
use App\Http\Controllers\PqrController;
use App\Models\Estado;
use App\Models\Historial;

use Illuminate\Http\Request;

class GestorController extends Controller
{
    public function index()
    {
        $gestorId = auth()->id();

        $pqrs = Pqr::with('estado', 'usuario')
                ->where('id_gestor', $gestorId)
                ->get();

        $estados = Estado::all();
        return view('gestor.pqrs.index', compact('pqrs'));
    }

    public function historial($id)
    {
        $historial = Historial::where('id_pqrs', $id)
                              ->orderBy('fecha_registro', 'desc')
                              ->get();

        return response()->json($historial);
    }

    public function cambiarEstado(Request $request, $id)
    {
        // Validar estado
        $request->validate([
            'id_estado' => 'required|exists:t_estado_pqrs,id_estado'
        ]);
    
        // Buscar la PQR
        $pqr = Pqr::findOrFail($id);
    
        // Actualizar
        $pqr->id_estado = $request->id_estado;
        $pqr->save();
    
        // Registrar historial
        Historial::create([
            'id_users' => auth()->user()->id_users,
            'id_pqrs' => $pqr->id_pqrs,
            'accion' => 'Cambio de estado',
            'descripcion' => 'Nuevo estado: ' . $pqr->estado->nombre_estado,
            'fecha_registro' => now(),
        ]);
    
        return back()->with('success', 'Estado actualizado correctamente.');
    }


}
