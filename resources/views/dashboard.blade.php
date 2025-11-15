@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            @auth
                <h1 class="display-5">Bienvenido, {{ auth()->user()->name }}</h1>
                <p class="text-muted">¿Qué quieres revisar ahora?</p>
            @else
                <h1 class="display-5">Bienvenido</h1>
                <p class="text-muted">Inicia sesión para acceder al panel y ver tus opciones.</p>
            @endauth
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Equipos</h5>
                    <p class="card-text text-muted">Gestiona el inventario de maquinaria.</p>
                    <a href="{{ route('equipments.index') }}" class="btn btn-primary">Ver equipos</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rentas</h5>
                    <p class="card-text text-muted">Ver y crear rentas.</p>
                    <a href="{{ route('rentals.index') }}" class="btn btn-primary">Ver rentas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Cuenta</h5>
                    <p class="card-text text-muted">Accede a tu perfil y configuración.</p>
                    <a href="{{ route('profile.show') }}" class="btn btn-primary">Mi perfil</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection