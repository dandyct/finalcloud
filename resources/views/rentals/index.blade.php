@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Rentas</h1>

    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Nueva Renta</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
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
                    <td>{{ $rental->equipment->name }}</td>
                    <td>{{ $rental->customer_name }}</td>
                    <td>{{ $rental->start_date }}</td>
                    <td>{{ $rental->end_date ?? '—' }}</td>
                    <td>${{ number_format($rental->total_price, 2) }}</td>
                    <td>
                        <span class="badge bg-{{ $rental->is_completed ? 'success' : 'warning' }}">
                            {{ $rental->is_completed ? 'Completada' : 'Activa' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('rentals.show', $rental) }}" class="btn btn-sm btn-info">Ver</a>
                        <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('rentals.destroy', $rental) }}"
                              method="POST"
                              class="d-inline"
                              onsubmit="return confirm('¿Eliminar esta renta?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Eliminar</button>
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

    {{ $rentals->links() }}
</div>
@endsection
