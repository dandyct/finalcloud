@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Equipo</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('equipments.update', $equipment->id) }}" 
          method="POST" 
          enctype="multipart/form-data"
          class="card p-4 shadow-sm">

        @csrf
        @method('PUT')

        {{-- Nombre --}}
        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $equipment->name) }}" required>
        </div>

        {{-- SKU --}}
        <div class="mb-3">
            <label class="form-label">SKU</label>
            <input type="text" name="sku" class="form-control"
                   value="{{ old('sku', $equipment->sku) }}">
        </div>

        {{-- Precio por día --}}
        <div class="mb-3">
            <label class="form-label">Precio por día *</label>
            <input type="number" step="0.01" name="price_per_day"
                   class="form-control"
                   value="{{ old('price_per_day', $equipment->price_per_day) }}"
                   required>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label class="form-label">Stock *</label>
            <input type="number" name="stock"
                   class="form-control"
                   value="{{ old('stock', $equipment->stock) }}"
                   required>
        </div>

        {{-- Estado --}}
        <div class="mb-3">
            <label class="form-label">Estado</label>
            <select name="status" class="form-control">
                <option value="available" {{ $equipment->status === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="rented" {{ $equipment->status === 'rented' ? 'selected' : '' }}>En renta</option>
                <option value="maintenance" {{ $equipment->status === 'maintenance' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="inactive" {{ $equipment->status === 'inactive' ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        {{-- Imagen actual --}}
        @if($equipment->image)
        <div class="mb-3">
            <label class="form-label d-block">Imagen actual</label>
            <img src="{{ asset('storage/' . $equipment->image) }}"
                 alt="Imagen del equipo"
                 style="width: 160px; height: 160px; object-fit: cover; border-radius: 8px;">
        </div>
        @endif

        {{-- Subir nueva imagen --}}
        <div class="mb-4">
            <label class="form-label">Cambiar imagen</label>
            <input type="file" name="image" class="form-control">
            <small class="text-muted">Opcional. Si subes una nueva imagen, reemplazará la actual.</small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-primary">Actualizar</button>
            <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
