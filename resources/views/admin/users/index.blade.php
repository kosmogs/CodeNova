@extends('layouts.app')

@section('content')
<div class="container">
  <h2>Supervisores y Gestores</h2>
  <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-2">Crear</a>

  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

  <table class="table">
    <thead><tr><th>Nombre</th><th>Apellidos</th><th>Telefono</th><th>Email</th><th>Rol</th><th>Acciones</th></tr></thead>
    <tbody>
      @foreach($usuarios as $u)
        <tr>
          <td>{{ $u->nombre_usuario }}</td>
          <td>{{ $u->apellidos_usuario }}</td>
          <td>{{ $u->telefono }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->rol->nombre_rol ?? '-' }}</td>
          <td>
            <a href="{{ route('admin.users.edit', $u->id_users) }}" class="btn btn-sm btn-warning">Editar</a>
            <form action="{{ route('admin.users.destroy', $u->id_users) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  {{ $usuarios->links() }}
</div>
@endsection
