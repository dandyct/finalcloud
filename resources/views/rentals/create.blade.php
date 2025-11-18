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
            <label class="form-label">Equipo</label>
            <select name="equipment_id" class="form-control" required>
                <option value="">-- Selecciona equipo --</option>

                @foreach($equipments as $eq)
                    <option 
                        value="{{ $eq->id }}"
                        @if( old('equipment_id', request('equipment_id')) == $eq->id ) selected @endif
                    >
                        {{ $eq->name }} —
                        ${{ number_format($eq->price_per_day, 2) }}/día —
                        {{ $eq->stock }} disponibles
                    </option>
                @endforeach
            </select>
        </div>

        {{-- CLIENTE --}}
        <div class="mb-3">
            <label class="form-label">Nombre del cliente</label>
            <input 
                type="text" 
                name="customer_name" 
                class="form-control" 
                value="{{ old('customer_name') }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Contacto</label>
            <input 
                type="text" 
                name="customer_contact" 
                class="form-control" 
                value="{{ old('customer_contact') }}"
            >
        </div>

        {{-- FECHAS --}}
        <div class="mb-3">
            <label class="form-label">Inicio</label>
            <input 
                type="date" 
                name="start_date" 
                class="form-control" 
                value="{{ old('start_date', now()->toDateString()) }}" 
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Fin (opcional)</label>
            <input 
                type="date" 
                name="end_date" 
                class="form-control" 
                value="{{ old('end_date') }}"
            >
        </div>

        {{-- NOTAS --}}
        <div class="mb-3">
            <label class="form-label">Notas</label>
            <textarea name="notes" class="form-control">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
