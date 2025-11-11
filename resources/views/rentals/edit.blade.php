@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Renta</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('rentals.update', $rental) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Equipo</label>
            <select name="equipment_id" class="form-control" required>
                @foreach($equipments as $eq)
                    <option value="{{ $eq->id }}" {{ old('equipment_id', $rental->equipment_id) == $eq->id ? 'selected' : '' }}>
                        {{ $eq->name }} ({{ $eq->stock }} disponibles) — {{ number_format($eq->price_per_day,2) }} /día
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Nombre del cliente</label>
            <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $rental->customer_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contacto</label>
            <input type="text" name="customer_contact" class="form-control" value="{{ old('customer_contact', $rental->customer_contact) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Inicio</label>
            <input type="date" name="start_date" class="form-control" value="{{ old('start_date', optional($rental->start_date)->format('Y-m-d')) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fin</label>
            <input type="date" name="end_date" class="form-control" value="{{ old('end_date', optional($rental->end_date)->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control">
                <option value="booked" {{ $rental->status === 'booked' ? 'selected' : '' }}>Booked</option>
                <option value="active" {{ $rental->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ $rental->status === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ $rental->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Notas</label>
            <textarea name="notes" class="form-control">{{ old('notes', $rental->notes) }}</textarea>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection