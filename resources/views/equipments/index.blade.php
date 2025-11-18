@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Equipos</h1>

    <a href="{{ route('equipments.create') }}" class="btn btn-primary mb-3">
        Nuevo Equipo
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Precio por día</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($equipments as $equipment)
            <tr>
                <td>{{ $equipment->id }}</td>

                <td>
                    @if($equipment->image)
                        <img src="{{ asset('storage/' . $equipment->image) }}" 
                             width="80" height="80" style="object-fit: cover;">
                    @else
                        <small>Sin imagen</small>
                    @endif
                </td>

                <td>{{ $equipment->name }}</td>
                <td>{{ $equipment->stock }}</td>
                <td>${{ number_format($equipment->price_per_day, 2) }}</td>

                <td>
                    <!-- BOTÓN RENTAR (PASO 5) -->
                    <a href="{{ route('rentals.create', ['equipment_id' => $equipment->id]) }}" 
                       class="btn btn-sm btn-success mb-1">
                        Rentar
                    </a>

                    <a href="{{ route('equipments.show', $equipment->id) }}" 
                       class="btn btn-sm btn-info mb-1">
                        Ver
                    </a>

                    <a href="{{ route('equipments.edit', $equipment->id) }}" 
                       class="btn btn-sm btn-warning mb-1">
                        Editar
                    </a>

                    <form action="{{ route('equipments.destroy', $equipment->id) }}" 
                          method="POST" 
                          class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar equipo?')">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>
@endsection