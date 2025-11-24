@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="container mt-4">

    <h2>Bienvenido Cliente</h2>
    <p>Aquí podrás gestionar tus PQRS.</p>

    {{-- Botón crear pqr --}}
    <a href="{{ route('pqr.create') }}" class="btn btn-primary mt-3">
        Crear nueva PQR
    </a>

    {{-- Cerrar sesión --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button type="submit" class="btn btn-danger">
            Cerrar sesión
        </button>
    </form>

    <hr class="my-4">

    <h2 class="mb-4">Mis PQRs</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th></th>
                <th>Numero Radicado</th>
                <th>Asunto</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($pqrs as $pqr)
                <tr>
                    <td><a href="{{ route('pqr.historial', $pqr->id_pqrs) }}" class="btn btn-info btn-sm">Ver</a></td>
                    <td>{{ $pqr->numero_radicado }}</td>
                    <td>{{ $pqr->asunto }}</td>
                    <td>{{ $pqr->estado->nombre_estado ?? 'N/A' }}</td>
                    <td>{{ $pqr->fecha_creacion->format('d-m-Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No tienes PQRs registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $pqrs->links() }}
    </div>

</div>

@endsection

