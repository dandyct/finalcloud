@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Renta #{{ $rental->id }}</h1>

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
                    <option value="{{ $eq->id }}" 
                        {{ $rental->equipment_id == $eq->id ? 'selected' : '' }}>
                        {{ $eq->name }} — {{ $eq->stock }} disponibles
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cliente</label>
            <input type="text" name="customer_name" class="form-control" 
                   value="{{ old('customer_name', $rental->customer_name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contacto</label>
            <input type="text" name="customer_contact" class="form-control" 
                   value="{{ old('customer_contact', $rental->customer_contact) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Inicio</label>
            <input type="date" name="start_date" class="form-control" 
                   value="{{ old('start_date', $rental->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fin</label>
            <input type="date" name="end_date" class="form-control" 
                   value="{{ old('end_date', $rental->end_date) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Notas</label>
            <textarea name="notes" class="form-control">{{ old('notes', $rental->notes) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Renta completada</label><br>
            <input type="checkbox" name="is_completed" value="1" 
                   {{ $rental->is_completed ? 'checked' : '' }}>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
