@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="m-0">Equipos</h1>
        <a href="{{ route('equipments.create') }}" class="btn btn-primary">
            + Nuevo Equipo
        </a>
    </div>

    {{-- Filtro por estado --}}
    <form method="GET" class="mb-3">
        <div class="row g-2">
            <div class="col-md-4">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">-- Filtrar por estado --</option>
                    <option value="available"   {{ request('status')=='available' ? 'selected' : '' }}>Disponible</option>
                    <option value="rented"      {{ request('status')=='rented' ? 'selected' : '' }}>En renta</option>
                    <option value="maintenance" {{ request('status')=='maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                    <option value="inactive"    {{ request('status')=='inactive' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
        </div>
    </form>

    {{-- Tabla de equipos --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>SKU</th>
                        <th>Precio Día</th>
                        <th>Stock</th>
                        <th>Estado</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($equipments as $equipment)
                    <tr>
                        {{-- Imagen --}}
                        <td style="width: 110px;">
                            @if($equipment->image)
                                <img src="{{ asset('storage/' . $equipment->image) }}"
                                     style="width:80px; height:80px; object-fit:cover; border-radius:8px;">
                            @else
                                <span class="text-muted">Sin imagen</span>
                            @endif
                        </td>

                        {{-- Nombre --}}
                        <td>{{ $equipment->name }}</td>

                        {{-- SKU --}}
                        <td>{{ $equipment->sku ?: 'N/A' }}</td>

                        {{-- Precio --}}
                        <td>${{ number_format($equipment->price_per_day, 2) }}</td>

                        {{-- Stock --}}
                        <td>{{ $equipment->stock }}</td>

                        {{-- Estado --}}
                        <td>
                            @php
                                $colors = [
                                    'available'   => 'success',
                                    'rented'      => 'warning',
                                    'maintenance' => 'info',
                                    'inactive'    => 'secondary'
                                ];
                            @endphp
                            <span class="badge bg-{{ $colors[$equipment->status] ?? 'secondary' }}">
                                {{ ucfirst($equipment->status) }}
                            </span>
                        </td>

                        {{-- Acciones --}}
                        <td class="text-center">

                            <div class="d-flex justify-content-center gap-2">

                                {{-- Ver --}}
                                <a href="{{ route('equipments.show', $equipment->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    Ver
                                </a>

                                {{-- Editar --}}
                                <a href="{{ route('equipments.edit', $equipment->id) }}"
                                   class="btn btn-sm btn-outline-warning">
                                    Editar
                                </a>

                                {{-- Rentas asociadas --}}
                                <a href="{{ route('rentals.index', ['equipment_id' => $equipment->id]) }}"
                                   class="btn btn-sm btn-outline-success">
                                    Rentas
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('equipments.destroy', $equipment->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este equipo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        Borrar
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>
                    @empty

                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No hay equipos registrados.
                        </td>
                    </tr>

                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <div class="mt-3">
        {{ $equipments->links() }}
    </div>

</div>
@endsection
