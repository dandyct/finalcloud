@extends('layouts.app')

@section('title', 'Equipos')

@section('content')
<div class="container-fluid">

    {{-- ENCABEZADO --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 mb-0">Gestión de Equipos</h2>
            <small class="text-muted">Administra todos los equipos disponibles para renta</small>
        </div>

        <a href="{{ route('equipments.create') }}" class="btn btn-primary">
            + Añadir equipo
        </a>
    </div>

    {{-- ALERTAS --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- BUSCADOR Y FILTROS --}}
    <form method="GET" action="{{ route('equipments.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <input 
                    type="text" 
                    name="search" 
                    class="form-control" 
                    placeholder="Buscar por nombre o SKU..."
                    value="{{ request('search') }}"
                >
            </div>

            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">— Estado —</option>
                    <option value="available"   {{ request('status')=='available' ? 'selected' : '' }}>Disponible</option>
                    <option value="rented"      {{ request('status')=='rented' ? 'selected' : '' }}>En renta</option>
                    <option value="maintenance" {{ request('status')=='maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="inactive"    {{ request('status')=='inactive' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="col-md-2">
                <button class="btn btn-secondary w-100">Filtrar</button>
            </div>

            <div class="col-md-2">
                <a href="{{ route('equipments.index') }}" class="btn btn-light w-100">Limpiar</a>
            </div>
        </div>
    </form>

    {{-- TABLA --}}
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover mb-0 align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>SKU</th>
                    <th class="text-end">Precio / día</th>
                    <th class="text-center">Stock</th>
                    <th class="text-center">Estado</th>
                    <th class="text-end">Acciones</th>
                </tr>
            </thead>

            <tbody>

                @forelse($equipments as $i => $e)
                <tr>
                    {{-- ÍNDICE --}}
                    <td>{{ $equipments->firstItem() + $i }}</td>

                    {{-- IMAGEN --}}
                    <td>
                        @if($e->image)
                            <img 
                                src="{{ asset('storage/' . $e->image) }}" 
                                alt="img" 
                                class="rounded"
                                style="width:55px; height:55px; object-fit:cover;"
                            >
                        @else
                            <span class="text-muted">Sin imagen</span>
                        @endif
                    </td>

                    {{-- DATOS --}}
                    <td class="fw-semibold">{{ $e->name }}</td>
                    <td>{{ $e->sku ?? '—' }}</td>
                    <td class="text-end">${{ number_format($e->price_per_day, 2) }}</td>
                    <td class="text-center">{{ $e->stock }}</td>

                    {{-- ESTADOS CON COLORES --}}
                    <td class="text-center">
                        @switch($e->status)
                            @case('available')
                                <span class="badge bg-success">Disponible</span>
                                @break
                            @case('rented')
                                <span class="badge bg-warning text-dark">En renta</span>
                                @break
                            @case('maintenance')
                                <span class="badge bg-info text-dark">Mantenimiento</span>
                                @break
                            @default
                                <span class="badge bg-secondary">Inactivo</span>
                        @endswitch
                    </td>

                    {{-- ACCIONES --}}
                    <td class="text-end">
                        <a href="{{ route('equipments.show', $e) }}" class="btn btn-sm btn-outline-info">
                            Ver
                        </a>

                        <a href="{{ route('equipments.edit', $e) }}" class="btn btn-sm btn-secondary">
                            Editar
                        </a>

                        <form 
                            action="{{ route('equipments.destroy', $e) }}" 
                            method="POST" 
                            class="d-inline"
                            onsubmit="return confirm('¿Eliminar equipo?')"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8" class="text-center py-4">
                        No hay equipos registrados.
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-3 d-flex justify-content-end">
        {{ $equipments->links() }}
    </div>

</div>
@endsection