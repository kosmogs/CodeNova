@extends('layouts.app')

@section('content')
{{ "VISTA CARGADA" }}
<div class="container mt-4">

    <h2 class="mb-4">PQRs Asignadas</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Radicado</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($pqrs as $p)
            <tr>
                <td>{{ $p->numero_radicado }}</td>
                <td>{{ $p->usuario->nombre_usuario }}</td>
                <td>{{ $p->fecha_creacion }}</td>
                <td>
                    <span class="badge bg-primary">{{ $p->estado->nombre_estado }}</span>
                </td>
                <td>
                    <!-- Botón historial -->
                    <a href="{{ route('gestor.pqrs.historial', $p->id_pqrs) }}"class="btn btn-info btn-sm">Ver historial</a>

                    <!-- Botón desplegable para estados -->
                    <div class="dropdown">
                        <button type="button" onclick="toggleMenu(this)" class="btn btn-info btn-sm">
                            Cambiar estado ⌄
                        </button>
                    
                        <div class="dropdown-menu">
                            {{-- En plazo --}}
                            <form action="{{ route('gestor.pqrs.estado', $p->id_pqrs) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_estado" value="1">
                                <button type="submit">En plazo</button>
                            </form>
                        
                            {{-- Próximo a vencer --}}
                            <form action="{{ route('gestor.pqrs.estado', $p->id_pqrs) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_estado" value="2">
                                <button type="submit">Próximo a vencer</button>
                            </form>
                        
                            {{-- Vencida --}}
                            <form action="{{ route('gestor.pqrs.estado', $p->id_pqrs) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_estado" value="3">
                                <button type="submit">Vencida</button>
                            </form>
                        
                            {{-- Rechazada --}}
                            <form action="{{ route('gestor.pqrs.estado', $p->id_pqrs) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_estado" value="4">
                                <button type="submit">Rechazada</button>
                            </form>
                        
                            {{-- Finalizada --}}
                            <form action="{{ route('gestor.pqrs.estado', $p->id_pqrs) }}" method="POST">
                                @csrf
                                <input type="hidden" name="id_estado" value="5">
                                <button type="submit">Finalizada</button>
                            </form>
                        </div>
                    </div>

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>


    <!-- Modal flotante -->
    <div class="modal fade" id="modalHistorial" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de la PQR</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Acción</th>
                                <th>Descripción</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-historial">
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

</div>

<script>
function verHistorial(id) {
    fetch(`/gestor/pqrs/${id}/historial`)
        .then(res => res.json())
        .then(data => {
            let filas = "";
            data.forEach(h => {
                filas += `
                    <tr>
                        <td>${h.fecha_registro}</td>
                        <td>${h.accion}</td>
                        <td>${h.descripcion}</td>
                    </tr>
                `;
            });

            document.getElementById("tabla-historial").innerHTML = filas;
            let modal = new bootstrap.Modal(document.getElementById('modalHistorial'));
            modal.show();
        });
}
</script>

<script>
function toggleMenu(button) {
    const menu = button.nextElementSibling;

    // cerrar otros dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(m => {
        if (m !== menu) m.classList.remove('show');
    });

    // alternar el actual
    menu.classList.toggle('show');
}

// cerrar si se hace clic fuera
document.addEventListener('click', function(event) {
    const isDropdown = event.target.closest('.dropdown');
    if (!isDropdown) {
        document.querySelectorAll('.dropdown-menu').forEach(m => m.classList.remove('show'));
    }
});
</script>


@endsection
