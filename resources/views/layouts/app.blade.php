<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    {{-- NAVBAR --}}
    @include('layouts.navigation')

    {{-- CONTENIDO DE CADA VISTA --}}
    <main class="container py-4">
        @yield('content')
    </main>

</body>
</html>