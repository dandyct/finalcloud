@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalles de Renta #{{ $rental->id }}</h1>

    <a href="{{ route('rentals.index') }}" class="btn btn-secondary mb-3">← Volver</a>

    <div class="card">
        <div class="card-body">

            <h4>Equipo</h4>
            <p>{{ $rental->equipment->name }}</p>

            <h4>Cliente</h4>
            <p>{{ $rental->customer_name }}<br>
               <small>Contacto: {{ $rental->customer_contact ?? 'N/A' }}</small>
            </p>

            <h4>Fecha</h4>
            <p>
                Inicio: {{ $rental->start_date }} <br>
                Fin: {{ $rental->end_date ?? 'No definida' }}
            </p>

            <h4>Total</h4>
            <p><strong>${{ number_format($rental->total_price, 2) }}</strong></p>

            <h4>Estado</h4>
            <p>
                @if($rental->is_completed)
                    <span class="badge bg-success">Completada</span>
                @else
                    <span class="badge bg-warning">Activa</span>
                @endif
            </p>

            <h4>Notas</h4>
            <p>{{ $rental->notes ?? 'Sin notas' }}</p>

        </div>
    </div>
</div>
@endsection
