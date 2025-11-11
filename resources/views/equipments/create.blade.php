@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Nuevo Equipo</h1>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('equipments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Precio por día</label>
            <input type="number" step="0.01" name="price_per_day" class="form-control" value="{{ old('price_per_day', 0) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', 1) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control">
                <option value="available">Disponible</option>
                <option value="rented">En renta</option>
                <option value="maintenance">Mantenimiento</option>
                <option value="inactive">Inactivo</option>
            </select>
        </div>

        <button class="btn btn-primary">Guardar</button>
        <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection