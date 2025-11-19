@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Nueva Renta</h1>

    {{-- Errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf

        {{-- EQUIPO --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Equipo</label>
            <select name="equipment_id" class="form-select" required>
                <option value="">-- Selecciona equipo --</option>

                @foreach($equipments as $eq)
                    <option 
                        value="{{ $eq->id }}"
                        @if( old('equipment_id', request('equipment_id')) == $eq->id ) selected @endif
                    >
                        {{ $eq->name }} — 
                        ${{ number_format($eq->price_per_day, 2) }}/día — 
                        Stock: {{ $eq->stock }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- CLIENTE --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Nombre del cliente</label>
            <input 
                type="text" 
                name="customer_name" 
                class="form-control" 
                value="{{ old('customer_name') }}" 
                placeholder="Ej. Juan Pérez"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Contacto</label>
            <input 
                type="text" 
                name="customer_contact" 
                class="form-control" 
                value="{{ old('customer_contact') }}"
                placeholder="Teléfono o email"
            >
        </div>

        {{-- FECHAS --}}
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Inicio</label>
                <input 
                    type="date" 
                    name="start_date" 
                    class="form-control" 
                    value="{{ old('start_date', now()->toDateString()) }}" 
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Fin (opcional)</label>
                <input 
                    type="date" 
                    name="end_date" 
                    class="form-control" 
                    value="{{ old('end_date') }}"
                >
            </div>
        </div>

        {{-- NOTAS --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Notas</label>
            <textarea 
                name="notes" 
                class="form-control" 
                rows="3"
                placeholder="Comentarios adicionales..."
            >{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
