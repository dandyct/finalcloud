@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Equipo</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('equipments.update', $equipment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $equipment->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku', $equipment->sku) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Precio por día</label>
            <input type="number" step="0.01" name="price_per_day" class="form-control" value="{{ old('price_per_day', $equipment->price_per_day) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $equipment->stock) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control">
                <option value="available" {{ $equipment->status === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="rented" {{ $equipment->status === 'rented' ? 'selected' : '' }}>En renta</option>
                <option value="maintenance" {{ $equipment->status === 'maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="inactive" {{ $equipment->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection