@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rentas</h1>

    <a href="{{ route('rentals.create') }}" class="btn btn-primary mb-3">Nueva renta</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Equipo</th>
                <th>Cliente</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Precio total</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rentals as $r)
            <tr>
                <td>{{ $r->equipment->name ?? '—' }}</td>
                <td>{{ $r->customer_name }}</td>
                <td>{{ optional($r->start_date)->format('Y-m-d') }}</td>
                <td>{{ optional($r->end_date)->format('Y-m-d') }}</td>
                <td>{{ number_format($r->price_total ?? 0, 2) }}</td>
                <td>{{ ucfirst($r->status) }}</td>
                <td>
                    <a href="{{ route('rentals.show', $r) }}" class="btn btn-sm btn-info">Ver</a>
                    <a href="{{ route('rentals.edit', $r) }}" class="btn btn-sm btn-secondary">Editar</a>

                    <form action="{{ route('rentals.destroy', $r) }}" method="POST" style="display:inline-block" onsubmit="return confirm('Eliminar renta?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">No hay rentas.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $rentals->links() }}
</div>
@endsection