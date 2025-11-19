@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Rentas</h1>

    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">
        Nueva Renta
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Equipo</th>
                <th>Cliente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>

                {{-- 🔥 Maneja automáticamente rentas sin equipo para evitar que truene --}}
                <td>
                    @if($rental->equipment)
                        {{ $rental->equipment->name }}
                    @else
                        <span class="text-danger">Sin equipo</span>
                    @endif
                </td>

                <td>{{ $rental->customer_name ?? 'N/A' }}</td>
                <td>{{ $rental->start_date }}</td>
                <td>{{ $rental->end_date ?? '—' }}</td>

                <td>${{ number_format($rental->price_total, 2) }}</td>

                <td>
                    <span class="badge 
                        @if($rental->status === 'completed') bg-success
                        @elseif($rental->status === 'active') bg-warning
                        @else bg-secondary
                        @endif
                    ">
                        {{ ucfirst($rental->status) }}
                    </span>
                </td>

                <td>
                    <a href="{{ route('rentals.show', $rental) }}" 
                       class="btn btn-sm btn-info mb-1">
                        Ver
                    </a>

                    <a href="{{ route('rentals.edit', $rental) }}" 
                       class="btn btn-sm btn-warning mb-1">
                        Editar
                    </a>

                    <form 
                        action="{{ route('rentals.destroy', $rental) }}" 
                        method="POST" 
                        class="d-inline"
                        onsubmit="return confirm('¿Eliminar esta renta?');">
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
                <td colspan="8" class="text-center">No hay rentas registradas</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mt-3">
        {{ $rentals->links() }}
    </div>

</div>
@endsection