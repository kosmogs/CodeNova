<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Pqr;
use App\Models\Historial;

class ClienteController extends Controller
{   
    
    public function index()
    {
    $clienteId = auth()->user()->id_users; // ID del usuario logueado

    $pqrs = Pqr::where('id_users', $clienteId)
                ->orderBy('fecha_creacion', 'desc')
                ->paginate(10); // PAGINACIÓN DE 10
        
    return view('cliente.dashboard', compact('pqrs'));

    
    }
}
