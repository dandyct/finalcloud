@extends('layouts.app')

@section('title', 'Editar perfil')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-4">Editar perfil</h1>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                <ul class="list-disc ps-4">
                    @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-gray-300" required>
            </div>

            <div class="flex items-center gap-3">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
                <a href="{{ route('profile.show') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection