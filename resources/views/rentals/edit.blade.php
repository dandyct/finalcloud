@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Renta #{{ $rental->id }}</h1>

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('rentals.update', $rental) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- EQUIPO --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Equipo</label>
            <select name="equipment_id" class="form-select" required>
                @foreach($equipments as $eq)
                    <option value="{{ $eq->id }}" 
                        {{ old('equipment_id', $rental->equipment_id) == $eq->id ? 'selected' : '' }}>
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
                value="{{ old('customer_name', $rental->customer_name) }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Contacto</label>
            <input 
                type="text" 
                name="customer_contact" 
                class="form-control"
                value="{{ old('customer_contact', $rental->customer_contact) }}"
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
                    value="{{ old('start_date', $rental->start_date) }}"
                    required
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Fin</label>
                <input 
                    type="date" 
                    name="end_date" 
                    class="form-control"
                    value="{{ old('end_date', $rental->end_date) }}"
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
            >{{ old('notes', $rental->notes) }}</textarea>
        </div>

        {{-- ESTADO DE RENTA --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Renta completada</label>
            <div class="form-check">
                <input 
                    class="form-check-input"
                    type="checkbox"
                    name="is_completed"
                    value="1"
                    {{ old('is_completed', $rental->is_completed) ? 'checked' : '' }}
                >
                <label class="form-check-label">Marcar como completada</label>
            </div>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
