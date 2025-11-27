@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <h2 class="mb-4">Historial de la PQR</h2>

    {{-- Información general de la PQR --}}
    <div class="card mb-4">
        <div class="card-body">

            <h4>Información de la PQR</h4>
            <hr>

            <p><strong>Número de Radicado:</strong> {{ $pqr->numero_radicado }}</p>

            <p><strong>Fecha de Creación:</strong>
                {{ \Carbon\Carbon::parse($pqr->fecha_creacion)->format('d-m-Y H:i') }}
            </p>

            <p><strong>Cliente:</strong>
                {{ $pqr->usuario->nombre_usuario }}
            </p>

            <p><strong>Asunto:</strong> {{ $pqr->asunto }}</p>
            <p><strong>Descripción:</strong> {{ $pqr->descripcion }}</p>

            <p><strong>Última acción registrada:</strong>
                @if ($ultimaAccion)
                    {{ $ultimaAccion->accion }}
                    —
                    {{ \Carbon\Carbon::parse($ultimaAccion->fecha_registro)->format('d-m-Y H:i') }}
                @else
                    No hay acciones registradas aún.
                @endif
            </p>

        </div>
    </div>
    {{-- Tabla del historial --}}
    <div class="card mt-4">
        <div class="card-body">
            <h4>Historial de Acciones</h4>
            <hr>
        
            @if ($pqr->historial->isEmpty())
                <p>No hay historial registrado.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Acción</th>
                            <th>Usuario</th>
                            <th>Descripción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pqr->historial as $h)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($h->fecha_registro)->format('d-m-Y H:i') }}</td>
                                <td>{{ $h->accion }}</td>
                                <td>{{ $h->usuario->nombre_usuario ?? '---' }}</td>
                                <td>{{ $h->descripcion }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    
    <a href="{{ route('gestor.pqrs.index') }}" class="btn btn-secondary">Volver</a>

</div>

@endsection