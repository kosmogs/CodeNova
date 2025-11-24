@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Editar Usuario</h2>

    <!-- Mostrar errores -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
    @csrf
    @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre_usuario" class="form-control" value="{{ $user->nombre_usuario }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellidos:</label>
            <input type="text" name="apellidos_usuario" class="form-control" value="{{ $user->apellidos_usuario }}" required>
        </div>

        <!-- Tipo documento -->
        <div class="mb-3">
        <label for="tipo_documento" class="form-label">Tipo de documento</label>
        <select name="tipo_documento" id="tipo_documento" class="form-select" required>
            <option value="CC">Cédula de ciudadanía</option>
            <option value="CE">Cédula de extranjería</option>
            <option value="NIT">NIT</option>
            <option value="PAS">Pasaporte</option>
        </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Numero de documento:</label>
            <input type="text" name="numero_documento" class="form-control" value="{{ $user->numero_documento }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Telefono:</label>
            <input type="text" name="telefono" class="form-control" value="{{ $user->telefono }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Correo:</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cambiar Contraseña (opcional):</label>
            <input type="password" name="password" class="form-control">
            <small class="text-muted">Déjelo vacío si no desea cambiarla.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Rol:</label>
            <select name="id_rol" class="form-select" required>
                @foreach($roles as $rol)
                    <option value="{{ $rol->id_rol }}" {{ $user->id_rol == $rol->id_rol ? 'selected' : '' }}>
                        {{ $rol->nombre_rol }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
