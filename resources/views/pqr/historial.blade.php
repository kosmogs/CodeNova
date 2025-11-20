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
    <h4>Historial Completo</h4>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Usuario</th>
                <th>Acción</th>
                <th>Descripción</th>
            </tr>
        </thead>

        <tbody>
        @forelse ($pqr->historial as $item)
            <tr>
                <td>{{ \Carbon\Carbon::parse($item->fecha_registro)->format('d-m-Y H:i') }}</td>
                <td>{{ $item->usuario->nombres }} {{ $item->usuario->apellidos }}</td>
                <td>{{ $item->accion }}</td>
                <td>{{ $item->descripcion }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No hay historial registrado.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('cliente.dashboard') }}" class="btn btn-secondary">Volver</a>

</div>

@endsection
