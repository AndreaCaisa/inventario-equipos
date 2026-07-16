@extends('layouts.app')

@section('titulo', 'Listado de Equiposss')

@section('contenido')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3">Listado de inventario</h1>
        <a href="{{ route('equipos.create') }}" class="btn btn-primary">+ Nuevo equipo</a>
    </div>

    @if ($equipos->isEmpty())
        <p class="text-muted">Aún no hay equipos registrados.</p>
    @else
        <table class="table table-striped bg-white shadow-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Marca</th>
                    <th>Estado</th>
                    <th>Urgente</th>
                    <th>Ubicación</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($equipos as $equipo)
                    <tr>
                        <td>{{ $equipo->id }}</td>
                        <td>{{ $equipo->nombre }}</td>
                        <td>{{ $equipo->tipo }}</td>
                        <td>{{ $equipo->marca ?? '—' }}</td>
                        <td>
                            @if ($equipo->estado === 'disponible')
                                <span class="badge bg-success">Disponible</span>
                            @elseif ($equipo->estado === 'en_uso')
                                <span class="badge bg-warning text-dark">En uso</span>
                            @else
                                <span class="badge bg-danger">Mantenimiento</span>
                            @endif
                        </td>
                        <td>
    @if ($equipo->urgente)
        <span class="badge bg-danger">🔥 Urgente</span>
    @else
        <span class="text-muted">—</span>
    @endif
</td>
                        <td>{{ $equipo->ubicacion ?? '—' }}</td>
                        <td class="text-end">
                            <form action="{{ route('equipos.urgente', $equipo) }}" method="POST" class="d-inline">
    @csrf
    <button class="btn btn-sm {{ $equipo->urgente ? 'btn-danger' : 'btn-outline-danger' }}">
        {{ $equipo->urgente ? 'Quitar urgente' : 'Marcar urgente' }}
    </button>
</form>
                            <a href="{{ route('equipos.edit', $equipo) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form action="{{ route('equipos.destroy', $equipo) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('¿Eliminar este equipo?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection