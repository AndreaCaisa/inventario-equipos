@extends('layouts.app')

@section('titulo', 'Nuevo Equipo')

@section('contenido')
    <h1 class="h3 mb-3">Registrar nuevo equipo - PRUEBA</h1>

    <form action="{{ route('equipos.store') }}" method="POST" class="bg-white p-4 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                   value="{{ old('nombre') }}" required maxlength="100">
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" name="tipo" id="tipo" class="form-control"
                   value="{{ old('tipo') }}" required maxlength="60" placeholder="Ej. Laptop, Proyector, Router">
        </div>

        <div class="mb-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" name="marca" id="marca" class="form-control"
                   value="{{ old('marca') }}" maxlength="60">
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-select" required>
                <option value="disponible" {{ old('estado') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="en_uso" {{ old('estado') === 'en_uso' ? 'selected' : '' }}>En uso</option>
                <option value="mantenimiento" {{ old('estado') === 'mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ubicacion" class="form-label">Ubicación</label>
            <input type="text" name="ubicacion" id="ubicacion" class="form-control"
                   value="{{ old('ubicacion') }}" maxlength="100" placeholder="Ej. Laboratorio 2">
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="{{ route('equipos.index') }}" class="btn btn-link">Cancelar</a>
    </form>
@endsection