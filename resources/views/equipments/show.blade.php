@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card shadow-sm p-4">
        <h1 class="mb-4">{{ $equipment->name }}</h1>

        {{-- Imagen del equipo --}}
        @if ($equipment->image)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $equipment->image) }}"
                     alt="Imagen de {{ $equipment->name }}"
                     style="width:330px; height:240px; object-fit:cover; border-radius:10px;">
            </div>
        @endif

        <ul class="list-group mb-4">
            <li class="list-group-item">
                <strong>SKU:</strong> {{ $equipment->sku ?: 'N/A' }}
            </li>
            <li class="list-group-item">
                <strong>Precio por día:</strong> ${{ number_format($equipment->price_per_day, 2) }}
            </li>
            <li class="list-group-item">
                <strong>Stock:</strong> {{ $equipment->stock }}
            </li>
            <li class="list-group-item">
                <strong>Estado:</strong> {{ ucfirst($equipment->status) }}
            </li>
            <li class="list-group-item">
                <strong>Descripción:</strong><br>
                {!! nl2br(e($equipment->description)) !!}
            </li>
        </ul>

        <div class="d-flex gap-2">
            <a href="{{ route('equipments.edit', $equipment->id) }}" class="btn btn-primary">
                Editar
            </a>

            <a href="{{ route('equipments.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </div>
    </div>

</div>
@endsection
