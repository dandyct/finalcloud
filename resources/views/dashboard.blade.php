@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5">Dashboard</h1>
            <p class="text-muted">Bienvenido al panel. Aquí puedes ver accesos rápidos a las secciones principales.</p>
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