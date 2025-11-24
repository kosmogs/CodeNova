@extends('layouts.app')

@section('content')
<div class="container mt-5">

    <h1 class="mb-4">Panel de Administrador</h1>

    <div class="alert alert-primary">
        Bienvenido, <strong>{{ auth()->user()->nombre_usuario }}</strong>.
    </div>

    <div class="row">

        <!-- Tarjeta CRUD Usuarios -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Gestión de Usuarios</h5>
                    <p class="card-text">
                        Administrar supervisores y gestores del sistema.
                    </p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary w-100">
                        Ir al CRUD de Usuarios
                    </a>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Reportes -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <h5 class="card-title">Reportes</h5>
                    <p class="card-text">
                        Próximamente: estadísticas del sistema.
                    </p>
                    <button class="btn btn-secondary w-100" disabled>No disponible</button>
                </div>
