@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2>Creacion de PQR</h2>

    <form action="{{ route('pqr.store') }}" method="POST">
        @csrf
        
        {{-- Tipo de PQR --}}
        <div class="mb-3">
            <label for="id_tipo" class="form-label">Tipo de PQR</label>
            <select name="id_tipo" id="id_tipo" class="form-select" required>
                <option value="">Seleccione un tipo de PQR</option>

                @foreach ($tipoPqr as $tipo)
                    <option value="{{ $tipo->id_tipo }}">
                        {{ $tipo->nombre_tipo }}
                    </option>
                @endforeach
            </select>
        </div>
        {{--Asunto--}}
        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto</label>
            <input type="text" name="asunto" id="asunto" class="form-control" required>
        </div>
        {{-- Descripción --}}
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="4" required></textarea>
        </div>


        <button type="submit" class="btn btn-success">Enviar PQR</button>
    </form>

</div>
@endsection