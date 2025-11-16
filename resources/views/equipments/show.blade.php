@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $equipment->name }}</h1>

    {{-- Imagen --}}
    @if ($equipment->image)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $equipment->image) }}" 
                 alt="Imagen de {{ $equipment->name }}" 
                 class="img-fluid rounded" 
                 style="max-width: 250px;">
        </div>
    @endif

    <p><strong>SKU:</strong> {{ $equipment->sku }}</p>
    <p><strong>Precio por día:</strong> ${{ number_format($equipment->price_per_day, 2) }}</p>
    <p><strong>Stock:</strong> {{ $equipment->stock }}</p>
    <p><strong>Estado:</strong> {{ ucfirst($equipment->status) }}</p>
    <p><strong>Descripción:</strong> {!! nl2br(e($equipment->description)) !!}</p>

    <a href="{{ route('equipments.edit', $equipment) }}" class="btn btn-secondary">Editar</a>
    <a href="{{ route('equipments.index') }}" class="btn btn-link">Volver</a>
</div>
@endsection
