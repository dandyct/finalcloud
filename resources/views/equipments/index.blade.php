@extends('layouts.app')

@section('title', 'Equipos')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Equipos</h2>
            <small class="text-muted">Listado de equipos disponibles</small>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('equipments.create') }}" class="btn btn-primary">Añadir equipo</a>
            @auth
            <a href="{{ route('rentals.create') }}" class="btn btn-outline-secondary">Nueva renta</a>
            @endauth
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width:60px;">#</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th class="text-end">Precio / día</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Estado</th>
                    <th class="text-end" style="width:200px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($equipments as $i => $e)
                <tr>
                    <td>{{ $equipments->firstItem() + $i }}</td>
                    <td>
                        <div class="fw-semibold">{{ $e->name }}</div>
                        @if($e->location)<small class="text-muted">{{ $e->location }}</small>@endif
                    </td>
                    <td>{{ $e->sku ?? '—' }}</td>
                    <td class="text-end">${{ number_format($e->price_per_day ?? 0, 2) }}</td>
                    <td class="text-center">{{ $e->stock }}</td>
                    <td class="text-center">
                        @if($e->status === 'available')
                            <span class="badge bg-success">Disponible</span>
                        @elseif($e->status === 'rented')
                            <span class="badge bg-warning text-dark">En renta</span>
                        @else
                            <span class="badge bg-secondary">Otro</span>
                        @endif
                    </td>
                    <td class="text-end table-actions">
                        <a href="{{ route('equipments.show', $e) }}" class="btn btn-sm btn-outline-info">Ver</a>
                        <a href="{{ route('equipments.edit', $e) }}" class="btn btn-sm btn-secondary">Editar</a>

                        <form action="{{ route('equipments.destroy', $e) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar equipo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4">No hay equipos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3 d-flex justify-content-end">
        {{ $equipments->links() }}
    </div>
</div>
@endsection