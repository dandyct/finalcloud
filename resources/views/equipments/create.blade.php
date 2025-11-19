@extends('layouts.app')

@section('title', 'Nuevo Equipo')

@section('content')
<div class="container" style="max-width: 720px;">

    <h2 class="mb-4">Registrar nuevo equipo</h2>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nombre --}}
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                {{-- SKU --}}
                <div class="mb-3">
                    <label class="form-label">SKU</label>
                    <input type="text" name="sku" class="form-control" value="{{ old('sku') }}">
                </div>

                {{-- Precio --}}
                <div class="mb-3">
                    <label class="form-label">Precio por día *</label>
                    <input type="number" step="0.01" name="price_per_day" class="form-control"
                           value="{{ old('price_per_day', 0) }}" required>
                </div>

                {{-- Stock --}}
                <div class="mb-3">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control"
                           value="{{ old('stock', 1) }}" required>
                </div>

                {{-- Estado --}}
                <div class="mb-3">
                    <label class="form-label">Estado *</label>
                    <select name="status" class="form-select">
                        <option value="available">Disponible</option>
                        <option value="rented">En renta</option>
                        <option value="maintenance">Mantenimiento</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>

                {{-- Descripción --}}
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                {{-- Imagen --}}
                <div class="mb-3">
                    <label class="form-label">Imagen del equipo</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Guardar</button>
                    <a href="{{ route('equipments.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection
