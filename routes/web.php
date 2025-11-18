<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirección inicial al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Dashboard (solo usuarios autenticados)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Equipos (solo usuarios autenticados pueden crear/editar/eliminar)
// Pero TODOS podrán verlos (index y show)
Route::resource('equipments', EquipmentController::class)
    ->middleware(['auth'])
    ->except(['index', 'show']);

// Rutas libres para que cualquiera vea los equipos
Route::get('/equipments', [EquipmentController::class, 'index'])->name('equipments.index');
Route::get('/equipments/{equipment}', [EquipmentController::class, 'show'])->name('equipments.show');

// Rentas (solo autenticados)
Route::resource('rentals', RentalController::class)->middleware('auth');

// Crear renta desde un equipo
Route::get('/rentals/create/{equipment}', [RentalController::class, 'createFromEquipment'])
    ->middleware('auth')
    ->name('rentals.createFromEquipment');

// Rutas de perfil
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
