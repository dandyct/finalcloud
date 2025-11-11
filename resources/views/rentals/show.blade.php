@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Renta #{{ $rental->id }}</h1>

    <p><strong>Equipo:</strong> {{ $rental->equipment->name ?? '—' }}</p>
    <p><strong>Cliente:</strong> {{ $rental->customer_name }}</p>
    <p><strong>Contacto:</strong> {{ $rental->customer_contact }}</p>
    <p><strong>Inicio:</strong> {{ optional($rental->start_date)->format('Y-m-d') }}</p>
    <p><strong>Fin:</strong> {{ optional($rental->end_date)->format('Y-m-d') }}</p>
    <p><strong>Precio por día:</strong> {{ number_format($rental->price_per_day ?? 0, 2) }}</p>
    <p><strong>Precio total:</strong> {{ number_format($rental->price_total ?? 0, 2) }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($rental->status) }}</p>
    <p><strong>Notas:</strong><br>{!! nl2br(e($rental->notes)) !!}</p>

    <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-secondary">Editar</a>
    <a href="{{ route('rentals.index') }}" class="btn btn-link">Volver</a>
</div>
@endsection