@extends('layouts.app')

@section('content')
<div class="container">

    <h1 class="mb-4">Detalle de la Renta #{{ $rental->id }}</h1>

    <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">← Volver</a>

    <div class="card shadow-sm p-4">
        <div class="card-body">

            {{-- EQUIPO --}}
            <h4 class="fw-bold">Equipo</h4>
            <p class="mb-3">
                {{ optional($rental->equipment)->name ?? 'Equipo eliminado' }}
            </p>

            {{-- CLIENTE --}}
            <h4 class="fw-bold">Cliente</h4>
            <p class="mb-3">
                {{ $rental->customer_name }} <br>
                <small class="text-muted">
                    Contacto: {{ $rental->customer_contact ?: 'N/A' }}
                </small>
            </p>

            {{-- FECHAS --}}
            <h4 class="fw-bold">Fechas</h4>
            <p class="mb-3">
                Inicio: <strong>{{ $rental->start_date }}</strong> <br>
                Fin: <strong>{{ $rental->end_date ?? 'No definida' }}</strong>
            </p>

            {{-- TOTAL --}}
            <h4 class="fw-bold">Total</h4>
            <p class="mb-3">
                <strong>${{ number_format($rental->total_price, 2) }}</strong>
            </p>

            {{-- ESTADO --}}
            <h4 class="fw-bold">Estado</h4>
            <p class="mb-3">
                @if($rental->is_completed)
                    <span class="badge bg-success">Completada</span>
                @else
                    <span class="badge bg-warning text-dark">Activa</span>
                @endif
            </p>

            {{-- NOTAS --}}
            <h4 class="fw-bold">Notas</h4>
            <p class="mb-1">
                {{ $rental->notes ?: 'Sin notas' }}
            </p>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-primary">Editar</a>

                <form 
                    action="{{ route('rentals.destroy', $rental) }}" 
                    method="POST"
                    onsubmit="return confirm('¿Eliminar esta renta?');"
                >
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Eliminar</button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
