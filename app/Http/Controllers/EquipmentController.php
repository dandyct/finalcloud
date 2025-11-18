<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTA DE EQUIPOS (todos pueden ver)
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $equipments = Equipment::orderBy('created_at', 'desc')->paginate(15);
        return view('equipments.index', compact('equipments'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE CREACIÓN (solo usuarios autenticados)
   |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('equipments.create');
    }

    /*
    |--------------------------------------------------------------------------
    | GUARDAR EQUIPO (creador = usuario logueado)
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:equipments,sku',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,inactive',
            'location' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            // Imagen
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Guardar imagen si existe
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        // Asignar dueño del equipo
        //$data['user_id'] = auth()->id();
        $data['user_id'] = Auth::id();

        Equipment::create($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo creado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | MOSTRAR EQUIPO (cualquiera)
    |--------------------------------------------------------------------------
    */
    public function show(Equipment $equipment)
    {
        return view('equipments.show', compact('equipment'));
    }

    /*
    |--------------------------------------------------------------------------
    | FORMULARIO DE EDICIÓN (solo dueño)
    |--------------------------------------------------------------------------
    */
    public function edit(Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        return view('equipments.edit', compact('equipment'));
    }

    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR EQUIPO (solo dueño)
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para editar este equipo.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:100|unique:equipments,sku,' . $equipment->id,
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance,inactive',
            'location' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',

            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Subir nueva imagen si existe
        if ($request->hasFile('image')) {

            // Borrar imagen anterior
            if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
                Storage::disk('public')->delete($equipment->image);
            }

            $data['image'] = $request->file('image')->store('equipments', 'public');
        }

        $equipment->update($data);

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo actualizado correctamente.');
    }

    /*
    |--------------------------------------------------------------------------
    | ELIMINAR EQUIPO (solo dueño)
    |--------------------------------------------------------------------------
    */
    public function destroy(Equipment $equipment)
    {
        if (!$equipment->isOwnedBy(Auth::user())) {
            abort(403, 'No tienes permiso para eliminar este equipo.');
        }

        // Eliminar imagen física
        if ($equipment->image && Storage::disk('public')->exists($equipment->image)) {
            Storage::disk('public')->delete($equipment->image);
        }

        $equipment->delete();

        return redirect()->route('equipments.index')
            ->with('success', 'Equipo eliminado correctamente.');
    }
}
