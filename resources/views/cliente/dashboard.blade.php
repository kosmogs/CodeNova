<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    @extends('layouts.navigation')
    <div class="container py-5 text-center">
        <h1 class="mb-4">Bienvenido, {{ Auth::user()->nombre_usuario }}</h1>

        <p class="text-muted">Has iniciado sesión como <strong>Cliente</strong>.</p>

        {{-- Botón para cerrar sesión --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">
                Cerrar sesión
            </button>
        </form>
    </div>

</body>
</html>